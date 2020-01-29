#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 3)
{
    die("{$argv[0]} campus_id project_id\n");
}

$campus_id = (int) $argv[1];
$project_id = (int) $argv[2];

$users_data = [
	'page' => 1,
];
$projects_data = [
	// 'range[final_mark]' => '90,115',
	'sort[created_at]' => '-created_at',
];
do {
	$response = $intraRequest->get("/v2/campus/$campus_id/users", $users_data);
	$response = json_decode($response);
	foreach ($response as $cursus_user)
	{
		$teams = $intraRequest->get('/v2/users/'.$cursus_user->id.'/projects/'.$project_id.'/teams', $projects_data);
		$teams = json_decode($teams);
		if (empty((array)$teams))
			continue;
		echo "Reseting '{$teams[0]->id}' for user '{$cursus_user->login}'...";
		$reset = $intraRequest->post("/v2/teams/{$teams[0]->id}/reset_team_uploads");
		$reset = json_decode($reset);
		if ($reset->status === "200")
		{
			echo "Done\n";
			continue;
		}
		var_dump($reset);
	}
	$users_data['page']++;
} while (count($response) > 0);



