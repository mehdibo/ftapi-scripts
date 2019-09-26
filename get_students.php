#!/usr/bin/env php
<?php

require_once __DIR__."/src/bootstrap.php";

if ($argc != 2)
{
    die("{$argv[0]} campus_id\n");
}

$campus_id = (int) $argv[1];
$data = [
    'filter[campus_id]' => $argv[1],
    'filter[blackholed]' => 'false',
    'sort' => 'created_at',
    'page' => 1,
];

do {
    $response = $intraRequest->get("/v2/cursus/1/cursus_users", $data);
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
        ];
        fputcsv(STDOUT, $row);
    }
    $data['page']++;
} while (count($response) > 0);
