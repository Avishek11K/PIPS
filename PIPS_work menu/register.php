
<?php

// session_start();

    $usernameerr=$emailerr=$passworderr="";
    $username=$email=$password="";
    $success="";
    
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['Submit'])){

    require_once("db.php");// DB connection instead of $connect=mysqli_connect("user","password","host","db)


    if(empty($_POST['username'])){
        $usernameerr="Username is required!";
    }else{
    $username = trim(htmlspecialchars($_POST['username']));
    }

    if(empty($_POST['email'])){
        $emailerr="Email required!";
    }elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $emailerr="Validate email need to be entered!";
    }
    else{
    $email = trim($_POST['email']);
    }
    
  if(empty($_POST['password'])){
        $passworderr="Password required!";
    }else{
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      
    }

    if($usernameerr=="" && $emailerr=="" && $passworderr==""){

        $check=mysqli_query($connection,"SELECT *FROM users where Email='$email'");
        if(mysqli_num_rows($check)>0){
            $emailerr="Email already registered!";
        }else{
         // Insert query
         $sql = "INSERT INTO users (Username, Email, Pass_word) 
            VALUES ('$username', '$email', '$password')";

          $result=mysqli_query($connection,$sql);
          
           if($result){
                 header("Location:index.php"); 
                 exit();
           }
           else {
               die("Error:".mysqli_error($connection));
           }
    }
 }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLMS - Register</title>
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

        /* Registration container */
        .register-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 380px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        /* Input fields */
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container select {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .register-container input:focus,
        .register-container select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Submit button */
        .register-container button {
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

        .register-container button:hover {
            background: #45a049;
        }

        /* Error message */
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Success message */
        .success {
            color: green;
            margin-top: 10px;
            font-size: 14px;
        }

        /* Footer / login link */
        .register-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .register-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>



<div class="register-container">

<form method="POST">
    Username:<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter username">
   <br> <span style='color:red'><?php echo $usernameerr; ?></span>
    <br><br>
    Email:<input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter email">
    <br><span style='color:red'><?php echo $emailerr; ?></span>
    <br><br>
    Password:<input type="password" name="password" placeholder="Enter password">
    <br><span style='color:red'><?php echo $passworderr;?></span>
    <br><br>
    <input type="submit" name="Submit" value="Register">
</form>
      <?php
    if(isset($error) && $error != ""){
        echo "<div class='error'>$error</div>";
    }
    if(isset($success) && $success != ""){
        echo "<div class='success'>$success</div>";
    }
    ?>

    <div class="register-footer">
        Already have an account? <a href="index.php">Login here</a>
    </div>
</div>



