<?php
if(isset($_POST["submit"])){
    
    $datetime = $_POST["datetime"];
    echo $datetime;
    // put regex between /^ and $/
    if(!preg_match("/^[1-2][0-9]{3}[\-]((0[1-9])|(1[0-2]))[\-]((0[1-9])|([1-2][0-9])|(3[0-1]))T((0[0-9])|(1[0-9])|(2[0-4])):([0-5][0-9])$/",$datetime)){
        echo "false";
    }else{
        echo "true";
    }
}
?>

<form method="post">
    <input style="width:22%" type="datetime-local" name="datetime" placeholder="YYYY-MM-DD HH:MM"required>
    <input type="submit" name="submit">
</form>
