<?php
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
            } else {
                header("Location:index.php");
            }

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "Email or username not found!";
    }
}
?>