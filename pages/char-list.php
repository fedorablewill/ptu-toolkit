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

$characters = CharactersQuery::create()->find();

foreach ($characters as $character): ?>

    <h1><?php echo $character->getName();?></h1>
    <?php
    $ownedChars = CharactersQuery::create()
        ->findByOwner($character->getCharacterId());

    foreach ($ownedChars as $ownedChar): ?>
        <h3><?php echo $ownedChar->getName();?></h3>
    <?php endforeach; ?>

<?php endforeach; ?>
