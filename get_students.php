#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 2)
{
    die("{$argv[0]} campus_id\n");
}

$campus_id = (int) $argv[1];

$cursus_ids = [
	1,	// 42
	21,	// 42cursus
];

function getLevel(Stdclass $user, int $cursus):float
{
	$cursus_users = $user->cursus_users;
	foreach ($cursus_users as $cursus_user) {
		if ($cursus_user->cursus_id === $cursus)
			return $cursus_user->level;
	}
	return -1;
}

fputcsv(STDOUT, ['Login', 'First name', 'Last name', 'E-mail', 'Level']);

foreach ($cursus_ids as $cursus_id) {
	$data = [
		'filter[campus_id]' => $argv[1],
		'filter[blackholed]' => 'false',
		'sort' => 'created_at',
		'page' => 1,
	];
	do {
		$response = $intraRequest->get("/v2/cursus/$cursus_id/cursus_users", $data);
		$response = json_decode($response);
		foreach ($response as $cursus_user)
		{
			$user_details = $intraRequest->get('/v2/users/'.$cursus_user->user->id);
			$user_details = json_decode($user_details);
			if ($user_details->{'staff?'})
				continue;
			$row = [
				$user_details->login,
				$user_details->first_name,
				$user_details->last_name,
				$user_details->email,
				getLevel($user_details, $cursus_id),
			];
			fputcsv(STDOUT, $row);
		}
		$data['page']++;
	} while (count($response) > 0);
}


