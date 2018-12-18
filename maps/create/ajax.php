<?php
include_once('../../classes/map.php');
include_once('../../includes/db.php');
session_start();
if(!$_SESSION["logged_in"]){
    header('Location: ../../index.php');
}
$map = new Map();
$json = file_get_contents("php://input");
$data = json_decode($json);

if ($data){
    $map->CreateMap($data);
    $valid = $map->Validate();
    $db = connect();
    if ($valid){
        $map->Create($db);
        echo "";
    }else{
        echo "<p>Incorrect data</p>";
    }
    close($db);
}
?>
