#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 2)
    die("{$argv[0]} login\n");

$login = $argv[1];

$response = $intraRequest->get("/v2/users/$login/locations");
$response = json_decode($response);

if (empty($response) || $response[0]->end_at !== NULL)
    die("User not found or not logged in\n");

echo $login." is logged in ".$response[0]->host.PHP_EOL;