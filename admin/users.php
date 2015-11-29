<?php
require_once '../core/conn.php';
include_once '../helpers/helpers.php';
//verify login
if (!logged_in()) {
    login_error();
}
//verify persmissions
//if(!permissions("admin")){
//    permission_error('admin_brand.php');
//}
include_once "includes/admin_head.php";
include_once "includes/admin_navigation.php";
if (isset($_GET['delete'])) {
    $delete_id = sanitize($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id ='$delete_id'");
    $_SESSION['success_flash'] = 'User has been deleted';
    header("Location: users.php");
}
if (isset($_GET['add'])) {
    $name = ((isset($_POST['name']))?sanitize($_POST['name']): '');
    $email = ((isset($_POST['email']))? sanitize($_POST['email']) : '');
    $password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');
    $confirm = ((isset($_POST['confirm']))? sanitize($_POST['confirm']) : '');
    $permissions = ((isset($_POST['permissions'])) ? sanitize($_POST['permissions']) : '');
    $errors = array();
    if ($_POST) {
        $emailQuery = $conn->query("SELECT * FROM users WHERE email='$email'");
        $emailCount = mysqli_num_rows($emailQuery);
        if($emailCount != 0){
            $errors[]= 'That email already exists';
        }
        
        $required = array('name', 'email', 'password', 'confirm', 'permissions');
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[] = 'You must fill out all fields';
                break;
            }
        }
        //password is less then 6
        if (strlen($password) < 6) {
            $errors[].="Password must be atleast 6 characters";
        }

        //new password matches confirm
        if ($password != $confirm) {
            $errors[].="Passwords do not match";
        }

        //validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[].="You must enter a valid email";
        }
        
   

        if (!empty($errors)) {
            echo display_errors($errors);
        } else {
            //add user to database
            $hashed= password_hash($password,PASSWORD_DEFAULT);
            $conn-> query("INSERT INTO users (`full_name`,`email`,`password`,`permissions`) VALUES ('$name','$email','$hashed,'$permissions') ");
            $_SESSION['success_flash']='User has been added';
            header("Location: users.php");
        }
    }
    ?>
    <h2 class="text-center">Add New User</h2><hr>
    <form action='users.php?add=1' method="post">
        <div class='form-group col-md-6'>
            <label for='name'>Full Name</label>
            <input type ='text' name='name' id='name' class='form-control' value='<?= $name; ?>'>
        </div>
        <div class='form-group col-md-6'>
            <label for='email'>Email</label>
            <input type ='email' name='email' id='email' class='form-control' value='<?= $email; ?>'>
        </div>
        <div class='form-group col-md-6'>
            <label for='password'>Password</label>
            <input type ='password' name='password' id='password' class='form-control' value='<?= $password; ?>'>
        </div>
        <div class='form-group col-md-6 '>
            <label for='confirm'>Confirm Password</label>
            <input type ='password' name='confirm' id='confirm' class='form-control' value='<?= $confirm; ?>'>
        </div>
        <div class='form-group col-md-6 '>
            <label for='confirm'>Permissions</label>
            <select class='form-control' name='permissions'>
                <option value=''<?= (($permissions == '') ? ' selected' : ''); ?></option>
                <option value='editor'<?= (($permissions == 'editor') ? ' selected' : ''); ?>>Editor</option>
                <option value='admin,editor'<?= (($permissions == 'admin,editor') ? ' selected' : ''); ?>>Admin</option>
            </select>
        </div>
        <div class='form-group col-md-6 text-right' style='margin-top: 25px'>
            <a href='users.php' class='btn btn-default'>Cancel</a>
            <input type='submit' value='Add User' class='btn btn-primary'>
        </div>
    </form>


    <?php
} else {
    $userQuery = $conn->query("SELECT * FROM users ORDER BY full_name");
    ?>
    <h2 class="text-center">Users</h2><hr>
    <a href='users.php?add=1' class='btn btn-success pull-right' id='add-product-button' style='margin-top:25px''>Add New User</a>
    <table style="width:50%"  class="table table-auto table-bordered table-striped table-condensed">
        <thead><th></th><th>Name</th><th>Email</th><th>Permissions</th></thead>
    <tbody>
        <?php while ($user = mysqli_fetch_assoc($userQuery)): ?>
            <tr>
                <td>
                    <?php if ($user['id'] != $user_data['id']): ?>
                        <a href='users.php?delete=<?= $user['id']; ?>' class='btn btn-default btn-xs' >
                            <span class="glyphicon glyphicon-remove"></span></a>
                        <?php endif; ?>


                </td>
                <td><?= $user['full_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['permissions']; ?></td>
            </tr>
        <?php endwhile ?>
    </tbody>
    </table>

<?php } include_once 'includes/admin_footer.php'; ?>
