
<div id="row">    
    <input style="width:22%" type="datetime-local" name="datetime[]" placeholder="YYYY-MM-DD HH:MM"required>
    <input style="width:25%" type="text" name="location[]" placeholder="Location" pattern="[a-zA-Z ]*"required>
    <input style="width:15%" type="text" name="course[]" min="0" max="359" step="1" placeholder="Mag Course(&deg;)" title="Magnetic Course (&deg;)">
    <select style="width:15%" name="water_condition[]" placeholder="Water Condition" required>
        <option disabled selected>Water Condition</option>
        <option value="Very Good">Very Good</option>
        <option value="Good">Good</option>
        <option value="Moderate">Moderate</option>
        <option value="Poor">Poor</option>
        <option value="Very Poor">Very Poor</option>
    </select>
    <select style="width:15%" name="wind[]" placeholder="Wind" required>
        <option disabled selected>Wind</option>
        <option value="Calm">Calm</option>
        <option value="Light Air">Light Air</option>
        <option value="Light Breeze">Light Breeze</option>
        <option value="Gentle Breeze">Gentle Breeze</option>
        <option value="Fresh Breeze">Severe Wind</option>
        <option value="Strong Breeze">Strong Breeze</option>
        <option value="Near Gale">Near Gale</option>
        <option value="Gale">Gale</option>
        <option value="Strong Gale">Strong Gale</option>
        <option value="Storm">Storm</option>
        <option value="Violent Storm">Violent Storm</option>
        <option value="Hurricane">Hurricane</option>
    </select>
    <select style="width:15%" name="weather[]" placeholder="Weather" required>
        <option disabled selected>Weather</option>
        <option value="Bright">Bright</option>
        <option value="Overcast">Overcast</option>
        <option value="Cloudy">Cloudy</option>
        <option value="Light Rain">Light Rain</option>
        <option value="Heavy Rain">Heavy Rain</option>
    </select>
    <input style="width:22%" type="number" name="distance[]" min="0" max="20000" step="1" placeholder="Distance Since Last(km)" title="Distance Since Last(km)" required>
    <input style="width:15%" type="number" name="speed[]" min="0" max="50" step="1" placeholder="Speed(Kts)" title="Speed (kts)" required>
    <textarea style="width:43%;" type="text" name="notes[]" placeholder="Notes"></textarea>
    <hr>
</div>
