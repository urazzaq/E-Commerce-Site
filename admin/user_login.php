<?php
require_once "./core/conn.php";
include_once "includes/admin_head.php";
$userPassword = 'password';
$hashed = password_hash($userPassword,PASSWORD_DEFAULT);
echo $hashed;
?>



<?php  include_once 'includes/admin_footer.php'; ?>
