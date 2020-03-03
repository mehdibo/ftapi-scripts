#!/usr/bin/env php
<?php
require_once __DIR__."/src/bootstrap.php";

if ($argc != 7)
{
	die("{$argv[0]} login email first_name last_name kind campus_id\n");
}

$data = [
	'user[login]' => $argv[1],
	'user[email]' => $argv[2],
	'user[first_name]' => $argv[3],
	'user[last_name]' => $argv[4],
	'user[kind]' => $argv[5],
	'user[campus_id]' => (int) $argv[6],
];

if (!in_array($data['user[kind]'], ['admin', 'student', 'external']))
	die("Kind must be either admin, student or external");

$response = $intraRequest->post("/v2/users", $data);
var_dump($response);
