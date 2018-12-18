<?php
function connect(){
    try {
        $db = new PDO('mysql:host=localhost;dbname=myboatlog','root','password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $error) {
        echo $error->getMessage();
    }
    return $db;
}

function close($db){
    $db = null;
}
?>