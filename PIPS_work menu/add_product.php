<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['Username'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add'])){
    $name   = trim($_POST['name']);
    $qty    = (int)$_POST['qty'];
    $price  = (float)$_POST['price'];
    $status = $_POST['status'];

    mysqli_query(
        $connection,
        "INSERT INTO products (name, qty, price, status)
         VALUES ('$name', $qty, $price, '$status')"
    );

    header("Location: product.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;padding:20px;}
form{background:#fff;padding:20px;width:400px;margin:auto;box-shadow:0 3px 10px rgba(0,0,0,0.1);}
input,select{width:100%;padding:8px;margin-bottom:10px;}
button{background:#1b5e20;color:white;border:none;padding:10px;width:100%;cursor:pointer;}
button:hover{background:#145214;}
</style>
</head>

<body>

<h2 style="text-align:center;">Add Product</h2>

<form method="POST">
    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Quantity</label>
    <input type="number" name="qty" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price" required>

    <label>Status</label>
    <select name="status">
        <option value="noted">Noted</option>
        <option value="purchased">Purchased</option>
    </select>

    <button name="add">Add Product</button>
</form>

</body>
</html>

