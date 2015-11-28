<?php
//form validation function
function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach($errors as $error){
        $display.='<li class = "text-danger">'.$error.'</li>';           
    }
    $display.='</ul>';
    return $display;
}
// sanitize input
function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}

//currency formetter
function money($number){
    return '$'.number_format($number,2);
    
}
//login function
function login($_id){
    $_SESSION['user_session'] = $_id;
    global $conn;
    $date = date("Y-m-d H:i:s");
    $conn->query("UPDATE users SET last_login = '$date' WHERE id='$_id'");
    $_SESSION["success_flash"] = "You are now logged in";
    header("Location: admin_index.php");
    
}

//verify login
function logged_in(){
    if(isset($_SESSION['user_session']) && $_SESSION['user_session'] > 0){
        return true;
    }else{
        return false;
    }
}

//error if not logged in
function login_error($url = 'user_login.php'){
    $_SESSION["error_flash"] = "You must login to access that page";
    header('Location: '.$url);
   
}

//user permissions
function permissions($permission){
    global $user_data;
    $permissions = explode(',',$user_data['permissions']);    
    if(in_array($permission,$permissions,true)){
        return false;
    }else{
        return true;
    }
}
//error if inadequate permissions
function permission_error($url){
    $_SESSION["error_flash"] = "You do not have permissions to access that page";
    header('Location: '.$url);
   
}

function date_formatter($date){
    return date("M d, Y h:i A",strtotime($date));
}
