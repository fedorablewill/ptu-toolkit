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

foreach ($characters as $character): ?>

    <div class="char-list char-list-select">
        <div class="char-item char-owner" data-id="<?php echo $character->getCharacterId();?>">
            <span class="char-name"><strong><?php echo $character->getName();?></strong></span>
            <?php
            $ownedChars = CharactersQuery::create()
                ->findByOwner($character->getCharacterId());

            foreach ($ownedChars as $ownedChar): ?>
                <div class="char-item char-owned" data-id="<?php echo $ownedChar->getCharacterId();?>">

                    <span class="char-name"><?php echo $ownedChar->getName();?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php endforeach; ?>
