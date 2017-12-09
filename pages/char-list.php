<?php

if (file_exists($file = __DIR__.'/../lib/propel2/vendor/autoload.php')) {
    $loader = require $file;

    $loader->register();
}

use Propel\PtuToolkit\CharactersQuery;
use Propel\Runtime\Propel;

Propel::init(__DIR__ . '/../lib/propel2/config.php');

$campaign_id = 34;

$characters = CharactersQuery::create()
    ->filterByCampaignId($campaign_id)
    ->filterByOwner(null)
    ->find();

$output = array();

foreach ($characters as $character) {
    $char = array(
        "id" => $character->getCharacterId(),
        "type" => $character->getType(),
        "dex" => $character->getPokedexNo(),
        "type1" => $character->getType1(),
        "type2" => $character->getType2(),
        "name" => $character->getName(),
        "owned" => array()
    );

    $ownedChars = CharactersQuery::create()
        ->findByOwner($character->getCharacterId());

    foreach ($ownedChars as $ownedChar) {
        array_push($char['owned'], array(
            "id" => $ownedChar->getCharacterId(),
            "type" => $ownedChar->getType(),
            "dex" => $ownedChar->getPokedexNo(),
            "type1" => $ownedChar->getType1(),
            "type2" => $ownedChar->getType2(),
            "name" => $ownedChar->getName()
        ));
    }

    array_push($output, $char);
}

echo json_encode($output);

