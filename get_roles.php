#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

$response = $intraRequest->get('/v2/roles');
$response = json_decode($response);

fputcsv(STDOUT, ['Name', 'Description']);
foreach ($response as $role)
{
	fputcsv(STDOUT, [$role->name, $role->description]);
}