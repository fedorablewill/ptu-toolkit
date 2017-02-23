<?php

$f = file_get_contents("../../data/moves.json") or die("Could not open file..");

if(array_key_exists("name", $_GET)) {
    $moves = json_decode($f, true);
    echo json_encode($moves[$_GET['name']]);
}
else if (array_key_exists("names", $_GET)) {
    $moves = json_decode($f, true);
    $args = json_decode($_GET['names'], true);
    $arr = array();

    foreach ($args as $arg)
        $arr[$arg] = $moves[$arg];

    echo json_encode($arr);
}
else
    echo $f;