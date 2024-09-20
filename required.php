<?php 

require_once("./vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$mysqli = new mysqli($_ENV['HOST'],$_ENV['USR'],$_ENV['PASSWORD'],$_ENV['DATABASE']);