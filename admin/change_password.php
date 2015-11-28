
<?php
require_once "../core/conn.php";
require_once '../helpers/helpers.php';  
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!logged_in()){
    login_error();
}
$hash = $user_data['password'];
$user_id = $user_data['id'];
$old_password = ((isset($_POST['old_password']))? sanitize($_POST['old_password']):'');
$old_password=trim($old_password);
$password = ((isset($_POST['password']))? sanitize($_POST['password']):'');
$password=trim($password);
$confirm = ((isset($_POST['confirm']))? sanitize($_POST['confirm']):'');
$confirm=trim($confirm);
$new_hash = password_hash($password, PASSWORD_DEFAULT);
$errors = array();
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
        <link async href="http://fonts.googleapis.com/css?family=Coda"  rel="stylesheet" type="text/css"/>
    </head>


    <body class = 'admin-body' >
        <div class ="container-fluid">
            <div id="login-form">
                
                <div>
                  <?php
                  
                  if($_POST){
                     //form validation
                      if(empty($_POST['old_password'] ) || empty($_POST['password']) || empty($_POST['confirm'])){
                          $errors[].= 'All fields required';
                      }
                     //password is less then 6
                      if(strlen($password)< 6){
                          $errors[].="Password must be atleast 6 characters";
                      }
                     
                      //new password matches confirm
                      if($password!=$confirm){
                      $errors[].="Passwords do not match";    
                      }
                      
                      //if password matches database
                      if(!password_verify($old_password, $hash)){
                      $errors[].="Old password is incorrect";    
                      }
                      
                      //check for errors
                      if(!empty($errors)){
                          echo display_errors($errors);  
                      }else{
                          //change password
                          $conn->query("UPDATE users SET password = '$new_hash' WHERE id ='$user_id'");
                          $_SESSION['success_flash'] = "Password successfully changed";
                          header('Location: admin_index.php');
                      }
                  }
                  ?>  
                    
                </div>
                
                <h2 class="text-center">Change Password</h2><hr>
                <form action="change_password.php" method="post">
                    <div class="form-group">
                        <label for="old_password">Old Password:</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" value="<?php echo $old_password; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">New Password:</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
                    </div>
                    <div class="form-group">
                        <label for="confirm">Confirm Password:</label>
                        <input type="password" name="confirm" id="confirm" class="form-control" value="<?php echo $confirm; ?>">
                    </div>
                    <div class="form-group">
                        <a href="admin_index.php" class ="btn btn-danger">Cancel</a>
                        <input type="submit" value="Submit" class ="btn btn-success">
                    </div>
                </form>
                <p class="text-right"><a href="../index.php">Visit Site</a></p>
            </div>


            <?php include_once 'includes/admin_footer.php'; ?>
            <script>alert('USERNAME: tester@test.com \nPASSWORD: password');</script>
                