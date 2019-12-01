#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 5)
{
	die("{$argv[0]} campus_id cursus_id points reason\nSet correction points to \$points if they are less than \$points\n");
}

$campus_id = (int) $argv[1];
$cursus_id = (int) $argv[2];
$points = (int) $argv[3];
$reason = $argv[4];
$data = [
	'filter[campus_id]' => $argv[1],
	'sort' => 'id',
	'page' => 1,
];

do {
	$users = $intraRequest->get("/v2/cursus/$cursus_id/cursus_users", $data);
	$users = json_decode($users);
	foreach ($users as $cursus_user)
	{
		$user_details = $intraRequest->get('/v2/users/'.$cursus_user->user->id);
		$user_details = json_decode($user_details);
		if ($user_details->{'staff?'} || $user_details->correction_point >= $points)
			continue;
		$to_add = $points - $user_details->correction_point;
		$body = [
			'id' => $user_details->login,
			'reason' => $reason,
			'amount' => $to_add,
		];
		echo "Adding ".$to_add." points to '".$user_details->login."'... ";
		$response = $intraRequest->post('/v2/users/'.$user_details->login.'/correction_points/add', $body);
		$response = json_decode($response);
		echo ((isset($response->error)) ? "Something went wrong: ".$response->message : 'Done.')."\n";
	}
	$data['page']++;
} while (count($users) > 0);
