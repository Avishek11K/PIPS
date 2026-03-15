<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About PIPS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: #f0f2f5;
        color: #333;
        line-height: 1.6;
    }

    /* Navigation Bar */
    .navbar {
        background: #4CAF50;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    .navbar .logo {
        font-size: 22px;
        font-weight: bold;
    }

    .navbar ul {
        list-style: none;
        display: flex;
        gap: 20px;
    }

    .navbar ul li a {
        color: #fff;
        text-decoration: none;
        font-size: 16px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: 0.3s;
    }

    .navbar ul li a:hover {
        background: rgba(255,255,255,0.2);
    }

    /* Header */
    header {
        background: #e8f5e9;
        padding: 40px 20px;
        text-align: center;
    }

    header h1 {
        color: #4CAF50;
        font-size: 32px;
    }

    header p {
        font-size: 16px;
        margin-top: 8px;
        color: #555;
    }

    /* Main Container */
    .container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .container h2 {
        color: #4CAF50;
        margin-bottom: 15px;
    }

    .container p {
        margin-bottom: 20px;
        font-size: 16px;
    }

    /* Feature List */
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .feature-box {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        border-left: 5px solid #4CAF50;
        transition: 0.3s;
    }

    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .feature-box h3 {
        margin-bottom: 10px;
        color: #333;
    }

    /* Footer */
    footer {
        margin-top: 40px;
        text-align: center;
        padding: 15px;
        background: #4CAF50;
        color: #fff;
    }

    footer a {
        color: #4CAF50;
        text-decoration: none;
    }
</style>
</head>

<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="logo">PIPS</div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="about.php">About PIPS</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<header>
    <h1>About PIPS</h1>
    <p>Personal Inventory Planning System</p>
</header>

<div class="container">
    <h2>What is PIPS?</h2>
    <p>
        Personal Inventory Planning System(PIPS) is a web-based application designed
        to help users organize and manage inventory efficiently using a
        category-based listing approach.
    </p>

    <h2>Key Features</h2>
    <div class="features">
        <div class="feature-box">
            <h3>Category Management</h3>
            <p>Organize inventory into multiple categories for better clarity.</p>
        </div>
        <div class="feature-box">
            <h3>CRUD Operations</h3>
            <p>Add, edit, view, and delete inventory items easily.</p>
        </div>
        <div class="feature-box">
            <h3>User Authentication</h3>
            <p>Secure login ensures personalized personal inventory system.</p>
        </div>
        <div class="feature-box">
            <h3>Status Tracking</h3>
            <p>Track inventory items.</p>
        </div>
    </div>
</div>

<footer>
    © 2025 GLMS | Personal Inventory Planning System
</footer>

</body>
</html>
