<?php
require_once("db.php");

$id = (int)($_GET['id'] ?? 0);
if($id <= 0){
    die("Invalid request");
}

if(isset($_POST['update'])){
    $name   = trim($_POST['name']);
    $qty    = (int)$_POST['qty'];
    $price  = (float)$_POST['price'];
    $status = $_POST['status'];

    mysqli_query(
        $connection,
        "UPDATE products
         SET name='$name',
             qty=$qty,
             price=$price,
             status='$status'
         WHERE Product_id=$id"
    );

    header("Location: product.php");
    exit();
}

$data = mysqli_fetch_assoc(
    mysqli_query($connection,
        "SELECT * FROM products WHERE Product_id=$id")
);

if(!$data){
    die("Product not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<style>
body{
    font-family:Segoe UI;
    background:#f4f6f8;
    padding:20px;
}
form{
    background:#fff;
    padding:20px;
    width:400px;
    margin:auto;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}
input,select{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}
button{
    background:#1b5e20;
    color:#fff;
    border:none;
    padding:10px;
    width:100%;
    cursor:pointer;
}
button:hover{
    background:#145214;
}
</style>
</head>

<body>

<h2 style="text-align:center;">Edit Product</h2>

<form method="POST">
    <label>Product Name</label>
    <input type="text" name="name"
        value="<?= htmlspecialchars($data['name']) ?>" required>

    <label>Quantity</label>
    <input type="number" name="qty"
        value="<?= $data['qty'] ?>" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price"
        value="<?= $data['price'] ?>" required>

    <label>Status</label>
    <select name="status">
        <option value="noted" <?= $data['STATUS']=='noted'?'selected':'' ?>>Noted</option>
        <option value="purchased" <?= $data['STATUS']=='purchased'?'selected':'' ?>>Purchased</option>
    </select>

    <button name="update">Update Product</button>
</form>

</body>
</html>
