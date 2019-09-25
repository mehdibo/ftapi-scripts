<?php

define("ABS", __DIR__);

require_once ABS."/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(ABS);
$dotenv->load();

$zend = new \Zend\Http\Client();
$token = new \Spoody\Intra\Token($zend, $_ENV['API_ENDPOINT'], $_ENV['CLIENT_ID'], $_ENV['CLIENT_SECRET']);
$intraRequest = new \Spoody\Intra\Request($zend, $_ENV['API_ENDPOINT'], $token);