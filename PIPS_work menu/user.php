<?php
session_start();
include("nav_bar.php");
require_once("db.php");

/* Admin check */
if (!isset($_SESSION['Username'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM users ORDER BY User_id DESC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Users</title>
<style>
/* body{font-family:Segoe UI;background:#f4f6f8;padding:20px;} */
table{width:100%;border-collapse:collapse;background:#fff;}
th,td{padding:12px;border:1px solid #ccc;text-align:center;}
th{background:#1b5e20;color:white;}
.btn{
    padding:6px 12px;
    border:none;
    cursor:pointer;
    border-radius:4px;
}
.edit{background:#2196F3;color:white;}
.delete{background:#f44336;color:white;}
.add{background:#4CAF50;color:white;margin-bottom:10px;}
</style>
</head>

<body>

<h2>User Management</h2>

<button class="btn add" onclick="location.href='add_user.php'">+ Add User</button>

<table>
<tr>
    <th>S.No</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
</tr>

<?php
$sn = 1;
while ($row = mysqli_fetch_assoc($result)):
?>
<tr>
    <td><?= $sn++ ?></td>
    <td><?= htmlspecialchars($row['Username']) ?></td>
    <td><?= htmlspecialchars($row['Email']) ?></td>
    <td><?= htmlspecialchars($row['role']) ?></td>
    <td>
        <button class="btn edit"
            onclick="location.href='edit_user.php?id=<?= $row['User_id'] ?>'">
            Edit
        </button>

        <button class="btn delete"
            onclick="if(confirm('Delete this user?')){
                location.href='delete_user.php?id=<?= $row['User_id'] ?>'
            }">
            Delete
        </button>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
