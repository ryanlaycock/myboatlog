<?php
class User{
    private $first_name; 
    private $second_name;
    private $email;
    private $password;
    private $conf_password;
    private $valid = True;
    private $email_used;
    private $verify_code;
    private $verified;
    private $user_id;
    
    public function CreateRegisterUser($first_name, $second_name, $email, $password, $conf_password){
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->email = $email;
        $this->password = $password;
        $this->conf_password = $conf_password;
    }
    
    public function Validate(){ //validating data
        $this->first_name = htmlentities(ucfirst(strtolower($this->first_name)));//only 1st letter uppercase
        $this->second_name = htmlentities(ucfirst(strtolower($this->second_name)));// and remove malicious code
        $this->email = htmlentities(strtolower($this->email));
        
        $this->ValidateName($this->first_name); //call specific validate function
        $this->ValidateName($this->second_name);
        $this->ValidateEmail($this->email);
        $this->ValidatePassword($this->password, $this->conf_password);      
        
        return $this->valid; //return bool if valid or not
    }  
    
    private function ValidateName($name){    
        //first_name
        if (empty($name)){ //checks if empty
            $this->valid = False;
        }else if (strlen($name)>= 30){ //checks max length
            $this->valid = False;
        }else if(!preg_match("/^[a-zA-Z ]*$/",$name)){ //checks format
            $this->valid = False;
        }
    }   

    private function ValidateEmail($email){    
        //email
        if (empty($email)){
            $this->valid = False;
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $this->valid = False;
        }
    }   
    
    private function ValidatePassword($password, $conf_password){
        if (empty($password)){
            $this->valid = False;
        }else if (strlen($password) < 8){
            $this->valid = False;
        }else if(!preg_match('/[0-9]/',$password)){
            $this->valid = False;
        }else if(!preg_match('/[a-z]/',$password)){
            $this->valid = False;
        }else if(!preg_match('/[A-Z]/',$password)){
            $this->valid = False;
        }else if ($this->password != $conf_password){
            $this->valid = False;
        }else if (empty($conf_password)){
            $this->valid = False;
        }
    }
    
    public function EmailUsed($db){
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email',$this->email);
        $stmt->execute();
        if ($stmt->rowCount() > 0){
            $this->email_used = True;
        }else{
            $this->email_used = False;
            $this-> Hash();
        }
        return $this->email_used;
    }
      
    private function Hash(){ //password hash
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    public function SendEmailVerify(){ //sends the verification email 
        $api_key = "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";
        $sendgrid = new SendGrid($api_key); //new SendGrid object
        $email = new SendGrid\Email(); 
        $html = emailHtml($this->first_name, $this->email, $this->verify_code); //call to function that prepares the content
        $subject = emailSubject($this->first_name); //call to fucntion that sets the subject
        //set the propereties for the api
        $email 
            ->addTo($this->email)
            ->setFrom('mail@myboatlog.com')
            ->setSubject($subject)
            ->setHtml($html);
            ;
        $sendgrid->send($email); //call the function to send the email
    }
    
    private function GenerateVerifyCode(){ //creates the verification code
        $code = "";
        $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";//available characerts
        $length = 64; //length of the code
        for ($i = 0; $i < 64; $i++) { //go until length is 64
            $code .= $char[rand(0, strlen($char)-1)]; //add random character to the code variable
        }
        $this->verify_code = $code;
    }
    
    public function Register($db){
        $this->GenerateVerifyCode(); //generates the code
        $stmt = $db->prepare("INSERT INTO users (f_name, s_name, email, password, verified, verify_code) 
        VALUES (:first_name, :second_name, :email, :password, :verified, :verify_code)");
        $stmt->bindParam(':first_name', $this->first_name, PDO::PARAM_STR);
        $stmt->bindParam(':second_name', $this->second_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        $stmt->bindValue(':verified',0, PDO::PARAM_BOOL);
        $stmt->bindParam(':verify_code', $this->verify_code, PDO::PARAM_STR);
        $stmt->execute();
        $this->SendEmailVerify();//add the users data to the database
    }
    public function Verify($db, $email, $code){ //runs when the user is verifying their account
        $this->email = htmlentities(strtolower($email));
        $this->verify_code = htmlentities($code);
        $this->ValidateEmail($email);
        if($this->valid){ //if all the data is valid
            $stmt = $db->prepare("SELECT user_id, verify_code FROM users WHERE email = :email");
            $stmt->bindParam(':email',$this->email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($this->verify_code == $result["verify_code"]){ //if verify code entered matches database record 
                $this->user_id = $result["user_id"];
                $stmt = $db->prepare("UPDATE users SET verified=:verified WHERE email=:email");
                $stmt->bindValue(':verified', 1, PDO::PARAM_INT);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->execute(); //update to verified
                return true;
            }else{ //if they dont match
                return false;
            }
        }
    }
    public function AutoCompleteRegister(){ //retrieves the data to fill in the register form for when the page resets
        session_unset(); 
        $_SESSION["first_name"] = $this->first_name;
        $_SESSION["second_name"] = $this->second_name;
        $_SESSION["register_email"] = $this->email;
    }
    
////////////////////////////////////LOGIN/////////////////////////////////////////////////////
//
//
///////          DOES USER NAME GET CHECKED?
    public function CreateLoginUser($email, $password){ //called when user logs in
        $this->email = htmlentities(strtolower($email));
        $this->password = $password;
    }
    public function CorrectLogin($db){ //checks to see if the login is successful
        $stmt = $db->prepare("SELECT user_id, password, verified FROM users WHERE email = :email");
        $stmt->bindParam(':email',$this->email);
        $stmt->execute(); //select password for given email
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->verified = $result["verified"];
        $this->user_id = $result["user_id"];
        if (password_verify($this->password, $result["password"])){
            return true;
        }else{
            return false;
        }
    }
    public function Verified(){ //see if the user has verified their account
        if ($this->verified == 1){
            return true;
        }else{
            return false;
        }
    }
    public function AutoCompleteLogin(){ //like the regsiter version, auto fills in field after page refresh
        session_unset(); 
        $_SESSION["register_email"] = $this->email; //sets the session variable which survives through page refresh
    }
    public function GetUserID(){ //returns the user_id property
        return $this->user_id;
    }
} 
?>