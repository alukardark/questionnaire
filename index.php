<?php
ob_start();
session_start();
require __DIR__."/autoload.php";

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);

$ctrl = !empty($pathParts[1]) ? $pathParts[1] : 'Questionnaire';
$act = !empty($pathParts[2]) ? $pathParts[2] : 'Start';

$ctrl = $ctrl.'Controller';
$controller = new $ctrl();

$act = 'action'.$act;
$controller->$act();



?>


