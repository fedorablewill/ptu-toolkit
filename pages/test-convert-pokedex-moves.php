<?php

if (file_exists($file = __DIR__.'/../lib/propel2/vendor/autoload.php')) {
    $loader = require $file;

    $loader->register();
}

use Propel\PtuToolkit\DataPokedexEntryQuery;
use Propel\Runtime\Propel;

Propel::init(__DIR__ . '/../lib/propel2/config.php');

$entries = DataPokedexEntryQuery::create()->find();

$my_file = __DIR__ . '/pokedex_moves_data.csv';
$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

foreach ($entries as $entry) {
    $data = json_decode(stream_get_contents($entry->getData()), true);

    $moves_list = array();

    foreach ($data["LevelUpMoves"] as $move) {
        if (!array_key_exists($move["Name"], $moves_list))
            $moves_list[$move["Name"]] = array();

        $moves_list[$move["Name"]]["LevelLearned"] = $move["LevelLearned"];
    }

    foreach ($data["TmHmMoves"] as $move) {
        if (!array_key_exists($move["Name"], $moves_list))
            $moves_list[$move["Name"]] = array();

        $moves_list[$move["Name"]]["TechnicalMachineId"] = $move["TechnicalMachineId"];
    }

    foreach ($data["TutorMoves"] as $move) {
        if (!array_key_exists($move["Name"], $moves_list))
            $moves_list[$move["Name"]] = array();

        $moves_list[$move["Name"]]["Natural"] = $move["Natural"];
    }

    foreach ($data["EggMoves"] as $move) {
        if (!array_key_exists($move["Name"], $moves_list))
            $moves_list[$move["Name"]] = array();

        $moves_list[$move["Name"]]["EggMove"] = true;
    }

    // Put it all together

    foreach ($moves_list as $name=>$move) {
        $move_entry = \Propel\PtuToolkit\MovesQuery::create()->findOneByName($name);

        if ($move_entry != null) {
            print "Dex #".$entry->getPokedexNo();
            fwrite($handle, $entry->getPokedexId().',');
            fwrite($handle, $entry->getPokedexNo().',');
            fwrite($handle, $move_entry->getMoveId().',');
            fwrite($handle, (array_key_exists("LevelLearned", $move) ? $move["LevelLearned"] : 'NULL').',');
            fwrite($handle, (array_key_exists("TechnicalMachineId", $move) ? $move["TechnicalMachineId"] : 'NULL').',');
            fwrite($handle, (array_key_exists("Natural", $move) ? 1 : 'NULL').',');
            fwrite($handle, (array_key_exists("EggMove", $move) ? $move["EggMove"] : 'NULL').';');
        }
    }
}

fclose($handle)?>
