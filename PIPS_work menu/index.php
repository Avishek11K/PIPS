<?php
// session_start();



// if(!isset($_SESSION["Username"])){
//     header("Location:index.php");
//     exit();
// }


//     // require_once("login.php"); 
//     if(isset($error) && $error != ""){
//         echo "<div class='error'>$error</div>";
//     }

//     session_destroy();

session_start();
require_once("db.php");

$error = "";

if(isset($_POST["login"])){

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user by email and username
    $sql = "SELECT * FROM users WHERE Email='$email' AND Username='$username'";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $row['Pass_word'])){

            // Set session
            $_SESSION['User_id'] = $row['User_id'];
            $_SESSION['email']   = $row['Email'];
            $_SESSION['Username']= $row['Username'];
            $_SESSION['role']    = $row['role']; // admin or user

            // Insert notification for admin
            $userId = $row['User_id'];
            $message = "User logged in";
            $notifSql = "INSERT INTO notifications (user_id,message, created_at) VALUES ($userId,'$message', NOW())";
            mysqli_query($connection, $notifSql);

            // Redirect based on role
            if($row['role'] == "user"){
                header("Location:home.php");
                exit();
            } else if($row['role'] == "admin"){
                header("Location:admin.php");
                exit();
            } 

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "Email or username not found!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIPS - Login</title>
    <style>
        /* Reset and basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Login container */
        .login-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        /* Input fields */
        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-container input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Submit button */
        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #4CAF50;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-container button:hover {
            background: #45a049;
        }

        /* Error message */
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Optional footer */
        .login-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .login-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>PIPS Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="submit" name="login" value="Login">
    </form>
    



    <div class="login-footer">
        Don't have an account? <a href="register.php">Register here</a>
    </div>
</div>



</body>
</html>
