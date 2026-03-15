<?php
session_start();
include("nav_bar.php");
require_once("db.php");

if(!isset($_SESSION['Username'])){
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM products ORDER BY Product_id DESC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Products</title>
<style>
/* body{font-family:Segoe UI;background:#f4f6f8;padding:20px;} */
table{width:100%;border-collapse:collapse;background:#fff;}
th,td{padding:12px;border:1px solid #ccc;text-align:center;}
th{background:#1b5e20;color:white;}
.btn{padding:6px 12px;border:none;cursor:pointer;border-radius:4px;}
.edit{background:#2196F3;color:white;}
.delete{background:#f44336;color:white;}
.add{background:#4CAF50;color:white;margin-bottom:10px;}
</style>
</head>

<body>

<h2>Product Management</h2>

<button class="btn add" onclick="location.href='add_product.php'">+ Add Product</button>

<table>
<tr>
    <th>S.No</th>
    <th>Name</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php $sn=1; while($row=mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $sn++ ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= $row['qty'] ?></td>
    <td><?= $row['price'] ?></td>
    <td><?= ucfirst($row['STATUS']) ?></td>
    <td>
        <button class="btn edit"
            onclick="location.href='edit_product.php?id=<?= $row['product_id'] ?>'">
            Edit
        </button>

        <button class="btn delete"
            onclick="if(confirm('Delete this product?')){
                location.href='delete_product.php?id=<?= $row['product_id'] ?>'
            }">
            Delete
        </button>
    </td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
