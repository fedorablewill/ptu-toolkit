<?php

$TYPE_LIST = array("Bug","Dragon","Ice","Fighting","Fire","Flying","Grass","Ghost","Ground","Electric","Normal","Poison","Psychic","Rock","Water","Dark","Steel");

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

if ($character->getType() === "POKEMON") {
    $pokedex_entry = DataPokedexEntryQuery::create()
        ->filterByPokedexNo($character->getPokedexNo())
        ->filterByPokedexId($character->getPokedexId())
        ->findOne();

    if ($pokedex_entry != null)
        $pokedex_data = json_decode(stream_get_contents($pokedex_entry->getData()), true);
}

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

            <input type="hidden" id="char-id" value="" />

            <div class="modal-body form-char">
                <small><i>Feature is work in progress</i></small>

                <h4>Basic Info</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="char-name">Name</label>
                    <input class="form-control" type="text" id="char-name" data-field="name" value="<?php echo $character->getName()?>" required />
                </div>
                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="char-dex">Pokédex ID</label>
                    <input class="form-control" type="text" id="char-dex" data-field="pokedex" value="<?php echo $character->getPokedexNo()?>" required />
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="char-type1">Type 1</label>
                            <select class="form-control" id="char-type1" data-field="type1" <?php
                            if ($character->getType() == "POKEMON") echo "required"; ?>><option></option><?php
                                echo $type_list1 ?></select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="char-type2">Type 2</label>
                            <select class="form-control" id="char-type2" data-populate="type" data-field="type2"><option></option><?php
                                echo $type_list2 ?></select>
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="char-level">Level</label>
                            <input class="form-control" type="number" id="char-level" data-field="level" value="<?php echo $character->getLevel()?>"  required />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="char-exp">EXP</label>
                            <input class="form-control" type="number" id="char-exp" data-field="EXP" value="<?php echo $character->getExp()?>"  />
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="char-gender">Gender</label>
                            <select class="form-control" id="char-gender" data-field="sex" value="<?php echo $character->getSex()?>"  required>
                                <option>Genderless</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <?php if ($character->getType() == "POKEMON"): ?>
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-nature">Nature</label>
                                <select class="form-control" id="char-nature" data-field="nature" data-populate="nature" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($character->getType() == "POKEMON"): ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="char-discover">Discovered at</label>
                    <input class="form-control" type="text" id="char-discover" data-field="discovery" />
                    <p class="help-block">Where was the Pokémon found</p>
                </div>
                <?php endif; ?>
                <div class="form-group label-floating">
                    <label class="control-label" for="char-item">Held Item</label>
                    <input class="form-control" type="text" id="char-item" data-field="held-item" />
                </div>

                <hr/>

                <h4>Health <small class="text-warning" id="warn-health"></small></h4>

                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="char-health">Current Health</label>
                        <input class="form-control" type="number" id="char-health" data-field="health" />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group label-floating">
                        <label class="control-label" for="char-injure">Injuries</label>
                        <input class="form-control" type="number" id="char-injure" data-field="injuries" value="0" />
                    </div>
                </div>

                <hr/>

                <h4>Stats <small class="text-warning" id="warn-stats"></small></h4>

                <div id="char-stats">
                    <span class="char-stat-total" id="char-hp-total"><?php
                        echo $character->getBaseHp() + $character->getLvlUpHp() + $character->getAddHp(); ?></span><label>HP (Stat)</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-hp">Base</label>
                                <input class="form-control" type="number" id="char-base-hp" data-field="base-hp" value="<?php echo $character->getBaseHp() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-hp">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-hp" data-field="lvl-up-hp" value="<?php echo $character->getLvlUpHp() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-hp">Add</label>
                                <input class="form-control" type="number" id="char-add-hp" data-field="add-hp" value="<?php echo $character->getAddHp() ?>" required />
                            </div>
                        </div>
                    </div>
                    <span class="char-stat-total" id="char-atk-total"><?php
                        echo $character->getBaseAtk() + $character->getLvlUpAtk() + $character->getAddAtk(); ?></span><label>Attack</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-atk">Base</label>
                                <input class="form-control" type="number" id="char-base-atk" data-field="base-atk" value="<?php echo $character->getBaseAtk() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-atk">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-atk" data-field="lvl-up-atk" value="<?php echo $character->getLvlUpAtk() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-atk">Add</label>
                                <input class="form-control" type="number" id="char-add-atk" data-field="add-atk" value="<?php echo $character->getAddAtk() ?>" required />
                            </div>
                        </div>
                    </div>
                    <span class="char-stat-total" id="char-def-total"><?php
                        echo $character->getBaseDef() + $character->getLvlUpDef() + $character->getAddDef(); ?></span><label>Defense</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-def">Base</label>
                                <input class="form-control" type="number" id="char-base-def" data-field="base-def" value="<?php echo $character->getBaseDef() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-def">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-def" data-field="lvl-up-def" value="<?php echo $character->getLvlUpDef() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-def">Add</label>
                                <input class="form-control" type="number" id="char-add-def" data-field="add-def" value="<?php echo $character->getAddDef() ?>" required />
                            </div>
                        </div>
                    </div>
                    <span class="char-stat-total" id="char-spatk-total"><?php
                        echo $character->getBaseSatk() + $character->getLvlUpSatk() + $character->getAddSatk(); ?></span><label>Special Attack</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-spatk">Base</label>
                                <input class="form-control" type="number" id="char-base-spatk" data-field="base-spatk" value="<?php echo $character->getBaseSatk() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-spatk">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-spatk" data-field="lvl-up-spatk" value="<?php echo $character->getLvlUpSatk() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-spatk">Add</label>
                                <input class="form-control" type="number" id="char-add-spatk" data-field="add-spatk" value="<?php echo $character->getAddSatk() ?>" required />
                            </div>
                        </div>
                    </div>
                    <span class="char-stat-total" id="char-spdef-total"><?php
                        echo $character->getBaseSdef() + $character->getLvlUpSdef() + $character->getAddSdef(); ?></span><label>Special Defense</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-spdef">Base</label>
                                <input class="form-control" type="number" id="char-base-spdef" data-field="base-spdef" value="<?php echo $character->getBaseSdef() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-spdef">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-spdef" data-field="lvl-up-spdef" value="<?php echo $character->getLvlUpSdef() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-spdef">Add</label>
                                <input class="form-control" type="number" id="char-add-spdef" data-field="add-spdef" value="<?php echo $character->getAddSdef() ?>" required />
                            </div>
                        </div>
                    </div>
                    <span class="char-stat-total" id="char-speed-total"><?php
                        echo $character->getBaseSpd() + $character->getLvlUpSpd() + $character->getAddSpd(); ?></span><label>Speed</label>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-base-speed">Base</label>
                                <input class="form-control" type="number" id="char-base-speed" data-field="base-speed" value="<?php echo $character->getBaseSpd() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-lvl-up-speed">Lvl-Up</label>
                                <input class="form-control" type="number" id="char-lvl-up-speed" data-field="lvl-up-speed" value="<?php echo $character->getLvlUpSpd() ?>" required />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group label-floating">
                                <label class="control-label" for="char-add-speed">Add</label>
                                <input class="form-control" type="number" id="char-add-speed" data-field="add-speed" value="<?php echo $character->getAddSpd() ?>" required />
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>

                <h4>Moves & Abilities</h4>

                <!-- TODO: make moves add/remove -->
                <label for="char-moves">Moves</label>
                <div id="char-moves">
                    <?php if ($moves->count() > 0) : ?>
                    <?php foreach ($moves as $move) : ?>
                    <div class="input-group">
                        <input class="form-control" title="Move" value="<?php echo $move->getMoveName() ?>" data-value="<?php echo $move->getMoveId() ?>" />
                        <span class="input-group-addon input-group-action">
                            <button class="btn btn-simple btn-danger btn-xs" onclick="removeMove($(this))">
                                <i class="material-icons">delete</i>
                            </button>
                        </span>
                    </div>
                    <?php endforeach; else : ?>
                    <div class="input-group">
                        <input class="form-control" title="Move" />
                        <span class="input-group-addon input-group-action">
                            <button class="btn btn-simple btn-danger btn-xs" onclick="removeMove($(this))">
                                <i class="material-icons">delete</i>
                            </button>
                        </span>
                    </div>
                    <?php endif; ?>
                    <button class="btn btn-simple btn-success" onclick="addMove($(this))">
                        <i class="material-icons">add</i> Add Move
                    </button>
                </div>
                <label for="char-abilities">Abilities</label>
                <div id="char-abilities">
                    <select class="form-control" title="Ability 1" data-required="POKEMON" data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 2" data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 3" data-populate="ability"><option></option></select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-char">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- TODO: move all CSS to common file -->
<style>
    .input-group-action {
        padding: 0 !important;
    }

    .char-stat-total {
        width: 35px;
        display: inline-block;
        text-align: center;
        font-weight: 400;
    }
</style>

<script>
    $("#char-dex").autocomplete({
        source: mon_list
    }).focus(function() {
        var val = $(this).val() === "" ? " " : $(this).val();
        $(this).autocomplete('search', val);
    });

    var moves_list = [
        <?php foreach ($MOVES_LIST as $move) :?>{
            "value": "<?php echo $move["Name"] ?> ",
            "MoveId": "<?php echo $move["MoveId"] ?>",
            "LevelLearned": "<?php echo $move["LevelLearned"] ?>",
            "TechnicalMachineId": "<?php echo $move["TechnicalMachineId"] ?>",
            "Natural": "<?php echo $move["Natural"] ?>",
            "EggMove": "<?php echo $move["EggMove"] ?>"
        },<?php endforeach; ?>{"label": "test", "value": "ehh", "LevelLearned": "1"}
    ];

    $("#char-moves").find("input").each(function () {
        initMoveInput($(this));
    });

    function initMoveInput(elem) {
        elem.autocomplete({
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
            },
            select: function (event, ui) {
                $(this).attr("data-value", ui.item['MoveId']);
            }
        }).focus(function() {
            var val = $(this).val() === "" ? " " : $(this).val();
            $(this).autocomplete('search', val);
        });

        return elem;
    }

    function addMove(elem) {
        elem.before($('<div class="input-group">').append(
            initMoveInput($('<input class="form-control" title="Move" />')),
            '                        <span class="input-group-addon input-group-action">\n' +
            '                            <button class="btn btn-simple btn-danger btn-xs" onclick="removeMove($(this))">\n' +
            '                                <i class="material-icons">delete</i>\n' +
            '                            </button>\n' +
            '                        </span>\n'));
    }

    function removeMove(elem) {
        elem.parent().parent().remove();
    }
</script>