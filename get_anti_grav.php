#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 2)
{
    die("{$argv[0]} login\n");
}

$login = $argv[1];


$response = $intraRequest->get("/v2/users/$login/anti_grav_units_users ");
$response = json_decode($response);
foreach ($response as $freeze) {
	echo "Freeze created at '".$freeze->created_at."' and will finish at '".$freeze->expected_unfreezed_at."'\n";
	echo "The total duration is: ".$freeze->duration." days\n\n";
}