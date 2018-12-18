<?php
function DisplayInfo($row, $crew_members){ 

?>

    <div id="log_info">
        <div id="data">
            <div id="title">
                <h4><?php echo $row["start_location"];?> to <?php echo $row["destination"];?></h4>
            </div>
            <p>By: <?php echo $row["f_name"]." ".$row["s_name"];?></p>
            <p>Water Type: <?php echo $row["water_type"];?></p>
            <p>Water Name: <?php echo $row["water_name"];?></p>
            <p>Boat Name: <?php echo $row["boat_name"];?></p>
            <p>Air Draft: <?php echo $row["air_draft"];?></p>
            <p>Draft: <?php echo $row["draft"];?></p>
            <p>Last edited: <?php echo $row["last_edit"];?></p>
        </div>
        <div id="summary">
            <p>Summary:</p>
            <p><?php echo $row["summary"];?></p>
        </div>
        <div id="crew">
            <p>Crew Members:</p>
            <?php
                foreach($crew_members as $crew_member){?>
                    <p><?php echo "&#8226; ".$crew_member["crew_member"];?></p><?php
                }             
            ?>
        </div>
        <div id="stats">
            <form id="vote" method="post">
            <button name="down_vote" id="down_vote" type="submit"><img id="arrow" src="../images/down_arrow.png"><p>Vote Down</p></button>
                <p style="font-size: 20px;">  <?php echo $row["votes"];?>  </p>
            <button name="up_vote" id="up_vote" type="submit"><img id="arrow" src="../images/up_arrow.png"><p>Vote Up</p></button>
            </form>
        </div>
        
    </div>

<?php
}

function DisplayRow($row){ ?>
    
            <tr>
                <td><?php echo $row["datetime"] ?></td>
                <td><?php echo $row["location"] ?></td>
                <td><?php echo $row["course"]."&deg;" ?></td>
                <td><?php echo $row["water_condition"] ?></td>
                <td><?php echo $row["wind"] ?></td>
                <td><?php echo $row["weather"] ?></td>
                <td><?php echo $row["distance"]."km" ?></td>
                <td><?php echo $row["speed"]."kts" ?></td>
                <td><?php echo $row["notes"] ?></td>
            </tr>
        

<?php
}

function DisplayDefault($row){?>
    <div id="default_row">
        <div id="default_data">
            <div id="default_title">
                <a href="../logs/?log_id=<?php echo $row["log_id"]; ?>"><h4><?php echo $row["start_location"];?> to <?php echo $row["destination"];?></h4></a>
            </div>
            <p>By: <?php echo $row["f_name"]." ".$row["s_name"];?></p>
            <p>Water Type: <?php echo $row["water_type"];?></p>
            <p>Last edited: <?php echo $row["last_edit"];?></p>
        </div>
        <div id="default_summary">
            <p><?php echo $row["summary"];?></p>
        </div>
        <div id="default_stats">
            <img id="arrow" src="../images/down_arrow.png">                
            <p><?php echo $row["votes"];?></p>
            <img id="arrow" src="../images/up_arrow.png">
        </div>
        
    </div>
<?php
}

function MenuButtons(){?>
    <div id="menu">
                <div id="form_a">
                    <form method="post">
                        <p>Search All</p>
                        <input type="submit" name="rating" value="Sort by Votes" id="sort_button">
                        <input type="submit" name="recent" value="Sort by Recent" id="sort_button">
                        
                    </form>
                </div>
                <div id="form_b">
                    <form method="post" id="b">
                        <p>Search Specific</p>
                        <input name="search" type="text" placeholder="Search">
                        <input type="submit" value="Go!" id="go">
                            
                    </form> 
               </div>     
            </div>
<?php
}
?>