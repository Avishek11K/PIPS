

<?php
session_start();  
require_once("db.php");

// Admin access check
if(!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"){
    header("Location:index.php");
    exit();
}

// Admin info
$Username = $_SESSION["Username"] ?? 'Username not found';
$Email    = $_SESSION["email"] ?? 'Email not found';




$notifSql = "SELECT u.username, u.email,n.message, n.created_at 
             FROM notifications n
             JOIN users u ON u.User_id = n.user_id
             ORDER BY n.created_at DESC LIMIT 5";// for latest five or some numeric:LIMIT 5;
$notifRes = mysqli_query($connection, $notifSql);


/* Total Users */
$userQuery = mysqli_query($connection,"SELECT COUNT(*) AS total_users FROM users");
$userData = mysqli_fetch_assoc($userQuery);
$totalUsers = $userData['total_users'];

/* Total Categories */
$catQuery = mysqli_query($connection,"SELECT COUNT(*) AS total_cat FROM categorization");
$catData = mysqli_fetch_assoc($catQuery);
$totalCategories = $catData['total_cat'];

/* Total Stock Items (different items count) */
$stockQuery = mysqli_query($connection, "SELECT COUNT(*) AS total_stock FROM products");
$stockData = mysqli_fetch_assoc($stockQuery);
$totalStock = $stockData['total_stock'];


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PIPS - Admin</title>
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f0f2f5}
.system-name{
font-size:26px;
font-weight:700;
color:white;
text-decoration:none;
cursor:pointer;
}


/* HEADER */
header{
    background:#2e7d32;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
header a{color:white;text-decoration:none;margin-left:15px;font-weight:600}
header .center{font-size:26px;font-weight:800}

.topbar { display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; }
.welcome { margin: 0; font-weight: bold; }
.links a { margin-left: 15px; text-decoration: none; }

/* CONTAINER */
.container{
    max-width:900px;
    margin:auto;
    padding:40px;
    background:#f4f4f4;
}

/* BUTTONS */
.arrange {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom:30px;
}
.nav {
    padding: 12px 28px;
    font-size: 18px;
    font-weight: 500;
    color: #fff;
    background: #1b5e20;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.nav:hover {
    background: #145214;
    transform: translateY(-2px);
    box-shadow: 0 6px 10px rgba(0,0,0,0.15);
}



/*start*/

.container{
/* display:flex;
gap:40px;
align-items:flex-start; */
max-width:900px;
margin:auto;
padding:40px;
}

/* DASHBOARD STATS */

.stats-container{


display:flex;
justify-content:center;
gap:20px;
margin-bottom:40px;
flex-wrap:wrap;
/* flex:0 0 220px; 
flex-direction:column; */
}

.stat-card{
background:white;
padding:25px;
/* float:left; */
border-radius:12px;
width:180px;
text-align:center;
box-shadow:0 5px 12px rgba(0,0,0,0.1);
transition:0.3s;
}

.stat-card:hover{
background:#e8f5e9;
transform:translateY(-5px);
}

.stat-card h2{
margin:0;
font-size:30px;
color:#1b5e20;
}

.stat-card p{
margin-top:5px;
font-weight:600;
color:#555;
}


/*end*/

/* NOTIFICATION BOX */
#notification-box{
    position: fixed;
    top: 80px;
    right: 20px;
    width: 300px;
    max-height: 400px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    overflow-y: auto;
    z-index: 9999;
}
#notif-header{
    background:#2e7d32;
    color:white;
    font-weight:bold;
    padding:10px;
    border-radius:12px 12px 0 0;
    text-align:center;
}
#notif-list{list-style:none;margin:0;padding:10px;}
#notif-list li{
    padding:8px 5px;
    border-bottom:1px solid #eee;
    font-size:14px;
}
#notif-list li:hover{background:#f0f2f5;cursor:pointer;}

/* FOOTER */
footer{
    margin-top:50px;
    padding:15px;
    text-align:center;
    background:#2e7d32;
    color:white;
    font-size:14px;
}
footer a{color:#a5d6a7;text-decoration:none}


</style>
</head>
<body>

<header>
<p class="welcome">Admin,<br><?php echo $Username . " || " . $Email; ?></p>
<a href="admin.php" class="system-name">PIPS</a>
<div class="topbar">
    <div class="links">
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
        <a href="about.php">About PIPS</a>
    </div>
</div>
</header>

<div class="container">
<h2 style="text-align:center;color:#1b5e20">Personal Inventory Planning System</h2>
<p style="text-align:center;color:#555;margin-bottom:50px">
Organize • Track • Manage your inventory efficiently
</p>


<div class="stats-container">

<div class="stat-card">
<h2><?php echo $totalUsers; ?></h2>
<p>Total Users</p>
</div>

<div class="stat-card">
<h2><?php echo $totalCategories; ?></h2>
<p>Categories</p>
</div>

<div class="stat-card">
<h2><?php echo $totalStock; ?></h2>
<p>Stock Items</p>
</div>

</div>







<div class="arrange">
    <button class="nav" onclick="location.href='categorization.php'">Categorization</button>
    <button class="nav" onclick="location.href='user.php'">User</button>
    <button class="nav" onclick="location.href='product.php'">Product</button>
</div>
</div>


<div id="notification-box">
<div id="notif-header">Last User Logins</div>
<ul id="notif-list">
<?php
$count = 1;
while($row = mysqli_fetch_assoc($notifRes)):
?>
<li>
<strong><?= $count ?>.</strong> <?= htmlspecialchars($row['username']) ?> (<?= htmlspecialchars($row['email']) ?>) logged in at <?= $row['created_at'] ?>
</li>
<?php $count++; endwhile; ?>
</ul>
</div>



<footer>
&copy; 2025 PIPS | <a href="about.php">About PIPS</a> 
</footer>

</body>
</html>





