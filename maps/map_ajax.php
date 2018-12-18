<?php
include_once('../classes/map.php');
include_once('../includes/db.php');
session_start();
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');
}
$map = new Map();
$json = file_get_contents("php://input");
// $json_cleared = preg_replace('/\s+/', '',$json);
//$json = stripslashes($json);
$data = json_decode($json, true);
// 
//echo json_last_error_msg();
$db = connect();

if($data["request"] == "show_all"){
    
    $pois = $map->ShowPois($db, $data["bounds"]);


    echo json_encode($pois, JSON_FORCE_OBJECT); 
//echo json_encode($json, JSON_FORCE_OBJECT); 
}

elseif($data["request"] == "votes"){
    $pois = $map->ShowVote($db, $data["id"]);
    echo json_encode($pois["votes"], JSON_FORCE_OBJECT); 
}

    

close($db);
?>
