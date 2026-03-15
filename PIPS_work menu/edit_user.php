<?php
require_once("db.php");

/* 1️⃣ get correct id */
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die("Invalid request");
}

/* 2️⃣ update logic */
if (isset($_POST['update'])) {
    $username = trim($_POST['Username']);
    $email    = trim($_POST['Email']);
    $role     = trim($_POST['role']);

    mysqli_query(
        $connection,
        "UPDATE users
         SET Username='$username',
             email='$email',
             role='$role'
         WHERE User_id=$id"
    );

    header("Location: user.php");
    exit();
}

/* 3️⃣ fetch existing data */
$result = mysqli_query(
    $connection,
    "SELECT * FROM users WHERE User_id=$id"
);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;padding:20px;}
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
    margin-bottom:12px;
}
button{
    background:#1b5e20;
    color:#fff;
    border:none;
    padding:10px;
    width:100%;
    cursor:pointer;
}
button:hover{background:#145214;}
</style>
</head>

<body>

<h2 style="text-align:center;">Edit User</h2>

<form method="POST">

    <label>Username</label>
    <input type="text" name="Username"
        value="<?= htmlspecialchars($data['Username']) ?>" required>

    <label>Email</label>
    <input type="email" name="Email"
        value="<?= htmlspecialchars($data['Email']) ?>" required>

    <label>Role</label>
    <select name="role">
        <option value="user" <?= $data['role']=='user'?'selected':'' ?>>User</option>
        <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
    </select>

    <button name="update">Update</button>
</form>

</body>
</html>
