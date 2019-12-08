#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

die("TODO\n");
if ($argc != 3)
{
	die("{$argv[0]} logins.txt reason\nlogins.txt is a file with a login per line\n");
}

$logins_file = $argv[1];
$reason = $argv[2];
$post_data = [
	'close[kind]' => 'other',
	'close[reason]' => $reason,
];

$handle = fopen($logins_file, "r");

if (!$handle)
	die("Unable to open file\n");

while (($login = fgets($handle)) !== false) {
	$login = trim($login);
	$response = $intraRequest->post("/v2/users/$login/closes", $post_data);
	$response = json_decode($response);
	if (isset($response->error))
		echo $response->message."\n";
}