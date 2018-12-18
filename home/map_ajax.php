<?php
session_start();
include_once('../includes/db.php');
include_once('../classes/map.php'); 
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');   
}
$map = new Map();
$db = connect();
$map_result = $map->ShowUsersPois($db);

close($db);

if (empty($map_result)){
    echo "";
}else{
    echo json_encode($map_result);
}
?>