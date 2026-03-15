<?php
session_start();
include("navbar.php");
require_once("db.php");

if(!isset($_SESSION['User_id'])){
    header("Location:index.php");
    exit();
}
$user_id=$_SESSION['User_id'];
$username = $_SESSION['Username'] ?? 'Demo';
$email = $_SESSION['email'] ?? 'demo@example.com';
?>
<?php
$category = $_GET['category'] ?? '';
$_SESSION['category'] = $category;   // store for later use

?>
<html>
<head>
<meta charset="UTF-8">
<title>Inventory Table</title>
<style>
h2{
    color:#2e7d32;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    border-radius:8px;
    overflow:hidden;
}

th,td{
    padding:12px;
    border-bottom:1px solid #e0e0e0;
    text-align:center;
}

th{
    background:#2e7d32;
    color:white;
    font-weight:600;
}

tr:hover{
    background:#f9f9f9;
}

input[type="number"],
input[type="text"],
select{
    width:100px;
    padding:6px;
    border:1px solid #ccc;
    border-radius:4px;
}

button{
    padding:6px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:13px;
}

button.add{
    background:#4CAF50;
    color:white;
}

button.delete{
    background:#e53935;
    color:white;
}

button.edit{
    background:#ff9800;
    color:white;
}

button.update{
    background:#1e88e5;
    color:white;
}

button.final{
    background:#1b5e20;
    color:white;
    padding:10px 25px;
    margin-top:15px;
}
button.view{
    background:#1b5e20;
    color:white;
    padding:10px 25px;  
    margin-top:15px;
    float:right;
}

.action-btns button{
    margin:2px;
}
</style>

</head>
<body>

<h2>Inventory Table : <?= htmlspecialchars($category) ?></h2>



<table id="invTable">
<tr>
<th>S.No</th>
<th>Name</th>
<th>Qty</th>
<th>Price</th>
<th>Status</th>
<th>Total</th>
<th>Action</th>
</tr>
<!-- Existing rows can be fetched from DB if needed -->
</table>


<br>
<button class="add" onclick="addRow()">Add Item</button>
<button class="final" onclick="finalSave()">Save</button>
<button class="view"
onclick="window.location.href='dashboard.php?category=<?= urlencode($category) ?>'">
Dashboard
</button>


<?php
if(isset($_POST['view'])){
header("Location:dashboard.php");
exit();
}
?>

<script>
// Add new row
let sn = 1;
function addRow(){
    let table = document.getElementById('invTable');
    let row = table.insertRow(-1);

    row.innerHTML = `
        <td>${sn++}</td>
        <td><input type="text" class="name"></td>
        <td><input type="number" class="qty" value="1" min="1"></td>
        <td><input type="number" class="price" value="0" step="0.01"></td>
        <td>
            <select class="status">
                <option value="noted">Noted</option>
                <option value="purchased">Purchased</option>
            </select>
        </td>
        <td class="total">0</td>
        <td class="action-btns">
            <button class="edit" onclick="editRow(this)">Edit</button>
            <button class="update" onclick="updateRow(this)" disabled>Update</button>
            <button class="delete" onclick="deleteRow(this)">Delete</button>
        </td>
    `;

    attachEvents(row);
}
function editRow(btn){
    let row = btn.closest('tr');
    row.querySelectorAll('input, select').forEach(el=>{
        el.disabled = false;
    });
    row.querySelector('.update').disabled = false;
}
function updateRow(btn){
    let row = btn.closest('tr');

    row.querySelectorAll('input, select').forEach(el=>{
        el.disabled = true;
    });

    btn.disabled = true;
}


// Delete row
function deleteRow(btn){
    btn.closest('tr').remove();
    updateSerialNumbers();
}

// Update total on qty or price change
function attachEvents(row){
    let qtyInput = row.querySelector('.qty');
    let priceInput = row.querySelector('.price');
    [qtyInput, priceInput].forEach(input=>{
        input.addEventListener('input', ()=>{
            let qty = parseFloat(row.querySelector('.qty').value);
            let price = parseFloat(row.querySelector('.price').value);
            row.querySelector('.total').innerText = (qty*price).toFixed(2);
        });
    });
}

// Update serial numbers
function updateSerialNumbers(){
    let rows = document.querySelectorAll('#invTable tr');
    for(let i=1; i<rows.length; i++){
        rows[i].cells[0].innerText = i;
    }
    sn = rows.length;
}

// Final Save → send to server
function finalSave(){
    let rows = document.querySelectorAll('#invTable tr');
    let data = [];
    for(let i=1; i<rows.length; i++){ // skip header
        let r = rows[i];
        let name = r.querySelector('.name').value.trim();
        if(name=="") continue;
        let qty = parseInt(r.querySelector('.qty').value);
        let price = parseFloat(r.querySelector('.price').value);
        let status = r.querySelector('.status').value;
        let total = qty*price;
        data.push({name, qty, price, status, total});
    }
    if(data.length==0){ alert('No items to save'); return; }

    let form = document.createElement('form');
    form.method='POST';
    form.action='save_manual.php';
    form.appendChild(createInput('items', JSON.stringify(data)));
    document.body.appendChild(form);
    form.submit();
}

function createInput(name,value){
    let input = document.createElement('input');
    input.type='hidden';
    input.name=name;
    input.value=value;
    return input;
}
</script>

</body>
</html>

