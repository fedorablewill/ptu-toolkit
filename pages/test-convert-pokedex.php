<?php

eval(file_get_contents(__DIR__."/../../../sql/ptu/db.php"));

$json = json_decode(file_get_contents(__DIR__."/../data/ptu_pokedex_1_05.json"), true);

foreach ($json as $id=>$data) {
    $stmt = $db->prepare("INSERT INTO data_pokedex_entry (pokedex_no, pokedex_id, data) VALUES (:dex, 1, :data)");
    $stmt->bindParam(':dex', $id);
    $stmt->bindParam(':data', json_encode($data));

    $stmt->execute();
}