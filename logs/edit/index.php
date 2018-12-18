<?php
//see logs/create/index.php for annotations
session_start();
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');
}
include_once('../../classes/log.php'); 
include_once('../../includes/db.php');
$log = new Log();

$i = 0;
$row = array();
$info = array();
$db = connect();
$log_id = $_GET["log_id"];
if(isset($log_id)){
    $valid_owner = $log->ValidOwner($db, $log_id);
    if(!$valid_owner){
        header('Location: ../index.php?log_id='.$log_id);
    }else{
        $info = $log->ShowLogInfo($db, $log_id);
        $rows = $log->ShowLogContents($db, $log_id);
        $crews = $log->ShowLogCrews($db, $log_id);
    }
}
if (isset($_POST["submit"])){
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
    
    $log->CreateLog($row, $public, $_POST["crew_member"], $info); //NOTE
    
    $valid = $log->Validate();
    
    if ($valid){
        $log->RemoveInfo($db, $log_id);
        $log_id = $log->GetLogId();
        header('Location: ../../home/index.php');
    }else{
        $error = "Invalid data";
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
                        <input title="Starting Location" style="width: 22%" type="text" name="start_location" placeholder="Starting Location" value="<?php echo $info["start_location"]; ?>">
                        <input title="Destination" style="width: 22%" type="text" name="destination" placeholder="Destination" value="<?php echo $info["destination"]; ?>">
                        <input title="Boat Name" style="width: 22%" type="text" name="boat_name" placeholder="Boat Name" value="<?php echo $info["boat_name"]; ?>">
                        <input title="Air Draft (m)" style="width: 14%" type="number" name="air_draft" min="0" max="10" step="0.1" placeholder="Air Draft(m)" value="<?php echo $info["air_draft"]; ?>">
                        <input title="Draft (m)" style="width: 14%" type="number" name="draft" min="0" max="10" step="0.1" placeholder="Draft(m)" value="<?php echo $info["draft"]; ?>">
                    </div>
                    <div id="line">
                        <select name="water_type" placeholder="Water Type" style="width: 22%;" >
                            <option disabled>Water Type</option>
                            <option value="inland" <?php if($info["water_type"] == "inland"){ echo "selected";} ?> >Inland</option>
                            <option value="tidal" <?php if($info["water_type"] == "tidal"){ echo "selected";} ?> >Tidal</option>
                        </select>
                        <input type="text" name="water_name" placeholder="Water Name" style="width: 22%" value="<?php echo $info["water_name"]; ?>">
                        <textarea style="width: 50%; height:70px;" type="text" name="summary" placeholder="Summary" ><?php echo $info["summary"]; ?></textarea>
                    </div>
                    <div id="line">
                        <br>
                        <div id="crew">
                            <button id="add_crew">Add New Crew</button>
                            <?php
                            foreach ($crews as $crew){?>
                                <input type="text" name="crew_member[]" placeholder="Crew Member" value="<?php echo $crew["crew_member"]; ?>"><?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="log_content">
                    <h3>Log Details</h3>
                    <?php 
                    foreach($rows as $row){
                        include('../../templates/edit_row.php');
                    }
                    ?>
                </div>                                                                                                                                                                                                        
                
                    <button style="float:left;" id="add_row">Add New Row</button>
                    <input style="float:left;" id="checkbox" type="checkbox" name="public" value="True" <?php if($info["public"] == "1"){ echo "checked";} ?> >  
                    <h4 style="float:left;" >Make Public</h4>
                    <h2 style="float:right;"><?php if(isset($error)){echo $error;};?></h2>
                    <input style="float:right;" type="submit" name="submit" value="Save">
                
            </form>
        </div>
        
    </body>
</html>