<?php
require("lib/sendgrid-php/sendgrid-php.php");
$api_key = "HERE";
$sendgrid = new SendGrid($api_key);

$email = new SendGrid\Email();
$email
    ->addTo('ryan.laycock@hotmail.co.uk')
    ->setFrom('mail@myboatlog.com')
    ->setSubject('My Boat Log is nearly set up for you %name%!')
    ->setHtml('<h1>Hello, %first_name%</h1>! Just one more step until your account at My Boat Log is set up!');
    ->setSubstitution("%name", $)
$sendgrid->send($email);
?>
