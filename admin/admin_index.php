<?php

require_once '../core/conn.php';
include_once '../helpers/helpers.php';  
//verify login
if(!logged_in()){
    login_error();
}
//verify persmissions
if(!permissions("admin")){
    permission_error('admin_brand.php');
}
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";


?>
Administrator Home
<script>alert('Not a real E-commerce site! for showcase purposes only WIP \n ##Working Modules \n\nMain Page: \nDetails Module \n\nAdmin Area: \nEdit Catagory \nEdit Brand \nEdit Product \n');</script>
<?php include_once 'includes/admin_footer.php'; ?>