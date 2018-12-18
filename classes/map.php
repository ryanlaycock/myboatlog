<?php
class Map{
    //define the properties
    private $name;
    private $description;
    private $lat;
    private $long;
    private $type;
    private $email;
    private $website;
    private $phone_number;
    private $valid = True;
    
    public function CreateMap($data){ //Retrieve the data from the create a map 
        $this->name = htmlentities(ucwords(strtolower($data->name)));
        $this->description = htmlentities($data->description);
        $this->lat = htmlentities($data->lat);
        $this->long = htmlentities($data->long);
        $this->type = htmlentities(ucwords($data->type));
        $this->email = htmlentities(strtolower($data->email));
        $this->website = filter_var(strtolower($data->website), FILTER_SANITIZE_URL);
        $this->phone_number = htmlentities(str_replace(" ", "", $data->phone_number));

    }
    
    public function Validate(){
         $this->ValidateName($this->name);
         $this->ValidateDescription($this->description);
         $this->ValidateLatitude($this->lat);
         $this->ValidateLongitude($this->long);
         $this->ValidateType($this->type);
         $this->ValidateEmail($this->email);
         $this->ValidateWebsite($this->website);
         $this->ValidatePhoneNumber($this->phone_number);
        
        return $this->valid;
    }
    //see logs comments for description of validation methods
    private function ValidateName($name){
        if (empty($name)){ //checks if empty
            $this->valid = False;
        }else if (strlen($name)>= 30){ //checks max length
            $this->valid = False;
        }else if(!preg_match("/^[a-zA-Z ]*$/",$name)){ //checks format
            $this->valid = False;
        }
    }
    private function ValidateDescription($description){
        if (strlen($description)>=500){
            $this->valid = False;
        }
    }
    private function ValidateEmail($email){    
        if ($email != " " && $email != ""){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
                $this->valid = False;
            }
        }
    }
    private function ValidateType($type){
        if (!isset($type)){
            $this->valid = False;
        }else if(strlen($type >=30)){
            $this->valid = False;
        }
    }
    private function ValidateWebsite($website){
        if (!$website != " " && $website != ""){
            if (!isset(parse_url($website)["scheme"])){//checks if "http://" is included
                $website = "http://".$website; //add if not
                $this->website = $website;
            }
            if (filter_var($website, FILTER_VALIDATE_URL) === false) {
                $this->valid = False;
            }
        }
    }
    private function ValidatePhoneNumber($phone_number){
        if ($phone_number != " " && $phone_number != ""){
             if(!preg_match("/^[0-9]*$/",$phone_number)){
                $this->valid = False;
             }else if (strlen($phone_number) >=15) {
                $this->valid = False;
            }
        }
    }
    private function ValidateLatitude($lat){
        if (!isset($lat)){
            $this->Valid = False;
        }else if(is_int($lat)){
            if ($lat < -90 || $lat > 90){
                $this->Valid = False;
            }
        }else{
            $this->Valid = False;
        }
    }      
    private function ValidateLongitude($long){
        if (!isset($long)){
            $this->Valid = False;
        }else if(is_int($long)){
            if ($long < -180 || $long > 180){
                $this->Valid = False;
            }
        }else{
            $this->Valid = False;
        }
    }
     private function GetTime(){
        date_default_timezone_set('GMT');
        return date("Y-m-d H:i");
    }
    public function Create($db){ //add the POI to the database
        $time = $this->GetTime();
        $stmt = $db->prepare("INSERT INTO pois (user_id, name, description, longitude, latitude, type, email, website, phone_number, last_edit, votes)
        VALUES (:user_id, :name, :description, :longitude, :latitude, :type, :email, :website, :phone_number, :last_edit, 0)");
        $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':longitude', $this->long, PDO::PARAM_STR);
        $stmt->bindParam(':latitude', $this->lat, PDO::PARAM_STR);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':website', $this->website, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $this->phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':last_edit', $time, PDO::PARAM_STR);
        $stmt->execute();  
    }        
    public function ShowPois($db, $bounds){ //retrieve all the pois
        $stmt = $db->prepare("SELECT pois.*, users.f_name, users.s_name
        FROM pois, users
        WHERE pois.user_id = users.user_id AND
        longitude < :east AND longitude > :west AND
        latitude > :south AND latitude < :north
        ORDER BY votes DESC
        LIMIT 3"); 
        $stmt->bindParam(':north',$bounds["north"]);
        $stmt->bindParam(':east',$bounds["east"]);
        $stmt->bindParam(':south',$bounds["south"]);
        $stmt->bindParam(':west',$bounds["west"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $bounds["north"];
    }

    public function ShowVote($db, $poi_id){ //retrieve the votes
        $stmt = $db->prepare("SELECT pois.votes
        FROM pois
        WHERE poi_id = :poi_id");
        $stmt->bindParam(':poi_id',$poi_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function ShowUsersPois($db){// show all the users pois
        $stmt = $db->prepare("SELECT pois.*
        FROM pois
        WHERE user_id = :user_id
        ORDER BY last_edit DESC ");
        $stmt->bindParam(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function ChangeVote($db, $poi_id, $votes, $operation){ //updates the vote (see log.php comments)
        if ($operation == "up"){
            $votes++;
        }else{
            $votes--;
        }
        $stmt = $db->prepare("UPDATE pois
        SET votes = :votes
        WHERE poi_id = :poi_id");
        $stmt->bindParam(':votes', $votes, PDO::PARAM_INT);
        $stmt->bindParam(':poi_id', $poi_id, PDO::PARAM_INT);
        $stmt->execute();
        return $votes;
    }
}
?>