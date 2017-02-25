/**
 * Scripts for GM Client
 * @author Will Stephenson
 */

var gm_data = {};
var battle = {};

/**
 * Receives commands/messages
 */
function onUpdate() {

    // Check for incoming requests
    receiveMessages("host:" + host_id, function (data) {
        $.each(data, function (message) {
            /*
                Snackbar Alert Received
             */
            if (this.type == "alert"){
                doToast(message["content"]);
            }
            /*
                Send Pokemon Data
             */
            else if (this.type == "pokemon_get") {
                var msg = {
                    "type": "pokemon",
                    "pokemon": gm_data["pokemon"][this.pokemon_id]
                };
                sendMessage(this.from, JSON.stringify(msg));
            }
            /*
                Send Pokemon List
             */
            else if (this.type == "pokemon_list") {
                var msg1 = {
                    "type": "pokemon_list",
                    "pokemon": gm_data["pokemon"]
                };
                sendMessage(this.from, JSON.stringify(msg1));
            }
            /*
                Add Pokemon to Battle
             */
            else if (this.type == "battle_add") {

                var pokemon_id = this.pokemon, client_id = this.from;

                $.each(battle, function (id, json) {
                    sendMessage(json["client_id"], JSON.stringify({
                        "type": "battle_added",
                        "pokemon_id": pokemon_id,
                        "pokemon_name": gm_data["pokemon"][pokemon_id]["name"]
                    }));

                    sendMessage(client_id, JSON.stringify({
                        "type": "battle_added",
                        "pokemon_id": id,
                        "pokemon_name": gm_data["pokemon"][id]["name"]
                    }));
                });

                battle[this.pokemon] = {
                    "client_id": this.from,
                    "stage_atk": this.stage_atk,
                    "stage_def": this.stage_def,
                    "stage_spatk": this.stage_spatk,
                    "stage_spdef": this.stage_spdef,
                    "stage_speed": this.stage_speed,
                    "stage_acc": this.stage_acc,
                    "stage_eva": this.stage_eva
                };

                sendMessage(client_id, JSON.stringify({
                    "type": "battle_added",
                    "pokemon_id": pokemon_id,
                    "pokemon_name": gm_data["pokemon"][pokemon_id]["name"]
                }));

                doToast(gm_data["pokemon"][this.pokemon]["name"] + " Appears!");

                renderInit();
            }
            /*
                Update Field Received
             */
            else if (this.type == "pokemon_update") {
                gm_data["pokemon"][this.pokemon][this.field] = this.value;
            }
            /*
                Update Combat Stage Received
             */
            else if (this.type == "pokemon_setcs") {
                battle[this.pokemon][this.field] = this.value;
            }
            /*
                Attack Received
             */
            else if (this.type == "battle_move") {
                performMove(this.move, this.target, this.dealer);
            }
        });
    });

    // Recursion
    setTimeout(onUpdate, 500);
}

/**
 * Generates the Pokemon battle, primarilly the health visual
 */
function renderInit() {
    var html = '';

    $.each(battle, function (id, data) {
        var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;
        var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);

        if (w > 100)
            console.log("Warning: Pokemon with ID " + id + " has hit points above its max: " +
                gm_data["pokemon"][id]['health'] + "/" + max_hp);

        html += '<div class="col-md-6 col-md-offset-3 pokemon" data-name="'+id+'">' +
            '<h2 class="name">'+gm_data["pokemon"][id]["name"]+'</h2>' +
            '<div class="progress" data-hp="'+gm_data["pokemon"][id]["hp"]+'" data-max-hp="'+gm_data["pokemon"][id]["max_hp"]+'">' +
            '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'+w+'" aria-valuemin="0" aria-valuemax="100" style="width: '+w+'%;"></div>' +
            '</div>' +
            '</div>';
    });

    $("#view-holder").html(html);
}

/**
 * Used when a GM ID is submitted
 */
function registerNewGM() {
    // Store selected GM ID
    host_id = $("#battle-id").val();

    // Update display
    $("#display-gmid").html(host_id);
    $(".content-init").css("display", "none");
    onUpdate();

    //TODO: import settings/pokemon from file
    $.getJSON("pokemon/box.json", function (json) {
        gm_data = json;
    });
}

/**
 * Handle a move request and dish out effects
 * @param moveName The name of the move used
 * @param target_id The Pokemon id of the target
 * @param dealer_id The Pokemon id of the user
 */
function performMove(moveName, target_id, dealer_id) {
    doToast(gm_data["pokemon"][dealer_id]["name"] + " used " + moveName + "!");

    $.getJSON("/api/moves/?name="+moveName, function (move) {
        var acRoll = roll(1, 20, 1);
        var crit = 20;

        if (move.hasOwnProperty('AC') && acRoll < parseInt(move["AC"])) {
            doToast("It missed!");
            return;
        }

        if (move["Class"] == "Physical" || move["Class"] == "Special") {
            var db = parseInt(move["DB"]);

            var types = gm_data["pokemon"][dealer_id]["type"].split(" / ");

            if (types[0] == move["Type"] || (types.length > 1 && types[1] == move["type"]))
                db += 2;

            if (db > 28) db = 28;

            var rolledDmg = rollDamageBase(db, acRoll >= crit ? 2 : 1);
            var damage = 0;

            if (acRoll >= crit)
                doToast("Critical hit!");

            if (move["Class"] == "Physical") {
                damage = rolledDmg +
                    gm_data["pokemon"][dealer_id]["atk"] * getStageMultiplier(battle[dealer_id]["stage_atk"]);
                if (target_id != "other")
                    damage -= gm_data["pokemon"][target_id]["def"] * getStageMultiplier(battle[target_id]["stage_def"]);
            }
            else if (move["Class"] == "Special") {
                damage = rolledDmg * (acRoll >= crit ? 2 : 1) +
                    gm_data["pokemon"][dealer_id]["spatk"] * getStageMultiplier(battle[dealer_id]["stage_spatk"]);
                if (target_id != "other")
                    damage -= gm_data["pokemon"][target_id]["spdef"] * getStageMultiplier(battle[target_id]["stage_spdef"]);
            }

            if (target_id == "other") {
                doToast("OUTGOING DAMAGE = " + damage);
            }
            else {
                //TODO: add type-effects to API
                $.getJSON("/data/type-effects.json", function (json) {
                    var target_types = gm_data["pokemon"][target_id]["type"].split(" / ");

                    var effect1 = json[move["Type"].toLowerCase()][target_types[0].toLowerCase()];
                    var effect2 = 1;

                    if (target_types.length > 1)
                        effect2 = json[move["Type"].toLowerCase()][target_types[1].toLowerCase()];

                    damage = damage * effect1 * effect2;

                    if (effect1 * effect2 == 0)
                        doToast("No effect!");
                    else if (effect1 * effect2 >= 2)
                        doToast("It's super effective!");
                    else if (effect1 * effect2 < 1)
                        doToast("It's not very effective.");

                    // Subtract health
                    gm_data["pokemon"][target_id]["health"] -= damage;

                    if (gm_data["pokemon"][target_id]["health"] <= 0) {
                        doToast(gm_data["pokemon"][target_id]["name"] + " fainted!");
                        gm_data["pokemon"][target_id]["health"] = 0;
                    }

                    // Update health bar
                    var max_hp = gm_data["pokemon"][target_id]['level'] + gm_data["pokemon"][target_id]['hp'] * 3 + 10;
                    var w = Math.floor((gm_data["pokemon"][target_id]['health'] / max_hp) * 100);

                    $("[data-name='"+target_id+"']").find(".progress-bar").css("width", w + "%");
                    //TODO: send update to target
                });
            }
        }
    });
}