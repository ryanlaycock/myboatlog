<?php
session_start();
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/styles/reset.css">
        <link rel="stylesheet" type="text/css" href="/styles/main.css">
        <link rel="stylesheet" type="text/css" href="map.css">
        <link rel="stylesheet" type="text/css" href="info_content.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="javascript/buttons.js"></script>
        <script src="show_map.js"></script>
        <script src="javascript/info_content.js"></script>
    </head>
    <body>
        <div id="header">
            <div id="left_button">
                <button id="homebutton">Home</button>
                <button id="createbutton">Create</button>
            </div>
            <h1>My Boat Log</h1>
            <div id="buttons">
                <button id="logbutton">Logs</button>
                <button id="mapbutton">Maps</button>
            </div>
        </div>
        <div id="content">

        <div id="googleMap"></div>
        </div>
    </body>
</html>