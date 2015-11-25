
<?php
require_once "../core/conn.php";
include_once "includes/admin_head.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userPassword = 'password';
$hashed = password_hash($userPassword, PASSWORD_DEFAULT);

?>



 <?php  include_once 'includes/admin_footer.php'; ?>
