<?php
session_start();
include("nav_bar.php");
require_once("db.php");

/* admin check (optional but recommended) */
if(!isset($_SESSION['Username'])){
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM categorization ORDER BY Categorization_id DESC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Categorization</title>
<style>
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

<h2>Category Management</h2>

<button class="btn add" onclick="location.href='add_category.php'">+ Add Category</button>

<table>
<tr>
    <th>S.No</th>
    <th>Category</th>
    <th>Page URL</th>
    <th>Remarks</th>
</tr>

<?php
$sn = 1;
while($row = mysqli_fetch_assoc($result)):
?>
<tr>
    <td><?= $sn++ ?></td>
    <td><?= htmlspecialchars($row['category']) ?></td>
    <td><?= htmlspecialchars($row['page_url']) ?></td>
    <td>
        <button class="btn edit"
            onclick="location.href='edit_category.php?id=<?= $row['Categorization_id'] ?>'">
            Edit
        </button>

        <button class="btn delete"
            onclick="if(confirm('Delete this category?')){
                location.href='delete_category.php?id=<?= $row['Categorization_id'] ?>'
            }">
            Delete
        </button>
    </td>
</tr>
<?php endwhile; ?>
</table>




