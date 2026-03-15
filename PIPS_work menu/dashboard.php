
<?php
session_start();
require_once("db.php");
if (isset($_GET['category'])) {
    $_SESSION['category'] = $_GET['category'];
}

$category = $_SESSION['category'] ?? '';

if(!isset($_SESSION['User_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['User_id'];
$username = $_SESSION['Username'] ?? 'User';
$email= $_SESSION['email'] ;

// fetch saved items grouped by created_at (time only)
$sql = "SELECT * FROM products WHERE User_id='$user_id' ORDER BY created_at DESC";
$result = mysqli_query($connection, $sql);

// create an array grouped by save time (hh:mm)
$groups = [];
while($row = mysqli_fetch_assoc($result)){
    // use full datetime for grouping
    $time = date("Y-m-d H:i", strtotime($row['created_at']));
    $groups[$time][] = $row;
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
    body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f0f2f5;
}

/* HEADER */
header{
    background:#2e7d32;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 3px 8px rgba(0,0,0,0.2);
}

/* Left Welcome */
.welcome{
    font-weight:600;
    font-size:14px;
}

/* Center Logo */
.system-name{
    font-size:24px;
    font-weight:800;
    color:white;
    text-decoration:none;
}

.system-name:hover{
    color:#c8e6c9;
}

/* Right Links */
.nav-links a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
    transition:0.3s;
}

.nav-links a:hover{
    color:#c8e6c9;
}

/* Responsive */
@media(max-width:768px){
    header{
        flex-direction:column;
        gap:10px;
        text-align:center;
    }
}
.container{background:#fff; padding:20px; margin-bottom:20px; box-shadow:0 3px 10px rgba(0,0,0,0.1);}
h2{color:#2e7d32;}
table{width:100%; border-collapse:collapse; margin-top:10px;}
th,td{padding:10px; border:1px solid #ccc; text-align:center;}
th{background:#2e7d32; color:white;}
.status-noted{color:#ff9800; font-weight:bold;}
.status-purchased{color:#4CAF50; font-weight:bold;}
.logs{float:left;background:#1b5e20;justify-content:space-between;color:white;padding:10px 25px;margin-top:25px;margin-right:10px;}
.log{float:right;background:#1b5e20;color:white;padding:10px 25px;margin-top:25px;}

.count-links a{margin-right:10px; text-decoration:none; font-weight:bold; color:#1b5e20;}
</style>

</head>
<header>
    <div class="welcome">
        Welcome, <?php echo htmlspecialchars($username); ?>
    </div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</header>
<body>
<h1>
    <?php $email = $_SESSION['email'] ?? 'email not found'; ?>
    Dashboard for: <?= htmlspecialchars($username) ?>
        (<?= htmlspecialchars($email) ?>)
    </span>
</h1>


<?php if(!empty($groups)): ?>
    <?php foreach($groups as $time => $items): ?>
        <?php
            // Count noted and purchased
            $noted = $purchased = 0;
            foreach($items as $item){
                if(strtolower($item['STATUS']) === 'noted') $noted++;
                if(strtolower($item['STATUS']) === 'purchased') $purchased++;
            }
        ?>
        <div class="container">
            <h2>Saved at: <?= date("l, d M Y, h:i A", strtotime($time)) ?></h2>
            <p>Total Items: <?= count($items) ?></p>
            <div class="count-links">
                <a href="view_saved.php?status=noted&time=<?= urlencode($time) ?>">Noted: <?= $noted ?></a>
                <a href="view_saved.php?status=purchased&time=<?= urlencode($time) ?>">Purchased: <?= $purchased ?></a>
            </div>
            <table>
                <tr>
                    <th>S.No</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
                <?php $sn=1; foreach($items as $row): ?>
                <tr>
                    <td><?= $sn++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td class="status-<?= strtolower($row['STATUS']) ?>"><?= ucfirst($row['STATUS']) ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No items saved yet.</p>
<?php endif; ?>

</body>
</html>

