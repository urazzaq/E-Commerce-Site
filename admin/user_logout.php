<?php
require_once "../core/conn.php";
session_unset($_SESSION['user_session']);
$_SESSION['success_flash'] = "Successfully logged out!";
header('Location: user_login.php');
?>


