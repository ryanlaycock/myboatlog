<?php
include_once('../classes/map.php');
include_once('../includes/db.php');
session_start();
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');
}
$map = new Map();
$json = file_get_contents("php://input");
$data = json_decode($json);
$db = connect();

if($data){
    $votes = $map->ChangeVote($db, $data->poi_id, $data->votes, "up");
    echo $votes;
}
    //echo $pois;
    

close($db);
?>