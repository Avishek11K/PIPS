<?php
require_once("db.php");

/* get correct id */
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die("Invalid request");
}

/*update logic */
if (isset($_POST['update'])) {
    $category = trim($_POST['category']);
    $page_url = trim($_POST['page_url']);

    mysqli_query(
        $connection,
        "UPDATE categorization
         SET category='$category', page_url='$page_url'
         WHERE Categorization_id=$id"
    );

    header("Location: categorization.php");
    exit();
}

/*fetch existing data */
$result = mysqli_query(
    $connection,
    "SELECT * FROM categorization WHERE Categorization_id=$id"
);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Category not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Category</title>
<style>
body{font-family:Segoe UI;background:#f4f6f8;padding:20px;}
form{background:#fff;padding:20px;width:400px;margin:auto;box-shadow:0 3px 10px rgba(0,0,0,0.1);}
input{width:100%;padding:8px;margin-bottom:10px;}
button{background:#1b5e20;color:#fff;border:none;padding:10px;width:100%;cursor:pointer;}
button:hover{background:#145214;}
</style>
</head>

<body>

<h2 style="text-align:center;">Edit Category</h2>

<form method="POST">
    <label>Category Name</label>
    <input type="text" name="category"
        value="<?= htmlspecialchars($data['category']) ?>" required>

    <label>Page URL</label>
    <input type="text" name="page_url"
        value="<?= htmlspecialchars($data['page_url']) ?>" required>

    <button name="update">Update Category</button>
</form>

</body>
</html>
