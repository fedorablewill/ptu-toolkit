<?php

if (file_exists($file = __DIR__.'/../lib/propel2/vendor/autoload.php')) {
    $loader = require $file;

    $loader->register();
}

use Propel\PtuToolkit\CharactersQuery;
use Propel\PtuToolkit\DataPokedexEntryQuery;
use Propel\Runtime\Propel;

Propel::init(__DIR__ . '/../lib/propel2/config.php');

$campaign_id = 34;
$character_id = $_GET['id'];

$character = CharactersQuery::create()
    ->filterByCampaignId($campaign_id)
    ->findByCharacterId($character_id)[0];

$pokedex_entry = DataPokedexEntryQuery::create()
    ->filterByPokedexNo($character->getPokedexNo())
    ->filterByPokedexId($character->getPokedexId())
    ->findOne();

$pokedex_data = json_decode(stream_get_contents($pokedex_entry->getData()), true);

$TYPE_LIST = array("Bug","Dragon","Ice","Fighting","Fire","Flying","Grass","Ghost","Ground","Electric","Normal","Poison","Psychic","Rock","Water","Dark","Steel");

$type_list1 = "";
$type_list2 = "";

foreach ($TYPE_LIST as $type) {
    $type_list1 .= $character->getType1() == $type ? '<option selected>'.$type.'</option>' : '<option>'.$type.'</option>';
    $type_list2 .= $character->getType2() == $type ? '<option selected>'.$type.'</option>' : '<option>'.$type.'</option>';
}

$MOVES_LIST = $character->getLearnableMovesJSON();
$moves = $character->getCharacterMovessJoinMoves();
?>

<div class="modal fade" id="modalCharSheet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-char-id="<?php echo $character_id;?>">
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
                    <input class="form-control" type="text" id="addmon-name" data-field="name" value="<?php echo $character->getName()?>" required />
                </div>
                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-dex">Pokédex ID</label>
                    <input class="form-control" type="text" id="addmon-dex" data-field="pokedex" value="<?php echo $character->getPokedexNo()?>" required />
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-type1">Type 1</label>
                            <select class="form-control" id="addmon-type1" data-field="type1" <?php
                            if ($character->getType() == "POKEMON") echo "required"; ?>><option></option><?php
                                echo $type_list1 ?></select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-type2">Type 2</label>
                            <select class="form-control" id="addmon-type2" data-populate="type" data-field="type2"><option></option><?php
                                echo $type_list2 ?></select>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-level">Level</label>
                            <input class="form-control" type="number" id="addmon-level" data-field="level" value="<?php echo $character->getLevel()?>"  required />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-exp">EXP</label>
                            <input class="form-control" type="number" id="addmon-exp" data-field="EXP" value="<?php echo $character->getExp()?>"  />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-gender">Gender</label>
                            <select class="form-control" id="addmon-gender" data-field="sex" value="<?php echo $character->getSex()?>"  required>
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
                </div>

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
                    <?php if ($moves->count() > 0) : ?>
                    <?php foreach ($moves as $move) : ?>
                    <input class="form-control" title="Move" value="<?php echo $move->getMoveId() ?>" />
                    <?php endforeach; else : ?>
                    <input class="form-control" title="Move" />
                    <?php endif; ?>
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

<script>
    $("#addmon-dex").autocomplete({
        source: mon_list
    });

    var moves_list = [
        <?php foreach ($MOVES_LIST as $move) :?>{
            "label": "<?php echo $move["Name"] ?> ",
            "value": "<?php echo $move["MoveId"] ?>",
            "LevelLearned": "<?php echo $move["LevelLearned"] ?>",
            "TechnicalMachineId": "<?php echo $move["TechnicalMachineId"] ?>",
            "Natural": "<?php echo $move["Natural"] ?>",
            "EggMove": "<?php echo $move["EggMove"] ?>"
        },<?php endforeach; ?>{"label": "test", "value": "ehh", "LevelLearned": "1"}
    ];

    $("#addmon-moves input").autocomplete({
        source: moves_list,
        create: function () {
            $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                var info = '<span class="pull-right">';

                if (item['Natural'] !== "")
                    info += ' N';

                if (item['EggMove'] !== "")
                    info += ' <img src="img/ico_egg.png" height="12"/>';

                if (item['TechnicalMachineId'] !== "")
                    info += ' TM';

                if (item['LevelLearned'] !== "")
                    info += ' lvl' + item["LevelLearned"];

                info += '</span>';

                return $('<li>')
                    .append('<a>' + item.label + info + '</a>')
                    .appendTo(ul);
            };
        }
    });
</script>