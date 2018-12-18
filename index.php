<?php
    require("lib/sendgrid-php/sendgrid-php.php");
    include_once('classes/user.php'); 
    include_once('includes/db.php');
    include 'includes/email.php';
    session_start();
    session_unset();
    $user = new User();
    if (isset($_POST["register"])){
        $error = "";
        $user->CreateRegisterUser($_POST["first_name"], $_POST["second_name"], $_POST["email"], $_POST["password"], $_POST["conf_password"]);           
        $valid = $user->Validate();
        $db = connect();
        if($valid){//input is verfied
            if($email_used = $user->EmailUsed($db)){ //email used
               $user->AutoCompleteRegister();
               $_SESSION["register_error"] = "<div id='error'>Sorry email already used.</div>";
            }else{//email not used
                $user->Register($db);
                header('Location: verify/index.php');
            }
        }
        else{//input not valid
            $user->AutoCompleteRegister();
            $_SESSION["register_error"] = "<div id='error'>The passwords do not match.</div>";
            
        }
        close($db);
    }
    if (isset($_POST["login"])){
        $error = "";
        $db = connect();
        $user->CreateLoginUser($_POST["email"], $_POST["password"]);
        if($user->CorrectLogin($db)){
            if($user->Verified()){
                $_SESSION["user_id"] = $user->GetUserID();
                $_SESSION["logged_in"] = true;
                header('Location: home/index.php');
            }else{
                header('Location: verify/index.php');
            }
        }else{
            $user->AutoCompleteLogin();
            $_SESSION["login_error"] =  "<div id='error'>Wrong email or password.</div>";
        }
        close($db);
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Boat Log</title>
        <link rel="stylesheet" type="text/css" href="/styles/reset.css">
        <link rel="stylesheet" type="text/css" href="/styles/main.css">
        <link rel="stylesheet" type="text/css" href="index.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="index.js"></script>
    </head>
    <body>
        <div id="header">
            <h1>My Boat Log</h1>
            <div id="buttons">
                <button id="loginbutton">Login</button>
                <button id="registerbutton">Register</button>
            </div>
        </div>
        <div id="form"> 
           
        </div>   
        <div id="info">  
            
        </div>
    </body>
</html>