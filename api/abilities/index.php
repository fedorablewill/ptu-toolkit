<?php

$f = file_get_contents("../../data/abilities.json") or die("Could not open file..");

if(array_key_exists("name", $_GET)) {
    $abilities = json_decode($f, true);
    echo json_encode($abilities[$_GET['name']]);
}
else if (array_key_exists("names", $_GET)) {
    $abilities = json_decode($f, true);
    $args = json_decode($_GET['names'], true);
    $arr = array();

    foreach ($args as $arg)
        $arr[$arg] = $abilities[$arg];

    echo json_encode($arr);
}
else
    echo $f;
