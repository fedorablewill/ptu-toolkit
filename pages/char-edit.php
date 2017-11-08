<?php

if (file_exists($file = __DIR__.'/../lib/propel2/vendor/autoload.php')) {
    $loader = require $file;

    $loader->register();
}

use Propel\PtuToolkit\CharactersQuery;
use Propel\Runtime\Propel;

Propel::init(__DIR__ . '/../lib/propel2/config.php');

$campaign_id = 34;

$character = CharactersQuery::create()
    ->filterByCampaignId($campaign_id)
    ->findByCharacterId($_GET['id'])[0];
?>

<div class="modal fade" id="modalSimpleSheet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="myModalLabel">Add/Edit Pokémon</h3>
            </div>

            <input type="hidden" id="addmon-id" value="" />

            <div class="modal-body form-addmon">
                <small><i>Feature is work in progress</i></small>

                <h4>Basic Info</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-name">Name</label>
                    <input class="form-control" type="text" id="addmon-name" value="<?php echo $character->getName()?>" required />
                </div>
                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-dex">Pokédex ID</label>
                    <input class="form-control" type="text" id="addmon-dex" value="<?php echo $character->getPokedexId()?>" required />
                </div>
                <?php endif; ?>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-type1">Type 1</label>
                        <select class="form-control" id="addmon-type1" data-required="POKEMON"><option></option></select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-type2">Type 2</label>
                        <select class="form-control" id="addmon-type2" data-populate="type"><option></option></select>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-level">Level</label>
                        <input class="form-control" type="number" id="addmon-level" data-field="level" required />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-exp">EXP</label>
                        <input class="form-control" type="number" id="addmon-exp" data-field="EXP" value="0" />
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-gender">Gender</label>
                        <select class="form-control" id="addmon-gender" data-field="gender" required>
                            <option>Genderless</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                </div>
                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-nature">Nature</label>
                        <select class="form-control" id="addmon-nature" data-field="nature" data-populate="nature" required>
                            <option></option>
                        </select>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-discover">Discovered at</label>
                    <input class="form-control" type="text" id="addmon-discover" data-field="discovery" />
                    <p class="help-block">Where was the Pokémon found</p>
                </div>
                <?php endif; ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-item">Held Item</label>
                    <input class="form-control" type="text" id="addmon-item" data-field="held-item" />
                </div>

                <hr/>

                <h4>Health <small class="text-warning" id="warn-health"></small></h4>

                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-health">Current Health</label>
                        <input class="form-control" type="number" id="addmon-health" data-field="health" />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="addmon-injure">Injuries</label>
                        <input class="form-control" type="number" id="addmon-injure" data-field="injuries" value="0" />
                    </div>
                </div>

                <hr/>

                <h4>Stats <small class="text-warning" id="warn-stats"></small></h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-hp">HP (Stat)</label>
                    <input class="form-control" type="number" id="addmon-hp" data-field="hp" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-atk">Attack</label>
                    <input class="form-control" type="number" id="addmon-atk" data-field="atk" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-def">Defense</label>
                    <input class="form-control" type="number" id="addmon-def" data-field="def" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-spatk">Special Attack</label>
                    <input class="form-control" type="number" id="addmon-spatk" data-field="spatk" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-spdef">Special Defense</label>
                    <input class="form-control" type="number" id="addmon-spdef" data-field="spdef" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-speed">Speed</label>
                    <input class="form-control" type="number" id="addmon-speed" data-field="speed" required />
                </div>

                <hr/>

                <h4>Moves & Abilities</h4>

                <!-- TODO: make moves add/remove -->
                <label for="addmon-moves">Moves</label>
                <div id="addmon-moves">
                    <select class="form-control" title="Move 1" required data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 2" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 3" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 4" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 5" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 6" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 7" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 8" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 9" data-populate="move"><option></option></select>
                </div>
                <label for="addmon-moves">Abilities</label>
                <div id="addmon-abilities">
                    <select class="form-control" title="Ability 1" data-required="POKEMON" data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 2" data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 3" data-populate="ability"><option></option></select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-addmon">Save</button>
            </div>
        </div>
    </div>
</div>
