<?php

require_once('RD_Station.php');

$rdstation = new RD_Station($_POST);
$rdstation->token = 'Aec5waPho3AhFeez7wue0Oopohcheich';
$rdstation->identifier = 'Formulário de Contato';
$rdstation->ignore_fields = ['password', 'password_confirmation', 'captcha'];
$rdstation->redirect_success = 'test.php';
$rdstation->redirect_error = 'test.php';
$rdstation->createLead();

?>