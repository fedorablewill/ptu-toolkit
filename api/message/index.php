<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/23/2017
 * Time: 12:05 AM
 */

if (array_key_exists("id", $_POST)) {
    $id = $_POST['id'];
    $fname = "$id.json";
    $to = $_POST['to'];
    $msg = $_POST['msg'];

    $json = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();

    array_push($json, array(
        "to" => $to,
        "body" => $msg
    ));

    $handle = fopen($fname, 'w') or die('Cannot open file:  '.$fname);
    $data = json_encode($json);
    fwrite($handle, $data);
    fclose($handle);

    echo $data;
}
else if (array_key_exists("id", $_GET)) {
    $id = $_GET['id'];
    $fname = "$id.json";
    $name = $_GET['name'];

    if (!file_exists($fname)) {
        echo "[]";
    }
    else {
        $json = json_decode(file_get_contents($fname), true);

        $out = array();
        $leftovers = array();

        foreach ($json as $j) {
            if ($j["to"] == $name)
                array_push($out, json_decode($j["body"]), true);
            else
                array_push($leftovers, $j);
        }

        $handle = fopen($fname, 'w') or die('Cannot open file:  '.$fname);
        $data = json_encode($leftovers);
        fwrite($handle, $data);
        fclose($handle);

        echo json_encode($out);
    }
}
else {
    http_response_code(400);
    die("Invalid command");
}