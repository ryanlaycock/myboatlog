<?php session_start(); ?>
<div id="loginform">
    <h2>Welcome Back!</h2>
    <br>
    <form method="post">
        <input type="email" name="email" placeholder="Email" value="<?php if(isset($_SESSION["login_email"])){echo $_SESSION["email"];}?>" required><br>
        <input type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
               title="Password must contain at least 1 '0-9', 1 'A-Z', 1 'a-z' and must be longer than 8 characters." required><br>
        <?php if (isset($_SESSION["login_error"])){echo $_SESSION["login_error"];}?>
        <input type="submit" name="login" id="login" value="Login" onclick="loginButton()">
    </form>
    <br>
    <a href="" onclick="registerButton()"><p>Don't have an account? Click to register!</p></a>
</div>
