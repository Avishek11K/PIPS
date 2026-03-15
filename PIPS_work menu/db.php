<?php

mysqli_connect("localhost","root","mysql@11","grocery");

?>

<?php
DEFINE('DBHOST','localhost');
DEFINE('DBUSER',"root");
DEFINE('DBPASSWORD','mysql@11');
DEFINE('DBNAME','grocery');


try{
    $connection=mysqli_connect(DBHOST,DBUSER,DBPASSWORD,DBNAME)
     OR die("error in connection!:".mysqli_connect_error());
}catch(Exception $e){
     echo $e-getMessage();
}