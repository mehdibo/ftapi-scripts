#!/usr/bin/php
<?php

require_once __DIR__."/src/bootstrap.php";

$response = $intraRequest->get('/v2/campus');
$response = json_decode($response);

foreach ($response as $campus)
{
    echo $campus->name.":".$campus->id.PHP_EOL;
}