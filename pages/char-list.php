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
        "name" => $character->getName(),
        "owned" => array()
    );

    $ownedChars = CharactersQuery::create()
        ->findByOwner($character->getCharacterId());

    foreach ($ownedChars as $ownedChar) {
        array_push($char['owned'], array(
            "id" => $ownedChar->getCharacterId(),
            "name" => $ownedChar->getName()
        ));
    }

    array_push($output, $char);
}

echo json_encode($output);

