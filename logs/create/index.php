<?php
session_start();
if(!$_SESSION["logged_in"]){ //check if logged in
    header('Location: ../index.php');
}
include_once('../../classes/log.php'); 
include_once('../../includes/db.php');
$log = new Log(); //create an instant of the object
$i = 0;
$row = array();
$info = array();

if (isset($_POST["submit"])){ //retirve all the information from the form and manipulate 
    //to an easier to handle dtaa structure
     while ($i<count($_POST["location"])){
         $row[$i]["datetime"] = $_POST["datetime"][$i];
         $row[$i]["location"] = $_POST["location"][$i];
         $row[$i]["course"] = $_POST["course"][$i];
         $row[$i]["water_condition"] = $_POST["water_condition"][$i];
         $row[$i]["wind"] = $_POST["wind"][$i];
         $row[$i]["weather"] = $_POST["weather"][$i];
         $row[$i]["distance"] = $_POST["distance"][$i];
         $row[$i]["speed"] = $_POST["speed"][$i];
         $row[$i]["notes"] = $_POST["notes"][$i];
         $i++; 
    }
    
    if(isset($_POST["public"])){
        $public = True;
    }else{
        $public = False;
    }
    
    $info["start_location"] = $_POST["start_location"];
    $info["boat_name"] = $_POST["boat_name"];
    $info["water_type"] = $_POST["water_type"];
    $info["water_name"] = $_POST["water_name"];
    $info["destination"] = $_POST["destination"];
    $info["air_draft"] = $_POST["air_draft"];
    $info["draft"] = $_POST["draft"];
    $info["summary"] = $_POST["summary"];
    
    $log->CreateLog($row, $public, $_POST["crew_member"], $info);
    
    $valid = $log->Validate();

    if ($valid){
        $db = connect();
        $log->InsertInfo($db);
        header('Location: ../../home/index.php');
    }else{
        echo "Invalid";
    }
    close($db);
}

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../styles/reset.css">
        <link rel="stylesheet" type="text/css" href="../../styles/main.css">
        
        <link rel="stylesheet" type="text/css" href="log_create.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="add_more.js"></script>
        <script src="log.js"></script>
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
            
            <form method=post>  
                <div id="log_info">
                    <h3>Log Info</h3>
                    <div id="line">
                        <input title="Starting Location" style="width: 22%" type="text" name="start_location" placeholder="Starting Location">
                        <input title="Destination" style="width: 22%" type="text" name="destination" placeholder="Destination">
                        <input title="Boat Name" style="width: 22%" type="text" name="boat_name" placeholder="Boat Name">
                        <input title="Air Draft (m)" style="width: 14%" type="number" name="air_draft" min="0" max="10" step="0.1" placeholder="Air Draft(m)">
                        <input title="Draft (m)" style="width: 14%" type="number" name="draft" min="0" max="10" step="0.1" placeholder="Draft(m)">
                    </div>
                    <div id="line">
                        <select name="water_type" placeholder="Water Type" style="width: 22%;">
                            <option disabled selected>Water Type</option>
                            <option value="inland">Inland</option>
                            <option value="tidal">Tidal</option>
                        </select>
                        <input type="text" name="water_name" placeholder="Water Name" style="width: 22%">
                        <textarea style="width: 50%; height:70px;" type="text" name="summary" placeholder="Summary"></textarea>
                    </div>
                    <div id="line">
                        <br>
                        <div id="crew">
                            <button id="add_crew">Add New Crew</button>
                        </div>
                    </div>
                </div>
                <div id="log_content">
                    <h3>Log Details</h3>

                </div>
                
                    <button style="float:left;" id="add_row">Add New Row</button>
                    <input style="float:left;" id="checkbox" type="checkbox" name="public" value="True">  
                    <h4 style="float:left;" >Make Public</h4>
                    <input style="float:right;" type="submit" name="submit" value="Save">
                
            </form>
        </div>
        
    </body>
</html>