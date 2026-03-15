<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['Username'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add'])){
    $category = trim($_POST['category']);
    $page_url = trim($_POST['page_url']);

    mysqli_query(
        $connection,
        "INSERT INTO categorization (category, page_url)
         VALUES ('$category', '$page_url')"
    );

    header("Location: categorization.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Category</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;padding:20px;}
form{background:#fff;padding:20px;width:400px;margin:auto;box-shadow:0 3px 10px rgba(0,0,0,0.1);}
input{width:100%;padding:8px;margin-bottom:10px;}
button{background:#1b5e20;color:white;border:none;padding:10px;width:100%;cursor:pointer;}
button:hover{background:#145214;}
</style>
</head>

<body>

<h2 style="text-align:center;">Add Category</h2>

<form method="POST">
    <label>Category Name</label>
    <input type="text" name="category" required>

    <label>Page URL</label>
    <input type="text" name="page_url" placeholder="listing.php?category=fruits" required>

    <button name="add">Add Category</button>
</form>

</body>
</html>
