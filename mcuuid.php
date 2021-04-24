<?php

$output = "Invalid username";
$name = "";
if (isset($_GET["name"]) && $_GET["name"] != "") {
    $name = htmlspecialchars($_GET["name"]);
    $uuid = strlen($name) == 32;
    try {
        // @ to ensure that errors aren't passed even if error reporting is on cuz good language
        if ($uuid)
            /** @noinspection PhpUsageOfSilenceOperatorInspection */
            $response = @file_get_contents("https://api.mojang.com/user/profiles/" . $name . "/names");
        else
            /** @noinspection PhpUsageOfSilenceOperatorInspection */
            $response = @file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $name);
        if ($response !== false) {
            $json = json_decode($response, true);
            if ($uuid) {
                if (count($json) > 0) $output = "Name: " . $json[count($json) - 1]["name"];
            } elseif (isset($json["id"])) $output = "UUID: " . $json["id"];
        }
    } catch (Exception $e) {
    }
} else $output = "";


if (isset($output) && $output !== "") echo $output;