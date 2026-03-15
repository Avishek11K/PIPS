<?php
session_start();
include("navbar.php");
require_once("db.php");

if(!isset($_SESSION['User_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['User_id'];
$username = $_SESSION['Username'] ?? 'User';


if (isset($_GET['category'])) {
    $_SESSION['category'] = $_GET['category'];
}


// fetch all saved items for the user
$sql = "SELECT * FROM products WHERE User_id='$user_id' ORDER BY created_at ASC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Saved Items</title>
<style>
/* body{font-family:Segoe UI; background:#f0f2f5; padding:20px;} */
table{width:100%; border-collapse:collapse; background:#fff; box-shadow:0 3px 10px rgba(0,0,0,0.1);}
th,td{padding:12px; border:1px solid #ddd; text-align:center;}
th{background:#2e7d32; color:white;}
button.view{
    background:#1b5e20;
    color:white;
    padding:10px 25px;
    margin-top:15px;
    float:right;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
button.views{
    background:#1b5e20;
    color:white;
    padding:10px 25px;
    margin-top:15px;
    float:left;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
</style>
</head>
<body>

<h2>Saved Items for <?= htmlspecialchars($username) ?></h2>

<table>
<tr>
    <th>S.No</th>
    <th>Item</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Status</th>
    <th>Total</th>
    <th>Saved At</th>
</tr>

<?php
$sn=1;
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $created = $row['created_at'] ?? '';
        echo "<tr>
                <td>{$sn}</td>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>{$row['qty']}</td>
                <td>{$row['price']}</td>
                <td>{$row['STATUS']}</td>
                <td>{$row['total']}</td>
                <td>{$created}</td>
              </tr>";
        $sn++;
    }
}else{
    echo "<tr><td colspan='7'>No items saved</td></tr>";
}
?>
</table>

<?php

$category = $_SESSION['category'] ?? '';
?>
<button class="view" onclick="window.location.href='dashboard.php'">View Dashboard</button>

</body>
</html>

