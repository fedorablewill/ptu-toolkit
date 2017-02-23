var gm_data = {};
var battle = {};

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
                    "stage_speed": this.stage_speed
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

function renderInit() {
    var html = '';

    $.each(battle, function (id, data) {
        var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;
        var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);

        html += '<div class="col-md-6 col-md-offset-3 pokemon" data-name="'+id+'">' +
            '<h2 class="name">'+gm_data["pokemon"][id]["name"]+'</h2>' +
            '<div class="progress" data-hp="'+gm_data["pokemon"][id]["hp"]+'" data-max-hp="'+gm_data["pokemon"][id]["max_hp"]+'">' +
            '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'+w+'" aria-valuemin="0" aria-valuemax="100" style="width: '+w+'%;"></div>' +
            '</div>' +
            '</div>';
    });

    $("#view-holder").html(html);
}

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

                    damage = damage * json[move["Type"].toLowerCase()][target_types[0].toLowerCase()];

                    if (target_types.length > 1)
                        damage = damage * json[move["Type"].toLowerCase()][target_types[1].toLowerCase()];

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

function calcDamage(dmg, moveType, isSpecial, pokemon) {
    moveType = moveType.toLocaleLowerCase();

    var def, defStage;

    if (isSpecial) {
        def = parseInt(mon.attr("data-spdef"));
        defStage = parseFloat(mon.attr("data-spdef-stage"));
    }
    else {
        def = parseInt(mon.attr("data-def"));
        defStage = parseFloat(mon.attr("data-def-stage"));
    }

    var damage = Math.floor(dmg - (def * defStage));

    var monType1 = mon.attr("data-type-1");
    var monType2 = mon.attr("data-type-2");

    var effect1 = 1, effect2 = 1;

    $.getJSON("data/type-effects.json", function(json) {
        effect1 = json[moveType][monType1];

        if (monType2 != null)
            effect2 = json[moveType][monType2];

        damage = damage * effect1 * effect2;

        if (damage < 1)
            damage = 1;

        hp = hp - damage;

        if (hp <= 0) {
            window.alert("The pokemon fainted!");
        }

        progress.attr("data-hp", hp);

        sendUpdate("hp", hp);

        $(".progress-bar").css("width", Math.floor((hp / maxHp) * 100) + "%");
    });
}