<?php
session_start();
include_once('../classes/user.php'); 
include_once('../includes/db.php');

echo "Verify Page";

$user = new User();
if (isset($_GET["email"])&&($_GET["code"])){
    $db = connect();
    $verified = $user->Verify($db, $_GET["email"], $_GET["code"]);
    if ($verified){
        $_SESSION["user_id"] = $user->GetUserID();
        $_SESSION["logged_in"] = true;
        header ('Location: ../home/index.php');
    }else{
        $msg = "Something went wrong";
    }
    close($db);
}else{
    $msg = "Please verify your account. Check your email for a code.";
}
?>

<html>
    <head>
         <link rel="stylesheet" type="text/css" href="/styles/reset.css">
        <link rel="stylesheet" type="text/css" href="/styles/main.css">
        <link rel="stylesheet" type="text/css" href="verify.css">
 <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id="header">
            
            <h1>My Boat Log</h1>
            
        </div>
        <div id="content">
            <p><?php echo $msg; ?></p>
        </div>
    </body>
</html>