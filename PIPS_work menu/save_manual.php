<?php
session_start();
require_once("db.php");

// redirect if not logged in
if(!isset($_SESSION['User_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['User_id'];

if(isset($_POST['items'])){
    $items = json_decode($_POST['items'], true);

    if(!empty($items)){
        foreach($items as $item){
            $name   = mysqli_real_escape_string($connection, $item['name']);
            $category=$_SESSION['category'];
            $qty    = (int)$item['qty'];
            $price  = (float)$item['price'];
            $status = mysqli_real_escape_string($connection, $item['status']);
            $total  = $qty * $price;

            $sql = "INSERT INTO products (User_id,category, name, qty, price, status, total, created_at)
                    VALUES ('$user_id','$category','$name','$qty','$price','$status','$total', NOW())";
            mysqli_query($connection, $sql);
        }
    }

    header("Location: view_saved.php");
    exit();
}
?>

