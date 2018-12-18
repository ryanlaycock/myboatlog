<?php
class Log{
    //Definition Of Class Properties
    private $rows;
    private $valid = True; //initiate as true
    private $public;
    private $crew_members;
    private $info;
    private $log_id;
    
    public function CreateLog($rows, $public, $crew_members, $info){ //retrieves the data and sanitize
        $this->public = htmlentities($public); //strips illegal characters
        if(empty($this->public)){ //if the box left unticked (empty)
            $this->public = "0"; //set it as 0 (false)
        }
        $i = 0;//counter variables
        $x = 0;
        foreach($rows as $row){ //run through each row, adding to the properties
            $this->rows[$i]["datetime"] = htmlentities($row["datetime"]);
            $this->rows[$i]["location"] = htmlentities(ucwords(strtolower($row["location"]))); //make only first character of each word uppercase
            $this->rows[$i]["course"] = htmlentities($row["course"]);
            $this->rows[$i]["water_condition"] = htmlentities(ucwords(strtolower($row["water_condition"])));
            $this->rows[$i]["wind"] = htmlentities(ucwords(strtolower($row["wind"])));
            $this->rows[$i]["weather"] = htmlentities(ucwords(strtolower($row["weather"])));
            $this->rows[$i]["distance"] = htmlentities($row["distance"]);
            $this->rows[$i]["speed"] = htmlentities($row["speed"]);
            $this->rows[$i]["notes"] = htmlentities($row["notes"]);
            $i++; //increment the counter
        }
        //adding the "info" data to the info property        
        $this->info["start_location"] = htmlentities(ucwords(strtolower($info["start_location"])));
        $this->info["boat_name"] = htmlentities(ucwords(strtolower($info["boat_name"])));
        $this->info["water_type"] = htmlentities(ucwords(strtolower($info["water_type"])));
        $this->info["water_name"] = htmlentities(ucwords(strtolower($info["water_name"])));
        $this->info["destination"] = htmlentities(ucwords(strtolower($info["destination"])));
        $this->info["air_draft"] = htmlentities($info["air_draft"]);
        $this->info["draft"] = htmlentities($info["draft"]);
        $this->info["summary"] = htmlentities($info["summary"]);
        //adding the crew memebers to the crew_members property as an array
        foreach($crew_members as $crew_member){
            $this->crew_members[$x] = htmlentities(ucwords(strtolower($crew_member)));
            $x++; //increment the counter
        }
    }
    
    public function Validate(){ //validate all of the data
        foreach ($this->rows as $row){ //each row of "rows" property
            $this->ValidateDatetime($row["datetime"]);//call the function for validation
            $this->ValidateName($row["location"]);
            $this->ValidateCourse($row["course"]);
            $this->ValidateCondition($row["water_condition"]);
            $this->ValidateCondition($row["wind"]);
            $this->ValidateCondition($row["weather"]);
            $this->ValidateDistance($row["distance"]);
            $this->ValidateSpeed($row["speed"]);
            $this->ValidateNotes($row["notes"]);
        }
        
        $this->ValidateName($this->info["start_location"]);
        $this->ValidateName($this->info["boat_name"]);
        $this->ValidateCondition($this->info["water_type"]);
        $this->ValidateName($this->info["water_name"]);
        $this->ValidateName($this->info["destination"]);
        $this->ValidateDraft($this->info["air_draft"]);
        $this->ValidateDraft($this->info["draft"]);
        $this->ValidateNotes($this->info["summary"]);
        
        foreach($this->crew_members as $crew_member){
           $this->ValidateName($crew_member);
        }
        return $this->valid;
    }
    
    private function ValidateDatetime($datetime){
        if (!isset($datetime)){//make valid false if empty
            $this->valid = False;
        }else if(!preg_match("/^[1-2][0-9]{3}[\-]((0[1-9])|(1[0-2]))[\-]((0[1-9])|([1-2][0-9])|(3[0-1]))T((0[0-9])|(1[0-9])|(2[0-4])):([0-5][0-9])$/",$datetime)){
            $this->valid = False;
        }
    }
    private function ValidateName($name){ //
        if (!isset($name)){
            $this->valid = False;
        }else if (strlen($name)>=40){//ensure not longer than 40 characters
            $this->valid = False;
        }else if(!preg_match("/^[a-zA-Z ]*$/",$name)){//only allow upper and lowercase letters and space
            $this->valid = False;
        }
    }
    private function ValidateCourse($course){
        if (is_numeric($course)){//if the string is a number
            if ((int)$course<0 || (int)$course>359){//check in the range
                $this->valid = False;
            }
        }else{
            $this->valid = False;//runs when not a number
        }
        
    }
    private function ValidateCondition($condition){
        if (!isset($condition)){
            $this->valid = False;
        }else if(strlen($condition >=30)){
            $this->valid = False;
        }
    }
    private function ValidateDistance($distance){
        if (!isset($distance)){
            $this->valid = False;
        }else if (is_int($distance)){
            if ($distance<0 || $distance>20000){
                $this->valid = False;
            }
        }else{
            $this->Valid = False;
        }
    }
    private function ValidateSpeed($speed){
        if (!isset($speed)){
            $this->valid = False;
        }else if (is_int($speed)){
            if ($speed<0 || $speed>50){
                $this->valid = False;
            }
        }else{
            $this->Valid = False;
        }
    }
    private function ValidateNotes($notes){
        if (strlen($notes)>=500){
            $this->valid = False;
        }
    }
    private function ValidateDraft($draft){
        if (!isset($draft)){
            $this->valid = False;
        }else if (is_numeric($draft)){
            if ($draft<0 || $draft>10){
                $this->valid = False;
            }
        }else{
            $this->Valid = False;
        }
    }
    private function GetTime(){
        date_default_timezone_set('GMT');
        return date("Y-m-d H:i");//inbuilt php function to get current datetime
    }
    public function InsertInfo($db){//insert into database
        $time = $this->GetTime();//get the current time into "time" variable
        $stmt = $db->prepare("INSERT INTO logs (user_id, start_location, boat_name, water_type, water_name, destination, air_draft, draft, summary, last_edit, public, votes)
        VALUES (:user_id, :start_location, :boat_name, :water_type, :water_name, :destination, :air_draft, :draft, :summary, :last_edit, :public, 0)");
        //put the data into the sql
        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(':start_location', $this->info["start_location"], PDO::PARAM_STR);
        $stmt->bindParam(':boat_name', $this->info["boat_name"], PDO::PARAM_STR);
        $stmt->bindParam(':water_type', $this->info["water_type"], PDO::PARAM_STR);
        $stmt->bindParam(':water_name', $this->info["water_name"], PDO::PARAM_STR);
        $stmt->bindParam(':destination', $this->info["destination"], PDO::PARAM_STR);
        $stmt->bindParam(':air_draft', $this->info["air_draft"], PDO::PARAM_STR);
        $stmt->bindParam(':draft', $this->info["draft"], PDO::PARAM_STR);
        $stmt->bindParam(':summary', $this->info["summary"], PDO::PARAM_STR);
        $stmt->bindParam(':last_edit', $time, PDO::PARAM_STR);
        $stmt->bindParam(':public', $this->public, PDO::PARAM_INT);
        $stmt->execute();//run the sql
        $this->log_id = $db->lastInsertId(); //put the auto generated id into "log_id" property
        $this->InsertCrew($db); //continue to next function
    }
    public function RemoveInfo($db, $log_id){//used for when editing
        $stmt = $db->prepare("DELETE FROM logs
        WHERE log_id = :log_id "); //deletes the log
        $stmt->bindParam(':log_id', $log_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->InsertInfo($db); //adds the updated version
    }
    private function InsertCrew($db){
        $stmt = $db->prepare("INSERT INTO log_crews(log_id, crew_member)
        VALUES (:log_id, :crew_member)");
        foreach($this->crew_members as $crew_member){//run sql for every crew member
            $stmt->bindParam(':log_id', $this->log_id, PDO::PARAM_STR);
            $stmt->bindParam(':crew_member', $crew_member, PDO::PARAM_STR);
            $stmt->execute();
        }
        $this->InsertLogContent($db);
    }
    private function InsertLogContent($db){
        $stmt = $db->prepare("INSERT INTO log_contents(log_id, datetime, location, course, water_condition, wind, weather, distance, speed, notes)
        VALUES (:log_id, :datetime, :location, :course, :water_condition, :wind, :weather, :distance, :speed, :notes)");
        foreach($this->rows as $row){
            $stmt->bindParam(':log_id', $this->log_id, PDO::PARAM_INT);
            $stmt->bindParam(':datetime', $row["datetime"], PDO::PARAM_STR);
            $stmt->bindParam(':location', $row["location"], PDO::PARAM_STR);
            $stmt->bindParam(':course', $row["course"], PDO::PARAM_INT);
            $stmt->bindParam(':water_condition', $row["water_condition"], PDO::PARAM_STR);
            $stmt->bindParam(':wind', $row["wind"], PDO::PARAM_STR);
            $stmt->bindParam(':weather', $row["weather"], PDO::PARAM_STR);
            $stmt->bindParam(':distance', $row["distance"], PDO::PARAM_INT);
            $stmt->bindParam(':speed', $row["speed"], PDO::PARAM_INT);
            $stmt->bindParam(':notes', $row["notes"], PDO::PARAM_STR);
            $stmt->execute();
        }
        return $this->log_id;
    }
    public function ShowUsersLogs($db){//selects the users logs in descending order by date
        $stmt = $db->prepare("SELECT user_id, log_id, start_location, destination, water_type, summary, last_edit, public, votes
        FROM logs
        WHERE user_id = :user_id
        ORDER BY last_edit DESC");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function ShowLogInfo($db, $log_id){//selects the info for the log
        $stmt = $db->prepare("SELECT logs.*, users.f_name, users.s_name
        FROM logs, users
        WHERE logs.user_id = users.user_id
        AND logs.log_id = :log_id");
        $stmt->bindParam(':log_id', $log_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function ShowLogContents($db, $log_id){//selects the contents of the log
        $stmt = $db->prepare("SELECT *
        FROM log_contents
        WHERE log_id = :log_id");
        $stmt->bindParam(':log_id', $log_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function ShowLogCrews($db, $log_id){//selects the crew members
        $stmt = $db->prepare("SELECT *
        FROM log_crews
        WHERE log_id = :log_id");
        $stmt->bindParam(':log_id', $log_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function ChangeVote($db, $log_id, $votes, $operation){//called when up or down vote clicked
        if ($operation == "up"){
            $votes++; //add a vote
        }else{
            $votes--; //or decrease the vote
        }
        $stmt = $db->prepare("UPDATE logs
        SET votes = :votes
        WHERE log_id = :log_id");
        $stmt->bindParam(':votes', $votes, PDO::PARAM_INT);
        $stmt->bindParam(':log_id', $log_id, PDO::PARAM_INT);
        $stmt->execute();
        Header('Location: '.$_SERVER['PHP_SELF'].'?log_id='.$log_id);
    }
    public function ShowTopLogs($db){ //show the top 10 logs ordered by votes
        $stmt = $db->prepare("SELECT logs.*, .users.f_name, users.s_name
        FROM logs, users
        WHERE logs.public = 1
        AND logs.user_id = users.user_id
        ORDER BY votes DESC
        LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function ShowRecentLogs($db){ //show top 10 logs ordered by date
        $stmt = $db->prepare("SELECT logs.*, users.f_name, users.s_name
        FROM logs, users
        WHERE logs.public = 1
        AND logs.user_id = users.user_id
        ORDER BY last_edit DESC
        LIMIT 10");
        $stmt->execute();        
        return $stmt->fetchAll();
    }
    public function SearchLogs($db, $term){//search the logs for multiple terms
        $i = 0;
        $term = htmlentities(strtolower($term));//sanitize the search 
        $terms = explode(" ", $term); //sepearet each word in the search into an array
        foreach ($terms as $term){ //for each word in the search
            $term = trim($term); //remove whitespace on the ends
            //sql to query the database for terms like the search word
            $search[$i] = "LOWER(logs.start_location) LIKE '%".$term."%' OR LOWER(logs.destination) LIKE '%".$term."%' OR LOWER(logs.summary) LIKE '%".$term."%'";
            $i++;
        }
        $search = implode(" OR ", $search); //join all the search together, with an "OR" between
        //distinct - only shows each one once
        $stmt = $db->prepare("SELECT DISTINCT logs.*, .users.f_name, users.s_name 
        FROM logs, users
        WHERE (logs.public = 1)
        AND (logs.user_id = users.user_id)
        AND (".$search.")
        ORDER BY votes DESC
        LIMIT 10");
        $stmt->bindParam(":search", $search, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ValidOwner($db, $log_id){ //check if the log was cretaed by the user logged on
        $log_id = htmlentities($log_id);
        $stmt = $db->prepare("SELECT user_id
        FROM logs
        WHERE log_id = :log_id");
        $stmt->bindParam(":log_id", $log_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result["user_id"] == $_SESSION["user_id"]){
            return true;
        } 
    }
    public function GetLogId(){//return the log_id of the current log
        return $this->log_id;
    }
    
}
?>