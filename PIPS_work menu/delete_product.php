<?php
require_once("db.php");

$id = (int)($_GET['id'] ?? 0);
if($id > 0){
    mysqli_query($connection, "DELETE FROM products WHERE Product_id=$id");
}

header("Location: product.php");
exit();
