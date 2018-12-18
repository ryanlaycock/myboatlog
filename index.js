$(document).ready(function(){
    var form = "";
    
    
    function load(form, destination, remove){
        $.get('/templates/' + form + '.php', function(template){ //retrieve the crew template and assign to template
            form = template; //assign to crew_template to make it avaialabe
            if (remove){
                $("#registerform").remove();
                $("#loginform").remove();
            }
            $(destination).append(form);
        });
    }
    
    if(sessionStorage.getItem('show') == "loginform"){
        load("loginform", "#form", true);
    }else{
        load("registerform", "#form", true);
    }
    
    $("#loginbutton").click(function(){
        load("loginform", "#form", true);
    });
    $("#registerbutton").click(function(){
        load("registerform", "#form", true);
    });
    
    window.loginButton = function(){
        sessionStorage.setItem('show', 'loginform');
    }
    
    window.registerButton = function(){
        sessionStorage.setItem('show', 'registerform');
    }
    
    if(navigator.appName != "Netscape"){
        load("update_browser_form", "#info", false)
    }
    
});
