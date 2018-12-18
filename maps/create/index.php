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
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="map_create.css">
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../javascript/add_poi.js"></script>
        <script src="../javascript/map.js"></script>
        <script src="../javascript/buttons.js"></script>
        
    </head>
    <body>
        <div id="header">
            <div id="left_button">
                <button id="homebutton">Home</button>
            </div>
            <h1>My Boat Log</h1>
            <div id="buttons">
                <button id="logbutton">Logs</button>
                <button id="mapbutton">Maps</button>
            </div>
        </div>
        <div id="content">
            <div id="location">

            </div>
            <div id="googleMap"></div>
            <div id="input_form">

                <form>
                    <div id="form_contents">
                        <input type="text" name="name" placeholder="Name" id="name" required>
                        <input type="text" name="description" placeholder="Description" id="description" required>
                        <select id="type" required>
                            <option disabled selected>Select Type</option>
                            <option value="Boat Club">Boat Club</option>
                            <option value="Mooring">Mooring</option>
                            <option value="Facilities">Facilites</option>
                            <option value="Restaurant">Restaurant</option>
                            <option value="Pub">Pub</option>
                            <option value="Lock">Lock</option>
                            <option value="Bridge">Bridge</option>
                        </select>
                    </div>
                    <div id="button_location">
                        <button id='submit' disabled>Select type and Location</button>
                        <div id="error">
                            
                        </div>
                    </div>
                </form>

            </div>
            <div class="form-messgaes">

            </div>
        </div>
    </body>
</html>
