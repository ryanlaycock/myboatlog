<?php
//composes the content of the email
function emailHtml($first_name, $email, $code){
    $html =     
        "<head><style>body{text-align:center;}</style></head>
        <body>
        <h2> Welcome " . $first_name . " to My Boat Log!</h2>
        <h2>There's just 1 last thing before you're set up.</h2>
        <a href='http://clinic-match.codio.io:5000/verify/?email=" . $email . "&code=" . $code . "'>Click this link to register your account</a>
        </body>
        ";
    return $html;
}
//composes the subject of the email
function emailSubject($first_name){
    $subject="Welcome ".$first_name." to My Boat Log!";
    return $subject;
}
?>