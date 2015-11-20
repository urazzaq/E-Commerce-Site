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
require_once '../config.php';
require_once BASEURL.'helpers/helpers.php';


?>