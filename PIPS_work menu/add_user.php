<?php
session_start();
require_once("db.php");

if(!isset($_SESSION['Username'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add'])){
    $username = trim($_POST['Username']);
    $email    = trim($_POST['Email']);
    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    $role     = $_POST['Role'];

    mysqli_query(
        $connection,
        "INSERT INTO users (Username, email, Pass_word, role)
         VALUES ('$username', '$email', '$password', '$role')"
    );

    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;padding:20px;}
form{background:#fff;padding:20px;width:400px;margin:auto;box-shadow:0 3px 10px rgba(0,0,0,0.1);}
input,select{width:100%;padding:8px;margin-bottom:10px;}
button{background:#1b5e20;color:white;border:none;padding:10px;width:100%;cursor:pointer;}
button:hover{background:#145214;}
</style>
</head>

<body>

<h2 style="text-align:center;">Add User</h2>

<form method="POST">
    <label>Username</label>
    <input type="text" name="Username" required>

    <label>Email</label>
    <input type="email" name="Email" required>

    <label>Password</label>
    <input type="password" name="Password" required>

    <label>Role</label>
    <select name="Role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button name="add">Add User</button>
</form>

</body>
</html>
