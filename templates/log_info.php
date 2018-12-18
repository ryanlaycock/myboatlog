<?php
//home page
function DisplayInfo($row){ ?>
    <div id="row">
        <div id="data">
            <div id="title">
                <a href="../logs/?log_id=<?php echo $row["log_id"]; ?>"><h4><?php echo $row["start_location"];?> to <?php echo $row["destination"];?></h4></a>
            </div>
            <p>Water Type: <?php echo $row["water_type"];?></p>
            <p>Last edited: <?php echo $row["last_edit"];?></p>
            <p><?php if($row["public"]){echo "Public";}else{echo "Private";}?></p>
        </div>
        <div id="summary">
            <p><?php echo $row["summary"];?></p>
        </div>
        <div id="edit">
            <a href="../logs/edit/index.php?log_id=<?php echo $row["log_id"];?> ">Edit</a>
        </div>
        <div id="stats">
            
            <img id="arrow" src="../images/down_arrow.png">                
            <p><?php echo $row["votes"];?></p>
            <img id="arrow" src="../images/up_arrow.png">
        </div>
        
    </div>

<?php
}
?>