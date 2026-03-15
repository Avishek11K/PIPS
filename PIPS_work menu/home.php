<?php
session_start();
require_once("db.php");

// if(!isset($_SESSION["role"]) || $_SESSION["role"] != "user"){
//     header("Location:index.php");
//     exit();
// }

if(!isset($_SESSION["Username"])){
    header("Location:index.php");
    exit();
}


/* Fetch dynamic categories from database */
$sql = "SELECT category, page_url FROM categorization ORDER BY category ASC";
$res = mysqli_query($connection, $sql);

$dbCategories = [];
while($row = mysqli_fetch_assoc($res)){
    $dbCategories[] = $row;
}



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
<title>PIPS - Home</title>

<style>

body{margin:0;font-family:'Segoe UI',sans-serif;background:#f0f2f5}

/* HEADER */
header{
background:#2e7d32;
color:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
}

header a{
color:white;
text-decoration:none;
margin-left:15px;
font-weight:600
}

.topbar{
display:flex;
align-items:center;
}

.welcome{
margin:0;
font-weight:bold;
}

.links a{
margin-left:15px;
text-decoration:none;
}

/* MAIN */

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

/* SEARCH */

.search-box{
text-align:center;
margin-bottom:30px
}

.search-box input{
width:60%;
padding:13px;
border-radius:30px;
border:1px solid #ccc;
font-size:16px
}

/* FIXED CATEGORIES */

.fixed-categories{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
gap:20px;
margin-bottom:30px;
}

.fixed-categories .card{
background:#fff;
padding:20px;
border-radius:12px;
text-align:center;
font-weight:600;
cursor:pointer;
box-shadow:0 5px 12px rgba(0,0,0,0.1);
transition:0.3s;
}

.fixed-categories .card:hover{
background:#e8f5e9;
transform:translateY(-5px);
}

.system-name{
font-size:26px;
font-weight:700;
color:white;
text-decoration:none;
cursor:pointer;
}

/* DB CATEGORY */

#dbCategoryList{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
gap:20px;
}

#dbCategoryList .db-card{
background:#fff;
padding:20px;
border-radius:12px;
text-align:center;
font-weight:600;
cursor:pointer;
box-shadow:0 5px 12px rgba(0,0,0,0.1);
display:none;
transition:0.3s;
}

#dbCategoryList .db-card:hover{
background:#e8f5e9;
transform:translateY(-5px);
}

/* FOOTER */

footer{
margin-top:50px;
padding:15px;
text-align:center;
background:#2e7d32;
color:white;
font-size:14px;
}

footer a{
color:#a5d6a7;
text-decoration:none
}

</style>
</head>

<body>

<header>

<p class="welcome">
Welcome, <?php echo $_SESSION['Username']; ?>
</p>

<a href="home.php" class="system-name">
PIPS
</a>

<div class="topbar">

<div class="links">
<a href="dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
<a href="about.php">About PIPS</a>
</div>

</div>

</header>


<div class="container">

<h2 style="text-align:center;color:#1b5e20">
Personal Inventory Planning System
</h2>

<p style="text-align:center;color:#555;margin-bottom:30px">
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


<!-- SEARCH BAR -->

<div class="search-box">
<input type="text" id="search" placeholder="Search category..." onkeyup="filterDbCategories()">
</div>


<!-- FIXED CATEGORIES -->

<div class="fixed-categories">

<div class="card" onclick="go('all')">All (Mix)</div>
<div class="card" onclick="go('fruits')">Fruits</div>
<div class="card" onclick="go('vegetables')">Vegetables</div>
<div class="card" onclick="go('beverages')">Beverages</div>
<div class="card" onclick="go('snacks')">Snacks</div>
<div class="card" onclick="go('Attires')">Attires</div>
<div class="card" onclick="go('Bakery')">Bakery</div>
<div class="card" onclick="go('Seafood')">Seafood</div>

</div>


<!-- DYNAMIC DB CATEGORIES -->

<div id="dbCategoryList">

<?php foreach($dbCategories as $cat): ?>

<div class="db-card"
data-name="<?= strtolower($cat['category']) ?>"
onclick="go('<?= $cat['category'] ?>')">

<?= htmlspecialchars($cat['category']) ?>

</div>

<?php endforeach; ?>

</div>

</div>


<footer>

&copy; 2025 PIPS | 
<a href="about.php">About PIPS</a>

</footer>


<script>

function go(cat){

window.location.href =
"listing.php?category=" + encodeURIComponent(cat);

}

function filterDbCategories(){

let input =
document.getElementById("search").value.toLowerCase();

let items =
document.querySelectorAll(".db-card");

items.forEach(item=>{

let name =
item.getAttribute("data-name");

item.style.display =
(input !== "" && name.includes(input))
? "block"
: "none";

});

}

</script>

</body>
</html>