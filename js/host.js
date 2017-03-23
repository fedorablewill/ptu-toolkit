/**
 * Scripts for GM Client
 * @author Will Stephenson
 */

var gm_data = {};
var battle = {};
var currentView = 0;

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

                renderBattler();
            }
            /*
                Update Field Received
             */
            else if (this.type == "pokemon_update") {
                gm_data["pokemon"][this.pokemon][this.field] = this.value;

                if (this.field == "health") {
                    var max_hp = gm_data["pokemon"][this.pokemon]['level'] + gm_data["pokemon"][this.pokemon]['hp'] * 3 + 10;
                    var w = Math.floor((gm_data["pokemon"][this.pokemon]['health'] / max_hp) * 100);

                    $("[data-name='"+this.pokemon+"']").find(".progress-bar").css("width", w + "%");

                    sendMessage(battle[this.pokemon]["client_id"], JSON.stringify({
                        "type": "health",
                        "value": this.value
                    }));
                }
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
            /*
                Manual Damage Received
             */
            else if (this.type == "battle_damage") {
                damagePokemon(this.target, this.moveType, this.isSpecial, this.damage);
            }
            /*
                Request for Status
             */
            else if (this.type == "status") {
                sendMessage(this.sender, JSON.stringify({
                    "type": "gm_status",
                    "value": "online"
                }));
            }
        });
    });

    // Recursion
    setTimeout(onUpdate, 500);
}

/**
 * Generates the Pokemon battle, primarilly the health visual
 */
function renderBattler() {
    if (currentView == 0) {
        var html = '';

        $.each(battle, function (id, data) {
            var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;
            var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);

            if (w > 100)
                console.log("Warning: Pokemon with ID " + id + " has hit points above its max: " +
                    gm_data["pokemon"][id]['health'] + "/" + max_hp);

            html += '<div class="col-md-6 col-md-offset-3 pokemon" data-name="' + id + '">' +
                '<h2 class="name">' + gm_data["pokemon"][id]["name"] + '</h2>' +
                '<div class="progress" data-hp="' + gm_data["pokemon"][id]["hp"] + '" data-max-hp="' + gm_data["pokemon"][id]["max_hp"] + '">' +
                '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="' + w + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + w + '%;"></div>' +
                '</div>' +
                '</div>';
        });

        html += '<br/><button class="btn btn-danger btn-raised" onclick="endBattle()">End Battle</button>';

        $("#view-holder").html(html);
    }
}

/**
 * Render list of editable Pokemon for Pokemon tab
 */
function renderPokemonList() {
    var html = '';

    $.each(gm_data['pokemon'], function (k, v) {
        html += '<div class="edit-pokemon col-sm-4 col-md-3">'+
                '<img src="img/pokemon/'+v["dex"]+'.gif"> '+v["name"]+
                '<div class="btn-group-vertical pull-right">'+
                    '<button onclick="onClickEditPokemon(\''+k+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                    '<button onclick="onClickDeletePokemon(\''+k+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                '</div>'+
            '</div>';
    });

    $("#view-holder").find(".list-pokemon").html(html);

    onRenderPokemonManage();
}

function changeGMView(view) {
    currentView = view;

    if (view == 0) {
        renderBattler();
    }
    else if (view == 1) {
        $("#view-holder").html($("#body-pokemon").html());
        renderPokemonList();
    }
    else if (view == 2) {
        $("#view-holder").html($("#body-settings").html());
    }
}

/**
 * Used when a GM ID is submitted
 */
function GMID() {
    // Store selected GM ID
    host_id = $("#battle-id").val();

    // Update display
    $("#display-gmid").html(host_id);
    $(".content-init").css("display", "none");
    $(".content-select").css("display", "inline");
}

function newGM() {
    // Update display
    $(".content-select").css("display", "none");
    $(".footer-gm").removeClass("hidden");
    onUpdate();

    //New blank gm_data object
    gm_data = {characters:{},pokemon:{},settings:{}};
}

function selectGM() {
    // Update display
    var ulAnchorElem = document.getElementById('uploadAnchor');
    ulAnchorElem.click();
}

$("#expmon-mon").change(function(){
  var id = $('#expmon-mon').find(":selected").val();
  $('#expmon-JSON').val(JSONExport(gm_data["pokemon"][id]));
});

function fetchExistingPokemon(){
  $.each(gm_data["pokemon"],function (k,v){
  	document.getElementById("expmon-mon").innerHTML += "<option value = '"+k+"'>" + v["name"] + "</option>";
  });
}

$("#uploadAnchor").change(function() {
    {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('The File APIs are not fully supported in this browser.');
            return;
        }

        input = document.getElementById('uploadAnchor');
        if (!input) {
            alert("Um, couldn't find the fileinput element.");
        }
        else if (!input.files) {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        }
        else if (!input.files[0]) {
            alert("Please select a file before clicking 'Load'");
        }
        else {
            file = input.files[0];
            fr = new FileReader();
            fr.onload = (function (theFile) {
                return function (e) {
                    //console.log('e readAsText = ', e);
                    //console.log('e readAsText target = ', e.target);
                    try {
                        json = JSON.parse(e.target.result);
                        $(".content-select").css("display", "none");
                        $(".footer-gm").removeClass("hidden");
                        onUpdate();
                        gm_data = json;
                    } catch (ex) {
                        alert('ex when trying to parse json = ' + ex);
                    }
                };
            })(file);
            fr.readAsText(file);
        }
    }
});

function saveGM() {
    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(gm_data));
    var dlAnchorElem = document.getElementById('downloadAnchor');
    dlAnchorElem.setAttribute("href",     dataStr     );
    dlAnchorElem.setAttribute("download", "GMData.json");
    dlAnchorElem.click();
}

function endBattle() {
    if (window.confirm("Are you sure you want to reset the battle?")) {
        battle = {};
        renderBattler();
    }
}

/**
 * Handle a move request and dish out effects
 * @param moveName The name of the move used
 * @param target_id The Pokemon id of the target
 * @param dealer_id The Pokemon id of the user
 */
function performMove(moveName, target_id, dealer_id) {
    doToast(gm_data["pokemon"][dealer_id]["name"] + " used " + moveName + "!");

    $.getJSON("/api/v1/moves/"+moveName, function (move) {
        var acRoll = roll(1, 20, 1) + battle[dealer_id]["stage_acc"];
        var crit = 20, evade = 0;

        if (target_id != "other") {
            //TODO: get evade
        }

        if (move.hasOwnProperty('AC') && acRoll < parseInt(move["AC"]) + evade) {
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
                handleTrigger(trigger,dealer_id,target_id,"N/A");
            }
            else {
                if (move.hasOwnProperty("Triggers")){
                  damagePokemon(target_id, move["Type"].toLowerCase(), move["Class"] == "Special", damage, triggers, moveName);
                } else {
                  damagePokemon(target_id, move["Type"].toLowerCase(), move["Class"] == "Special", damage, [], moveName);
                }
            }
        }
    });
}

/**
 * Inflict incoming damage onto a specified Pokemon
 * @param target_id The ID of the Pokemon taking damage
 * @param moveType The move type
 * @param moveIsSpecial True when special, false when physical
 * @param damage The amount of damage
 */
function damagePokemon(target_id, moveType, moveIsSpecial, damage, triggers, moveName) {
    if (moveIsSpecial)
        damage -= gm_data["pokemon"][target_id]["spdef"] * getStageMultiplier(battle[target_id]["stage_spdef"]);
    else
        damage -= gm_data["pokemon"][target_id]["def"] * getStageMultiplier(battle[target_id]["stage_def"]);

    $.getJSON("/api/v1/types", function (json) {
        var target_types = gm_data["pokemon"][target_id]["type"].split(" / ");

        var effect1 = json[moveType.toLowerCase()][target_types[0].toLowerCase()];
        var effect2 = 1;

        if (target_types.length > 1)
            effect2 = json[moveType.toLowerCase()][target_types[1].toLowerCase()];

        damage = damage * effect1 * effect2;

        if (effect1 * effect2 == 0)
            doToast("No effect!");
        else if (effect1 * effect2 >= 2)
            doToast("It's super effective!");
        else if (effect1 * effect2 < 1)
            doToast("It's not very effective.");

        // Make sure it doesn't accidentally heal the target
        if (damage < 0) {
            damage = 1;
        }

        // Calculating max_hp
        var max_hp = gm_data["pokemon"][target_id]['level'] + gm_data["pokemon"][target_id]['hp'] * 3 + 10;

        // Checking for injuries
        if (damage >= max_hp/2){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        if (gm_data["pokemon"][target_id]["health"] > max_hp/2 && gm_data["pokemon"][target_id]["health"] - damage <= max_hp/2){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        if (gm_data["pokemon"][target_id]["health"] > 0 && gm_data["pokemon"][target_id]["health"] - damage <= 0){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        if (gm_data["pokemon"][target_id]["health"] > -max_hp/2 && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp/2){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        if (gm_data["pokemon"][target_id]["health"] > -max_hp && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        if (gm_data["pokemon"][target_id]["health"] > -max_hp*3/2 && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp*3/2){
          gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
        }
        //No need to go to other thresholds, as you'd be dead at that point

        // Subtract health
        gm_data["pokemon"][target_id]["health"] -= damage;

        //Limiting health by number of injuries if appropriate
        if ((10-gm_data["pokemon"][target_id]["injuries"])/10 * max_hp < gm_data["pokemon"][target_id]["health"]){
          gm_data["pokemon"][target_id]["health"] = (10-gm_data["pokemon"][target_id]["injuries"])/10;
        }

        if (gm_data["pokemon"][target_id]["health"] <= 0) {
            doToast(gm_data["pokemon"][target_id]["name"] + " fainted!");
            gm_data["pokemon"][target_id]["health"] = 0;
        }

        // Update health bar
        var w = Math.floor((gm_data["pokemon"][target_id]['health'] / max_hp) * 100);

        $("[data-name='"+target_id+"']").find(".progress-bar").css("width", w + "%");

        // Update Player client
        sendMessage(battle[target_id]["client_id"], JSON.stringify({
            "type": "health",
            "value": gm_data["pokemon"][target_id]['health']
        }));

        //Checking Triggers
        $.each(triggers,function(trigger){
          if (trigger.hasOwnProperty("prereq")){

          } else if (trigger.hasOwnProperty("type")){
            handleTrigger(trigger,dealer_id,target_id,damage_dealt, moveName);
          }
        });
    });
}

function handleTrigger(trigger,dealer_id,target_id,damage_dealt, moveName){
  //Making a variable for storing important ids
  var id;
  if (trigger.hasOwnProperty("target")){
    if (trigger.target=="SELF"){
      id = dealer_id;
    } else {
      id = target_id;
    }
  }

  //Handling trigger by type
  if (trigger.type=="action-needed"){
    doToast(trigger.text)
  }
  else if (trigger.type=="CS"){
    //Raising/lowering stats
    $.each(trigger.stat, function(stat){
      battle[id]["stage_"+stat]+=trigger.value;
    });
  }
  else if (trigger.type=="heal"){
    //Seeing what type of healing is needed
    var arr = trigger.value.split(" ");

    // Getting max HP
    var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;

    //Getting multiplier
    var mult
    if (arr[0]=="1/2"){
      mult = 0.5;
    } else {
      mult = parseInt(arr[0],10);
    }

    //Checking type of healing and setting HP
    if (arr[1]=="HP"){
      gm_data["pokemon"][id]['health'] = Math.min(max_hp*(10-gm_data["pokemon"][id]['injuries'])/10,gm_data["pokemon"][id]['health']+mult*max_hp)
    } else if (arr[1]=="Damage"){
      gm_data["pokemon"][id]['health'] = Math.min(max_hp*(10-gm_data["pokemon"][id]['injuries'])/10,gm_data["pokemon"][id]['health']+mult*damage_dealt)
    }

    //Setting Health bar
    var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);
    $("[data-name='"+id+"']").find(".progress-bar").css("width", w + "%");
  }
  else if (trigger.type=="vortex"){
    //Figure out vortex
  }
  else if (trigger.type=="push"){
    //Wait until map is implemented
  }
  else if (trigger.type=="switch"){
    //Not really a mechanism for this at present
  }
  else if (trigger.type=="status"){
    //Need statuses to exist first
  }
  else if (trigger.type=="damage"){
    // Setting up for changing HP
    var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;

    //Getting damage to do
    var dmg;
    if (typeof trigger.value == "number"){
      dmg = trigger.value;
    }
    else if (trigger.value=="User Level"){
      dmg = gm_data["pokemon"][dealer_id]['level'];
    }
    else {
      var arr = trigger.value.split(" ")[0].split("/");
      dmg = max_hp*parseInt(arr[0],10)/parseInt(arr[1],10);
    }
    // Getting max HP
    var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;

    //Checking for threshhold injuries; Massive Damage doesn't apply for flat damage sources
    if (gm_data["pokemon"][target_id]["health"] > max_hp/2 && gm_data["pokemon"][target_id]["health"] - damage <= max_hp/2){
      gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
    }
    if (gm_data["pokemon"][target_id]["health"] > 0 && gm_data["pokemon"][target_id]["health"] - damage <= 0){
      gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
    }
    if (gm_data["pokemon"][target_id]["health"] > -max_hp/2 && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp/2){
      gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
    }
    if (gm_data["pokemon"][target_id]["health"] > -max_hp && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp){
      gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
    }
    if (gm_data["pokemon"][target_id]["health"] > -max_hp*3/2 && gm_data["pokemon"][target_id]["health"] - damage <= -max_hp*3/2){
      gm_data["pokemon"][target_id]["injuries"] = parseInt(gm_data["pokemon"][target_id]["injuries"],10) + 1;
    }
    //No need to go to other thresholds, as you'd be dead at that point

    //Lowering health
    gm_data["pokemon"][id]['health'] = Math.min(gm_data["pokemon"][id]['health'] - dmg,max_hp*(10-gm_data["pokemon"][id]['injuries'])/10);

    //Setting Health bar
    var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);
    $("[data-name='"+id+"']").find(".progress-bar").css("width", w + "%");
  }
  else if (trigger.type=="protect"){
    //Need ability to interrupt to implement
  }
  else if (trigger.type=="execute"){
    var r = roll(1,100,1);
    if (r <= 30+gm_data["pokemon"][dealer_id]['level']-gm_data["pokemon"][target_id]['level']){
      doToast(gm_data["pokemon"][target_id]["name"] + " fainted!");
      gm_data["pokemon"][target_id]["health"] = 0;
    } else {
      doToast(moveName+ " missed "+gm_data["pokemon"][target_id]["name"]+"!");
    }
  }
}

/**
 * Initialize Add/Edit Pokemon
 */
$(function () {

    /* Add listeners */

    $(".form-addmon input").change(function () {
        updatePokemonEditor();
    });

    $("#addmon-dex").change(onAddmonDexChange);
});

function onAddmonDexChange() {
    if ($(this).val() != "") {
        $("#addmon-dex").parent().removeClass("has-error");
        $.getJSON("api/v1/pokemon/" + $(this).val(), function (entry) {
            // Fields to change
            var field_type1 = $("#addmon-type1");
            var field_type2 = $("#addmon-type2");

            var field_hp = $("#addmon-hp");
            var field_atk = $("#addmon-atk");
            var field_def = $("#addmon-def");
            var field_spatk = $("#addmon-spatk");
            var field_spdef = $("#addmon-spdef");
            var field_spd = $("#addmon-speed");

            // Change type 1
            field_type1.val(entry["Types"][0]);
            field_type1.parent().removeClass("is-empty");

            // Change type 2
            if (entry["Types"].length > 1) {
                field_type2.val(entry["Types"][1]);
                field_type2.parent().removeClass("is-empty");
            }
            else {
                field_type2.val("");
                field_type2.parent().addClass("is-empty");
            }

            // Change base stats
            if (field_hp.attr("data-base") != null)
                field_hp.val(parseInt(field_hp.val()) - parseInt(field_hp.attr("data-base")));

            if (field_hp.val() != "")
                field_hp.val(parseInt(field_hp.val()) + entry["BaseStats"]["HP"]);
            else
                field_hp.val(entry["BaseStats"]["HP"]);

            field_hp.attr("data-base", entry["BaseStats"]["HP"]);
            field_hp.parent().removeClass("is-empty");

            if (field_def.attr("data-base") != null)
                field_def.val(parseInt(field_def.val()) - parseInt(field_def.attr("data-base")));

            if (field_def.val() != "")
                field_def.val(parseInt(field_def.val()) + entry["BaseStats"]["Defense"]);
            else
                field_def.val(entry["BaseStats"]["Defense"]);

            field_def.attr("data-base", entry["BaseStats"]["Defense"]);
            field_def.parent().removeClass("is-empty");

            if (field_atk.attr("data-base") != null)
                field_atk.val(parseInt(field_atk.val()) - parseInt(field_atk.attr("data-base")));

            if (field_atk.val() != "")
                field_atk.val(parseInt(field_atk.val()) + entry["BaseStats"]["Attack"]);
            else
                field_atk.val(entry["BaseStats"]["Attack"]);

            field_atk.attr("data-base", entry["BaseStats"]["Attack"]);
            field_atk.parent().removeClass("is-empty");

            if (field_spatk.attr("data-base") != null)
                field_spatk.val(parseInt(field_spatk.val()) - parseInt(field_spatk.attr("data-base")));

            if (field_spatk.val() != "")
                field_spatk.val(parseInt(field_spatk.val()) + entry["BaseStats"]["SpecialAttack"]);
            else
                field_spatk.val(entry["BaseStats"]["SpecialAttack"]);

            field_spatk.attr("data-base", entry["BaseStats"]["SpecialAttack"]);
            field_spatk.parent().removeClass("is-empty");

            if (field_spdef.attr("data-base") != null)
                field_spdef.val(parseInt(field_spdef.val()) - parseInt(field_spdef.attr("data-base")));

            if (field_spdef.val() != "")
                field_spdef.val(parseInt(field_spdef.val()) + entry["BaseStats"]["SpecialDefense"]);
            else
                field_spdef.val(entry["BaseStats"]["SpecialDefense"]);

            field_spdef.attr("data-base", entry["BaseStats"]["SpecialDefense"]);
            field_spdef.parent().removeClass("is-empty");

            if (field_spd.attr("data-base") != null)
                field_spd.val(parseInt(field_spd.val()) - parseInt(field_spd.attr("data-base")));

            if (field_spd.val() != "")
                field_spd.val(parseInt(field_spd.val()) + entry["BaseStats"]["Speed"]);
            else
                field_spd.val(entry["BaseStats"]["Speed"]);

            field_spd.attr("data-base", entry["BaseStats"]["Speed"]);
            field_spd.parent().removeClass("is-empty");

            updatePokemonEditor();

        });
    }
    else {
        $("#addmon-dex").val("").parent().addClass("has-error");
    }
}

function updatePokemonEditor() {
    var dex = $("#addmon-dex").val();

    if (dex != "")
        $.getJSON("api/v1/pokemon/" + dex, function (entry) {
            // Fields to edit/view
            var field_level = $("#addmon-level");
            var field_health = $("#addmon-health");
            var field_hp = $("#addmon-hp");
            var field_atk = $("#addmon-atk");
            var field_def = $("#addmon-def");
            var field_spatk = $("#addmon-spatk");
            var field_spdef = $("#addmon-spdef");
            var field_spd = $("#addmon-speed");

            /*
                Update max health
             */
            if (field_hp.val() != "" && field_level.val() != "") {
                max_hp = parseInt(field_level.val()) + ( parseInt(field_hp.val()) * 3 ) + 10;

                if (field_health.val() > max_hp)
                    $("#warn-health").html("Health is over maximum of " + max_hp);
                else
                    $("#warn-health").html("");
            }

            /*
                Check stat distribution
             */
            if (field_level.val() != "" && field_hp.val() != "" && field_atk.val() != "" && field_def.val() != "" &&
                    field_spatk.val() != "" && field_spdef.val() != "" && field_spd.val() != "") {

                var statTotal = parseInt(field_hp.val()) + parseInt(field_atk.val()) + parseInt(field_def.val()) +
                        parseInt(field_spatk.val()) + parseInt(field_spdef.val()) + parseInt(field_spd.val())
                    - entry["BaseStats"]["HP"] - entry["BaseStats"]["Attack"] - entry["BaseStats"]["Defense"]
                    - entry["BaseStats"]["SpecialDefense"] - entry["BaseStats"]["SpecialAttack"] - entry["BaseStats"]["Speed"];

                var statGoal = parseInt(field_level.val()) + 10;

                if (statGoal != statTotal)
                    $("#warn-stats").html("Stats points not rewarded properly. Rewarded " + statTotal + "/" + statGoal);
                /*
                    Check Base Relations Rule
                 */
                else if (entry["BaseStats"]["HP"] > entry["BaseStats"]["Attack"] && parseInt(field_hp.val()) <= parseInt(field_atk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP > ATK");
                else if(entry["BaseStats"]["HP"] < entry["BaseStats"]["Attack"] && parseInt(field_hp.val()) >= parseInt(field_atk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP < ATK");
                else if (entry["BaseStats"]["HP"] > entry["BaseStats"]["Defense"] && parseInt(field_hp.val()) <= parseInt(field_def.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP > DEF");
                else if (entry["BaseStats"]["HP"] < entry["BaseStats"]["Defense"] && parseInt(field_hp.val()) >= parseInt(field_def.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP < DEF");
                else if (entry["BaseStats"]["HP"] > entry["BaseStats"]["SpecialAttack"] && parseInt(field_hp.val()) <= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP > SPATK");
                else if (entry["BaseStats"]["HP"] < entry["BaseStats"]["SpecialAttack"] && parseInt(field_hp.val()) >= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP < SPATK");
                else if (entry["BaseStats"]["HP"] > entry["BaseStats"]["SpecialDefense"] && parseInt(field_hp.val()) <= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP > SPDEF");
                else if (entry["BaseStats"]["HP"] < entry["BaseStats"]["SpecialDefense"] && parseInt(field_hp.val()) >= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP < SPDEF");
                else if (entry["BaseStats"]["HP"] > entry["BaseStats"]["Speed"] && parseInt(field_hp.val()) <= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP > SPD");
                else if (entry["BaseStats"]["HP"] < entry["BaseStats"]["Speed"] && parseInt(field_hp.val()) >= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: HP < SPD");
                else if (entry["BaseStats"]["Attack"] < entry["BaseStats"]["Defense"] && parseInt(field_atk.val()) >= parseInt(field_def.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK < DEF");
                else if (entry["BaseStats"]["Attack"] > entry["BaseStats"]["Defense"] && parseInt(field_atk.val()) <= parseInt(field_def.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK > DEF");
                else if (entry["BaseStats"]["Attack"] < entry["BaseStats"]["SpecialAttack"] && parseInt(field_atk.val()) >= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK < SPATK");
                else if (entry["BaseStats"]["Attack"] > entry["BaseStats"]["SpecialAttack"] && parseInt(field_atk.val()) <= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK > SPATK");
                else if (entry["BaseStats"]["Attack"] < entry["BaseStats"]["SpecialDefense"] && parseInt(field_atk.val()) >= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK < SPDEF");
                else if (entry["BaseStats"]["Attack"] > entry["BaseStats"]["SpecialDefense"] && parseInt(field_atk.val()) <= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK > SPDEF");
                else if (entry["BaseStats"]["Attack"] < entry["BaseStats"]["Speed"] && parseInt(field_atk.val()) >= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK < SPD");
                else if (entry["BaseStats"]["Attack"] > entry["BaseStats"]["Speed"] && parseInt(field_atk.val()) <= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: ATK > SPD");
                else if (entry["BaseStats"]["Defense"] < entry["BaseStats"]["SpecialAttack"] && parseInt(field_def.val()) >= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF < SPATK");
                else if (entry["BaseStats"]["Defense"] > entry["BaseStats"]["SpecialAttack"] && parseInt(field_def.val()) <= parseInt(field_spatk.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF > SPATK");
                else if (entry["BaseStats"]["Defense"] < entry["BaseStats"]["SpecialDefense"] && parseInt(field_def.val()) >= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF < SPDEF");
                else if (entry["BaseStats"]["Defense"] > entry["BaseStats"]["SpecialDefense"] && parseInt(field_def.val()) <= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF > SPDEF");
                else if (entry["BaseStats"]["Defense"] < entry["BaseStats"]["Speed"] && parseInt(field_def.val()) >= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF < SPD");
                else if (entry["BaseStats"]["Defense"] > entry["BaseStats"]["Speed"] && parseInt(field_def.val()) <= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: DEF > SPD");
                else if (entry["BaseStats"]["SpecialAttack"] < entry["BaseStats"]["SpecialDefense"] && parseInt(field_spatk.val()) >= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPATK < SPDEF");
                else if (entry["BaseStats"]["SpecialAttack"] > entry["BaseStats"]["SpecialDefense"] && parseInt(field_spatk.val()) <= parseInt(field_spdef.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPATK > SPDEF");
                else if (entry["BaseStats"]["SpecialAttack"] < entry["BaseStats"]["Speed"] && parseInt(field_spatk.val()) >= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPATK < SPD");
                else if (entry["BaseStats"]["SpecialAttack"] > entry["BaseStats"]["Speed"] && parseInt(field_spatk.val()) <= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPATK > SPD");
                else if (entry["BaseStats"]["SpecialDefense"] < entry["BaseStats"]["Speed"] && parseInt(field_spdef.val()) >= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPDEF < SPD");
                else if (entry["BaseStats"]["SpecialDefense"] > entry["BaseStats"]["Speed"] && parseInt(field_spdef.val()) <= parseInt(field_spd.val()))
                    $("#warn-stats").html("Base Relations Rule violated: SPDEF > SPD");
                else
                    $("#warn-stats").html("");
            }

            //TODO: Check if move is valid

            //TODO: Check for moves to be learned
        });
}

function onClickAddPokemon() {

    $("#addmon-id").val("").parent().addClass("is-empty");
    $("#addmon-name").val("").parent().addClass("is-empty");
    $("#addmon-dex").val("").parent().addClass("is-empty");
    $("#addmon-level").val("").parent().addClass("is-empty");
    $("#addmon-exp").val(0).parent().removeClass("is-empty");
    $("#addmon-type1").val("").parent().addClass("is-empty");
    $("#addmon-type2").val("").parent().addClass("is-empty");
    $("#addmon-nature").val("").parent().addClass("is-empty");
    $("#addmon-gender").val("Genderless").parent().removeClass("is-empty");
    $("#addmon-discover").val("").parent().addClass("is-empty");
    $("#addmon-item").val("").parent().addClass("is-empty");
    $("#addmon-health").val("").parent().addClass("is-empty");
    $("#addmon-injure").val("0").parent().removeClass("is-empty");
    $("#addmon-hp").val("").parent().addClass("is-empty");
    $("#addmon-atk").val("").parent().addClass("is-empty");
    $("#addmon-def").val("").parent().addClass("is-empty");
    $("#addmon-spdef").val("").parent().addClass("is-empty");
    $("#addmon-spatk").val("").parent().addClass("is-empty");
    $("#addmon-speed").val("").parent().addClass("is-empty");
    $("[title='Move 1']").val("");
    $("[title='Move 2']").val("");
    $("[title='Move 3']").val("");
    $("[title='Move 4']").val("");
    $("[title='Move 5']").val("");
    $("[title='Move 6']").val("");
    $("[title='Move 7']").val("");
    $("[title='Move 8']").val("");
    $("[title='Move 9']").val("");
    $("[title='Ability 1']").val("");
    $("[title='Ability 2']").val("");
    $("[title='Ability 3']").val("");

    $('#modalAddPokemon').modal('show');
}

function onClickEditPokemon(id) {
    var types = gm_data['pokemon'][id]['type'].split(" / ");

    $("#addmon-id").val(id);
    $("#addmon-name").val(gm_data['pokemon'][id]['name']).parent().removeClass("is-empty");
    $("#addmon-dex").val(gm_data['pokemon'][id]['dex']).parent().removeClass("is-empty");
    $("#addmon-level").val(gm_data['pokemon'][id]['level']).parent().removeClass("is-empty");
    $("#addmon-exp").val(gm_data['pokemon'][id]['EXP']).parent().removeClass("is-empty");
    $("#addmon-type1").val(types[0]).parent().removeClass("is-empty");
    if (types[1] != null)
        $("#addmon-type2").val(types[1]).parent().removeClass("is-empty");
    $("#addmon-nature").val(gm_data['pokemon'][id]['nature']).parent().removeClass("is-empty");
    $("#addmon-gender").val(gm_data['pokemon'][id]['gender']).parent().removeClass("is-empty");
    $("#addmon-discover").val(gm_data['pokemon'][id]['discovery']).parent().removeClass("is-empty");
    $("#addmon-item").val(gm_data['pokemon'][id]['held-item']).parent().removeClass("is-empty");
    $("#addmon-health").val(gm_data['pokemon'][id]['health']).parent().removeClass("is-empty");
    $("#addmon-injure").val(gm_data['pokemon'][id]['injuries']).parent().removeClass("is-empty");
    $("#addmon-hp").val(gm_data['pokemon'][id]['hp']).parent().removeClass("is-empty");
    $("#addmon-atk").val(gm_data['pokemon'][id]['atk']).parent().removeClass("is-empty");
    $("#addmon-def").val(gm_data['pokemon'][id]['def']).parent().removeClass("is-empty");
    $("#addmon-spdef").val(gm_data['pokemon'][id]['spdef']).parent().removeClass("is-empty");
    $("#addmon-spatk").val(gm_data['pokemon'][id]['spatk']).parent().removeClass("is-empty");
    $("#addmon-speed").val(gm_data['pokemon'][id]['speed']).parent().removeClass("is-empty");
    $("[title='Move 1']").val(gm_data['pokemon'][id]['moves'][0]);
    $("[title='Move 2']").val(gm_data['pokemon'][id]['moves'][1]);
    $("[title='Move 3']").val(gm_data['pokemon'][id]['moves'][2]);
    $("[title='Move 4']").val(gm_data['pokemon'][id]['moves'][3]);
    $("[title='Move 5']").val(gm_data['pokemon'][id]['moves'][4]);
    $("[title='Move 6']").val(gm_data['pokemon'][id]['moves'][5]);
    $("[title='Move 7']").val(gm_data['pokemon'][id]['moves'][6]);
    $("[title='Move 8']").val(gm_data['pokemon'][id]['moves'][7]);
    $("[title='Move 9']").val(gm_data['pokemon'][id]['moves'][8]);
    $("[title='Ability 1']").val(gm_data['pokemon'][id]['abilities'][0]);
    $("[title='Ability 2']").val(gm_data['pokemon'][id]['abilities'][1]);
    $("[title='Ability 3']").val(gm_data['pokemon'][id]['abilities'][2]);

    updatePokemonEditor();

    $('#modalAddPokemon').modal('show');
}

function onClickDeletePokemon(id) {

}

function onRenderPokemonManage() {
    /**
     * Save Pokemon
     */
    $("#btn-addmon").click(function () {

        var form = $(".form-addmon");
        var isValid = true;

        // Validate Form
        form.find("[required]").each(function () {
            if ($(this).val() == null || $(this).val() == "" || $(this).val() == " ") {
                $(this).parent().addClass("has-error");
                isValid = false;
            }
            else
                $(this).parent().removeClass("has-error");
        });

        if (!isValid) {
            doToast("One or more fields were not filled out properly. Please try again.")
        }
        else {
            var data = {}, moves = [], abil = [];

            form.find("input, select").each(function () {
                if (!$(this).parent().hasClass("addmon-moves") && !$(this).parent().hasClass("addmon-abilities")) {
                    if ($(this).attr("type") == "number")
                        data[$(this).attr("data-field")] = parseInt($(this).val());
                    else
                        data[$(this).attr("data-field")] = $(this).val();
                }
            });

            var type1 = $("#addmon-type1").val();
            var type2 = $("#addmon-type2").val();

            if (type2 == "")
                data["type"] = type1;
            else
                data["type"] = type1 + " / " + type2;

            var i = 0;

            form.find("#addmon-moves select").each(function () {
                moves[i] = $(this).val();
                i++;
            });

            i = 0;

            form.find("#addmon-abilities select").each(function () {
                abil[i] = $(this).val();
                i++;
            });

            data["moves"] = moves;
            data["abilities"] = abil;

            var pmon_id = $("#addmon-id").val();

            if (pmon_id == "") {
                pmon_id = generatePmonId();
            }

            gm_data["pokemon"][pmon_id] = data;

            doToast(gm_data["pokemon"][pmon_id]["name"] + " was saved");

            renderPokemonList();
            $('#modalAddPokemon').modal('hide');
        }
    });

    $("#btn-impmon").click(function () {

        var form = $(".form-impmon");
        var isValid = true;

        // Validate Form
        form.find("[required]").each(function () {
            if ($(this).val() == null || $(this).val() == "" || $(this).val() == " ") {
                $(this).parent().addClass("has-error");
                isValid = false;
            }
            else
                $(this).parent().removeClass("has-error");
        });

        if (!isValid) {
            doToast("One or more fields were not filled out properly. Please try again.")
        }
        else {

            var data = JSON.parse($("#impmon-JSON").val());

            data = JSONImport(data);

            var pmon_id = $("#impmon-id").val();

            if (pmon_id == "") {
                pmon_id = generatePmonId();
            }

            gm_data["pokemon"][pmon_id] = data;

            doToast(gm_data["pokemon"][pmon_id]["name"] + " was added");

            renderPokemonList();
        }
    });

    /*
     Pokemon Generator Bindings
     */
    $(".input-enable .form-control-enabler").click(function () {
        if ($(this).is(":checked")) {
            $(this).closest(".input-enable").find("select:not(.form-control-enabler), input:not(.form-control-enabler)")
                .removeAttr("disabled").parent().find("label").animate({opacity:1});

            if ($(this).attr("id") == "enable-species") {
                $("#enable-type").attr("disabled", "");
                $("#genmon-type").attr("disabled", "").parent().find("label").animate({opacity:0.6});
                $("#enable-habitat").attr("disabled", "");
                $("#genmon-habitat").attr("disabled", "").parent().find("label").animate({opacity:0.6});
                $("#enable-gen").attr("disabled", "");
                $("#genmon-gen").attr("disabled", "").parent().find("label").animate({opacity:0.6});
            }
        }
        else {
            $(this).closest(".input-enable").find("select:not(.form-control-enabler), input:not(.form-control-enabler)")
                .attr("disabled" , "").parent().find("label").animate({opacity:0.6});

            if ($(this).attr("id") == "enable-species") {
                if ($("#enable-type").removeAttr("disabled").is(":checked"))
                    $("#genmon-type").removeAttr("disabled").parent().find("label").animate({opacity:1});
                if ($("#enable-habitat").removeAttr("disabled").is(":checked"))
                    $("#genmon-habitat").removeAttr("disabled").parent().find("label").animate({opacity:1});
                if ($("#enable-gen").removeAttr("disabled").is(":checked"))
                    $("#genmon-gen").removeAttr("disabled").parent().find("label").animate({opacity:1});
            }
        }
    });

    $("#genmon-is-wild").click(function () {
        $('#group-owner-settings').collapse('toggle');

        if ($(this).is(":checked")) {
            $("#genmon-tmmax").val("0");
            $("#genmon-emmax").val("0");
        }
        else {
            $("#genmon-tmmax").val("3");
            $("#genmon-emmax").val("3");
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#genmon-lvl-slider').change(function() {
        var values = $(this).val();
        $("#genmon-lvlmin").val(values[0]);
        $("#genmon-lvlmax").val(values[1]);
    }).noUiSlider({
        start: [1, 100] ,
        step: 1,
        connect: true,
        range: {
            min: 1,
            max: 100
        }
    });

    $("#genmon-lvlmin").on('change', function(){
        $("#genmon-lvl-slider").val([$(this).val(), $("#genmon-lvlmax").val()]);
    });

    $("#genmon-lvlmax").on('change', function(){
        $("#genmon-lvl-slider").val([$("#genmon-lvlmin").val(), $(this).val()]);
    });

    // Generate Pokemon
    $("#btn-genmon").click(function () {
        var args = {};

        if ($("#enable-species").is(":checked")) {
            args["specific"] = $("#genmon-species").val();
        }
        else {
            if ($("#enable-type").is(":checked"))
                args["type"] = $("#genmon-type").val();

            if ($("#enable-habitat").is(":checked"))
                args["habitat"] = $("#genmon-habitat").val();

            if ($("#enable-gen").is(":checked"))
                args["generation"] = $("#genmon-gen").val();
        }

        var val = $("#genmon-discover").val();
        if (val != "")
            args["location"] = val;

        if (!$("#genmon-is-wild").is(":checked")) {
            if ($("#genmon-tp").is(":checked")) {
                args["top_percent"] = true;
                args["level_caught"] = $("#genmon-lvl-caught");
            }

            if ($("#genmon-soul").is(":checked"))
                args["enduring_soul"] = true;

            if ($("#genmon-horiz").is(":checked"))
                args["expand_horizons"] = true;

            if ($("#genmon-guide").is(":checked"))
                args["guidance"] = true;

            var ace = [];

            if ($("#genmon-ace-atk").is(":checked"))
                ace.push("atk");

            if ($("#genmon-ace-def").is(":checked"))
                ace.push("def");

            if ($("#genmon-ace-spatk").is(":checked"))
                ace.push("spatk");

            if ($("#genmon-ace-spdef").is(":checked"))
                ace.push("spdef");

            if ($("#genmon-ace-speed").is(":checked"))
                ace.push("speed");

            if (ace.length > 0)
                args["stat_ace"] = ace;

            args["save_tp"] = $("#genmon-tutor-unused").val();
        }

        val = $("#genmon-gender").val();
        if (val != "")
            args["gender"] = val;

        args["min_level"] = $("#genmon-lvlmin").val().replace(".00", "");

        args["max_level"] = $("#genmon-lvlmax").val().replace(".00", "");

        args["min_tm"] = $("#genmon-tmmin").val();

        args["max_tm"] = $("#genmon-tmmax").val();

        args["min_em"] = $("#genmon-emmin").val();

        args["max_em"] = $("#genmon-emmax").val();

        args["legendary"] = $("#genmon-legend").is(":checked");

        if ($("#genmon-weight-stats").is(":checked")) {
            args["stat_weights"] = {
                "HP": parseInt($("#genmon-hp").val()),
                "Attack": parseInt($("#genmon-atk").val()),
                "Defense": parseInt($("#genmon-def").val()),
                "SpecialAttack": parseInt($("#genmon-spatk").val()),
                "SpecialDefense": parseInt($("#genmon-spdef").val()),
                "Speed": parseInt($("#genmon-speed").val())
            };
        }

        alert(JSON.stringify(args));

        // Call API to get generated Pokemon
        $.getJSON("api/v1/generate", args, function (data) {
            alert(JSON.stringify(data));
        });
    });
}

function generatePmonId() {
    var pmon_id = "";

    // Create ID for Pokemon
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    //TODO: check if id exists
    for( var j=0; j < 3; j++ )
        pmon_id += chars.charAt(Math.floor(Math.random() * chars.length));

    return pmon_id;
}
