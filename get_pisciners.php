#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

// campus_id piscine_month piscine_year
if ($argc != 4)
{
    die("{$argv[0]} campus_id piscine_month piscine_year\n");
}

$campus_id = (int) $argv[1];
$data = [
    'filter[pool_month]' => $argv[2],
    'filter[pool_year]' => $argv[3],
    'page' => 1,
];

do {
    $response = $intraRequest->get("/v2/campus/$campus_id/users", $data);
    $response = json_decode($response);
    foreach ($response as $user)
    {
        $user_details = $intraRequest->get('/v2/users/'.$user->id);
        $user_details = json_decode($user_details);
        $row = [
            $user_details->login,
            $user_details->first_name,
            $user_details->last_name,
            $user_details->email,
        ];
        fputcsv(STDOUT, $row);
    }
    $data['page']++;
} while (count($response) > 0);
