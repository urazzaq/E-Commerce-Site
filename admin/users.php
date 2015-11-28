<?php
require_once '../core/conn.php';
include_once '../helpers/helpers.php';  
//verify login
if(!logged_in()){
    login_error();
}
//verify persmissions
//if(!permissions("admin")){
//    permission_error('admin_brand.php');
//}
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
$userQuery = $conn->query("SELECT * FROM users ORDER BY full_name");
?>
<h2 class="text-center">Users</h2><hr>
<table style="width:50%"  class="table table-auto table-bordered table-striped table-condensed">
    <thead><th></th><th>Name</th><th>Email</th><th>Permissions</th></thead>
<tbody>
    <?php while($user= mysqli_fetch_assoc($userQuery)):?>
    <tr>
        <td></td>
        <td><?=$user['full_name'];?></td>
        <td><?=$user['email'];?></td>
        <td><?=$user['permissions'];?></td>
    </tr>
    <?php endwhile?>
</tbody>
</table>

<?php include_once 'includes/admin_footer.php'; ?>
