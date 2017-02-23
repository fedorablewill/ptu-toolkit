<?php

$box = json_decode(file_get_contents("box.json"), true);
$moves = json_decode(file_get_contents("../data/moves.json"), true);
$dex = simplexml_load_file("../data/Pokemon.xml") or die("Error: Cannot create object");

foreach ($box as $name => $char) {
    if (array_key_exists($_GET['p'], $char["pokemon"])) {
        $pokemon = $char["pokemon"][$_GET['p']];

        $pokemon["max-hp"] = $pokemon["level"] * 2 + $pokemon["hp"] * 3 + 10;

        $pokemon["move-info"] = array();

        foreach($pokemon["moves"] as $move) {
            if ($move != "") {
                $pokemon["move-info"][$move] = $moves[$move];
            }
        }

        $entry = $dex->Pokemon[$pokemon["dex"] - 1];
        $pokemon["types"] = $entry->type;

        echo json_encode($pokemon);
        die();
    }
}

die("No pokemon found");