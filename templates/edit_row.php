<div id="row">    
    <input style="width:22%" type="text" name="datetime[]" placeholder="YYYY-MM-DD HH:MM"required value="<?php echo $row["datetime"]; ?>">
    <input style="width:25%" type="text" name="location[]" placeholder="Location" pattern="[a-zA-Z ]*"required value="<?php echo $row["location"]; ?>">
    <input style="width:15%" type="number" name="course[]" min="0" max="359" step="1" placeholder="Mag Course(&deg;)" title="Magnetic Course (&deg;)" value="<?php echo $row["course"]; ?>">
    <select style="width:15%" name="water_condition[]" placeholder="Water Condition" required >
        <option disabled >Water Condition</option>
        <option value="Very Good" <?php if($row["water_condition"] == "Very Good"){ echo "selected";} ?> >Very Good</option>
        <option value="Good" <?php if($row["water_condition"] == "Good"){ echo "selected";} ?> >Good</option>
        <option value="Moderate" <?php if($row["water_condition"] == "Moderate"){ echo "selected";} ?> >Moderate</option>
        <option value="Poor" <?php if($row["water_condition"] == "Poor"){ echo "selected";} ?> >Poor</option>
        <option value="Very Poor" <?php if($row["water_condition"] == "Very Poor"){ echo "selected";} ?> >Very Poor</option>
    </select>
    <select style="width:15%" name="wind[]" placeholder="Wind" required>
        <option disabled>Wind</option>
        <option value="Calm" <?php if($row["wind"] == "Calm"){ echo "selected";} ?> >Calm</option>
        <option value="Light Air" <?php if($row["wind"] == "Light Air"){ echo "selected";} ?> >Light Air</option>
        <option value="Light Breeze" <?php if($row["wind"] == "Light Breeze"){ echo "selected";} ?> >Light Breeze</option>
        <option value="Gentle Breeze" <?php if($row["wind"] == "Gentle Breeze"){ echo "selected";} ?> >Gentle Breeze</option>
        <option value="Fresh Breeze" <?php if($row["wind"] == "Fresh Breeze"){ echo "selected";} ?> >Severe Wind</option>
        <option value="Strong Breeze" <?php if($row["wind"] == "Strong Breeze"){ echo "selected";} ?> >Strong Breeze</option>
        <option value="Near Gale" <?php if($row["wind"] == "Near Gale"){ echo "selected";} ?> >Near Gale</option>
        <option value="Gale" <?php if($row["wind"] == "Gale"){ echo "selected";} ?> >Gale</option>
        <option value="Strong Gale" <?php if($row["wind"] == "Strong Gale"){ echo "selected";} ?> >Strong Gale</option>
        <option value="Storm" <?php if($row["wind"] == "Storm"){ echo "selected";} ?> >Storm</option>
        <option value="Violent Storm" <?php if($row["wind"] == "Violent Storm"){ echo "selected";} ?> >Violent Storm</option>
        <option value="Hurricane" <?php if($row["wind"] == "Hurricane"){ echo "selected";} ?> >Hurricane</option>
    </select>
    <select style="width:15%" name="weather[]" placeholder="Weather" required>
        <option disabled >Weather</option>
        <option value="Bright" <?php if($row["weather"] == "Bridge"){ echo "selected";} ?> >Bright</option>
        <option value="Overcast" <?php if($row["weather"] == "Overcast"){ echo "selected";} ?> >Overcast</option>
        <option value="Cloudy" <?php if($row["weather"] == "Cloudy"){ echo "selected";} ?> >Cloudy</option>
        <option value="Light Rain" <?php if($row["weather"] == "Light Rain"){ echo "selected";} ?> >Light Rain</option>
        <option value="Heavy Rain" <?php if($row["weather"] == "Heavy Rain"){ echo "selected";} ?> >Heavy Rain</option>
    </select>
    <input style="width:22%" type="number" name="distance[]" min="0" max="20000" step="1" placeholder="Distance Since Last(km)" title="Distance Since Last(km)" required value="<?php echo $row["distance"]; ?>">
    <input style="width:15%" type="number" name="speed[]" min="0" max="50" step="1" placeholder="Speed(Kts)" title="Speed (kts)" required value="<?php echo $row["speed"]; ?>">
    <textarea style="width:43%;" type="text" name="notes[]" placeholder="Notes"><?php echo $row["notes"]; ?></textarea>
    <hr>
</div>
