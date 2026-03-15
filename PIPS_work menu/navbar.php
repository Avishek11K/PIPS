<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
$username = $_SESSION['Username'] ?? 'Guest';
?>

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
</style>

<header>
    <div class="welcome">
        Welcome, <?php echo htmlspecialchars($username); ?>
    </div>

    <!-- <a href="admin.php" class="system-name">Home</a> -->

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="listing.php">Listing</a>
         <a href="view_saved.php">View saved</a>
          <a href="home.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</header>
