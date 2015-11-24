
<?php
require_once "../core/conn.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userPassword = 'password';
$hashed = password_hash($userPassword, PASSWORD_DEFAULT);

?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />  
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Administrator</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" type = "text/css" href="../css/main.css" />
        <meta name="viewport" content="width= device-width, initial-scale=1,user-scalable=no" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

    </head>
    
    <body>
        <div class ="container-fluid">
            
        </div>


    <footer class = "text-center" id="footer">&copy; Copyright 2015-2017 Umer's E-Commerce World</footer>
    </body>
</html>