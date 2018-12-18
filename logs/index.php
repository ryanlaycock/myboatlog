<?php
session_start();
include_once('../classes/log.php'); 
include_once('../includes/db.php');
include_once('../templates/log_row.php'); 
if(!$_SESSION["logged_in"]){
    header('Location: ../index.php');
}

$log = new Log();
$db = connect();
$show_top = FALSE;

if(isset($_GET["log_id"])){
    $info = $log->ShowLogInfo($db, $_GET["log_id"]);
    $rows = $log->ShowLogContents($db, $_GET["log_id"]);
    $crews = $log->ShowLogCrews($db, $_GET["log_id"]);
    //decide what to show to the user
    if(empty($info)){
        $errors =  "No logs found.";
        $show = False;
    }else if(!$info){
        $errors =  "Something went wrong :/ ";
        $show = False;
    }elseif((!$info["public"]) && ($info["user_id"]!=$_SESSION["user_id"])){
        $show = False;
    }else{
        $show = True;
    }
}elseif(isset($_POST["search"])){
    $top = $log->SearchLogs($db, $_POST["search"]);
    //run the search code
    unset($_POST["search"]);
}elseif(isset($_POST["recent"])){
    $top = $log->ShowRecentLogs($db);
    unset($_POST["recent"]);
}else{
    $top = $log->ShowTopLogs($db);   

}

if(isset($top)){
    if(empty($top)){
        $errors = "No logs found.";
    }else if(!$top){
        $errors = "Something went wrong :/ ";
    }else{
        $show_top = TRUE;
    }
}

if(isset($_POST["up_vote"])){
    $log->ChangeVote($db, $_GET["log_id"], $info["votes"], "up");
}elseif(isset($_POST["down_vote"])){
    $log->ChangeVote($db, $_GET["log_id"], $info["votes"], "down");
}

close($db);
?>


<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../styles/reset.css">
        <link rel="stylesheet" type="text/css" href="../styles/main.css">
        <link rel="stylesheet" type="text/css" href="log.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:500,400,300' rel='stylesheet' type='text/css'>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="log.js"></script>
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
            
        <?php
        
        if(isset($_GET["log_id"])){
            if($show){
                DisplayInfo($info, $crews);
                ?>
            <div id="row">
                <table>
                <td style="width:140px;">Date and Time</td>
                <td>Location</td>
                <td>Course</td>
                <td>Water Cond.</td>
                <td>Wind Cond.</td>
                <td>Weather Cond.</td>
                <td>Distance</td>
                <td>Speed</td>
                <td>Notes</td>        
                        
                <?php
                foreach($rows as $row){
                    DisplayRow($row);
                }?>
                </table>
            </div>
            <?php
            }else{
                echo "This log is private or the link has broken :/";
            }
        }else{
            MenuButtons();
            if(isset($errors)){
                echo $errors;
            }
            foreach($top as $row){
                DisplayDefault($row);
            }
        } 
        ?>
        </div>
    </body>
</html>