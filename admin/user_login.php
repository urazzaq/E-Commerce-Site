
<?php
require_once "../core/conn.php";
require_once '../helpers/helpers.php';  
error_reporting(E_ALL);
ini_set('display_errors', '1');



$email = ((isset($_POST['email']))? sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))? sanitize($_POST['password']):'');
$password=trim($password);
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
                      if(empty($_POST['email'] ) || empty($_POST['password']) ){
                          $errors[].= 'Email and Password Required';
                      }
                      
                      //validate email
                      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                          $errors[].="You must enter a valid email";
                      }
                      
                      //password is less then 6
                      if(strlen($password)< 6){
                          $errors[].="Password must be atleast 6 characters";
                      }
                     
                      //vaildate if user exist
                      $query = $conn->query("SELECT * FROM users WHERE email = '$email'");
                      $user = mysqli_fetch_assoc($query);
                      $userCount = mysqli_num_rows($query);
                 
                      if($userCount ==0){
                      $errors[].="User ".$email." does not exist";
                      }
                      //if password matches database
                      if(!password_verify($password, $user['password'])){
                      $errors[].="The password does not match our records";    
                      }
                      
                      //check for errors
                      if(!empty($errors)){
                          echo display_errors($errors);  
                      }else{
                          //log user in
                          $user_id = $user['id'];
                          login($user_id);
                          
                      }
                  }
                  ?>  
                    
                </div>
                
                <h2 class="text-center">Login</h2><hr>
                <form action="user_login.php" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login">
                    </div>
                </form>
                <p class="text-right"><a href="../index.php">Visit Site</a></p>
            </div>


            <?php include_once 'includes/admin_footer.php'; ?>
            <script>alert('USERNAME: tester@test.com \nPASSWORD: password');</script>
                