<?php

eval(file_get_contents(__DIR__."/../../../sql/ptu/db.php"));

$json = json_decode(file_get_contents(__DIR__."/../data/moves.json"), true);

foreach ($json as $name=>$data) {
    $stmt = $db->prepare("INSERT INTO moves (pokedex_id, name, effect, freq, class, `range`, contest_type, contest_effect, crits_on, type, triggers)
      VALUES (1, :name, :effect, :freq, :class, :range, :contest_type, :contest_effect, :crits_on, :type, :triggers)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':effect', array_key_exists('Effect', $data) ? ($data['Effect']) : null);
    $stmt->bindParam(':freq', array_key_exists('Freq', $data) ? ($data['Freq']) : null);
    $stmt->bindParam(':class', array_key_exists('Class', $data) ? ($data['Class']) : null);
    $stmt->bindParam(':range', array_key_exists('Range', $data) ? ($data['Range']) : null);
    $stmt->bindParam(':contest_type', array_key_exists('Contest Type', $data) ? ($data['Contest Type']) : null);
    $stmt->bindParam(':contest_effect', array_key_exists('Contest Effect', $data) ? ($data['Contest Effect']) : null);
    $stmt->bindParam(':crits_on', array_key_exists('Crits On', $data) ? ($data['Crits On']) : null);
    $stmt->bindParam(':type', array_key_exists('Type', $data) ? ($data['Type']) : null);
    $stmt->bindParam(':triggers', array_key_exists('Triggers', $data) ? json_encode($data['Triggers']) : null);

    $stmt->execute();
}