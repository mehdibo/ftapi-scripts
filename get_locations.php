#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 2)
    die("{$argv[0]} login\n");

$login = $argv[1];

$response = $intraRequest->get("/v2/users/$login/locations");
$response = json_decode($response);

foreach ($response as $location) {
	if (!$location->end_at)
	{
		echo "$login is logged in at '".$location->host."' since '".$location->begin_at."'\n";
		continue;
	}
	echo "$login logged in at '".$location->host."' from '".$location->begin_at."' to '".$location->end_at."'\n";
}