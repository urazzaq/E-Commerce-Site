<?php

$host = 'localhost';
$username = 'root';
$password = 'dbpass';
$database = 'ACME';
$port = '3306';

$conn = mysqli_connect($host, $username, $password, $database,$port);
if (mysqli_connect_errno()) {
    echo 'Database connection failed ' . mysqli_connect_error();
    die();
}
//start session
session_start();
//collect user data
if(isset($_SESSION['user_session'])){
    $user_id = $_SESSION['user_session'];
    $query =$conn->query("SELECT * FROM users WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($query);
    $full_name = explode('',$user_data['full_name']);
    $user_data['first'] = $full_name[0];
    $user_data['last'] = $full_name[1];
    
}
//on success
if(isset($_SESSION["success_flash"])){
    echo  '<h3><div class="bg-success"><p class = "text-success text-center">'.$_SESSION["success_flash"].'</p></div></h3>';
    unset($_SESSION["success_flash"]);
}

//on success
if(isset($_SESSION["error_flash"])){
    echo  '<h3><div class="bg-danger"><p class = "text-danger text-center">'.$_SESSION["error_flash"].'</p></div></h3>';
    unset($_SESSION["error_flash"]);

}


?>
