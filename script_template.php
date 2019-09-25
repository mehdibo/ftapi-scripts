#!/usr/bin/php
<?php

require_once __DIR__."/src/bootstrap.php";

echo "Getting information about token...\n";

$response = $intraRequest->get('/oauth/token/info');
$response = json_decode($response);

var_dump($response);