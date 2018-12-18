<?php
session_start();
include_once('../includes/db.php');
include_once('../classes/log.php'); 

include_once('../templates/log_info.php'); 
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');   
}

$log = new Log();

$db = connect();
$result = $log->ShowUsersLogs($db);

close($db);


?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../styles/reset.css">
        <link rel="stylesheet" type="text/css" href="../styles/main.css">
        <link rel="stylesheet" type="text/css" href="home.css">
      
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
         <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script src="home.js"></script>
        <script src="maps.js"></script>
        <script src="../maps/javascript/info_content.js"></script>
    </head>
    <body>
        <div id="header">
            <div id="left_button">
                <button id="logoutbutton">Logout</button>
                
            </div>
            <h1>My Boat Log</h1>
            <div id="buttons">
                <button id="logbutton">Logs</button>
                <button id="mapbutton">Maps</button>
            </div>
        </div>
        <div id="content">
            <h2>Home</h2>
            <div id="logs">
                <h2>Your Logs</h2>
                <?php
                if (empty($result)){
                    echo "<h3>You haven't created any Logs yet! Share your experiences with other boaters and join the community!</h3>";
                }else{
                    foreach($result as $row){
                        DisplayInfo($row);
                    }
                }
                ?>
            </div>
            <div id="maps">
                <h2>Your Maps</h2>
                <?php
                
                ?>
                <div id="map_content">
                    
                </div>
            </div>
        </div>
        
    </body>
</html>