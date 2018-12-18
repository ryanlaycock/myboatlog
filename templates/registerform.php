<?php session_start(); ?>
<div id="registerform">
    <h2>Welcome To My Boat Log!</h2>
    <form method="post">
        <input type="text" name="first_name" placeholder="First Name" maxlength="30" pattern="[a-zA-Z]+$" title="A-Z and a-z only." 
               value="<?php if(isset($_SESSION["first_name"])){echo $_SESSION["first_name"];}?>" required ><br>
        <input type="text" name="second_name" placeholder="Second Name" maxlength="30" pattern="[a-zA-Z]+$" title="A-Z and a-z only." 
               value="<?php if(isset($_SESSION["second_name"])){echo $_SESSION["second_name"];}?>" required><br>
        <input type="email" name="email" placeholder="Email" minlength="8" 
               value="<?php if(isset($_SESSION["register_email"])){echo $_SESSION["register_email"];}?>" required><br>
        <input type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
               title="Password must contain at least 1 '0-9', 1 'A-Z', 1 'a-z' and must be longer than 8 characters."required><br>
        <input type="password" name="conf_password" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
               title="Password must contain at least 1 '0-9', 1 'A-Z', 1 'a-z' and must be longer than 8 characters."required><br>
        <?php if (isset($_SESSION["register_error"])){echo $_SESSION["register_error"];}?>
        <div id="agreewrapper">
            <input type="checkbox" id="agree" required >
            <div id="agreetext">By ticking this box and using this site you agree to our <a href="/terms/">terms</a>.</div>
        </div>
        <input type="submit" name="register" id="register" value="Register" onclick="registerButton()">
        <a href="" onclick="loginButton()"><p>Already a member? Click to sign in!</p></a>
    </form>
</div>
