var connections = {}, previous_moves = [], in_battle = [];

// EXAMPLE ENTITY DATA
// gm_data["entities"] = {
//     "AX1": {
//         name: "Geodude",
//         entity_type: "POKEMON",
//         dex: "074",
//         exp: 190,
//         level: 14,
//         type: ['GROUND', 'ROCK'],
//         hp: [12],
//         health: [80],
//         atk: [10],
//         def: [10],
//         spatk: [10],
//         spdef: [10],
//         speed: [10],
//         tags: ['BURNED'],
//         battle_tags: ['ASLEEP'],
//         notes_gm: "",
//         notes_player: "",
//         notes_discovery: "Starter",
//         moves: [],
//         abilities: []
//     }
// };

var CurrentAction = {"dealer":{"CharacterId":2,"CampaignId":34,"Type":"POKEMON","PokedexNo":"374","PokedexId":1,"Name":"Siri","Owner":13,"Age":null,"Weight":null,"Height":null,"Sex":"Genderless","Type1":"Steel","Type2":"Psychic","Level":9,"Exp":87,"BaseHp":4,"BaseAtk":6,"BaseDef":8,"BaseSatk":4,"BaseSdef":6,"BaseSpd":3,"LvlUpHp":1,"LvlUpAtk":5,"LvlUpDef":0,"LvlUpSatk":3,"LvlUpSdef":7,"LvlUpSpd":1,"AddHp":0,"AddAtk":1,"AddDef":0,"AddSatk":-1,"AddSdef":0,"AddSpd":0,"Health":34,"Injuries":0,"Money":0,"SkillAcrobatics":2,"SkillAthletics":2,"SkillCharm":2,"SkillCombat":2,"SkillCommand":2,"SkillGeneralEd":2,"SkillMedicineEd":2,"SkillOccultEd":2,"SkillPokemonEd":2,"SkillTechnologyEd":2,"SkillFocus":2,"SkillGuile":2,"SkillIntimidate":2,"SkillIntuition":2,"SkillPerception":2,"SkillStealth":2,"SkillSurvival":2,"ApSpent":0,"ApBound":0,"ApDrained":0,"BackgroundName":null,"BackgroundAdept":null,"BackgroundNovice":null,"BackgroundPthc1":null,"BackgroundPthc2":null,"BackgroundPthc3":null,"Afflictions":null,"Notes":"Discovered at Starter","Nature":"Adamant","SheetType":null,"Hp":5,"Atk":12,"Def":8,"Satk":6,"Sdef":13,"Spd":4},"target":{"CharacterId":1,"CampaignId":34,"Type":"POKEMON","PokedexNo":"179","PokedexId":1,"Name":"Phoebe","Owner":9,"Age":null,"Weight":null,"Height":null,"Sex":"Female","Type1":"Electric","Type2":null,"Level":6,"Exp":60,"BaseHp":6,"BaseAtk":4,"BaseDef":4,"BaseSatk":7,"BaseSdef":5,"BaseSpd":4,"LvlUpHp":5,"LvlUpAtk":2,"LvlUpDef":2,"LvlUpSatk":3,"LvlUpSdef":2,"LvlUpSpd":0,"AddHp":0,"AddAtk":0,"AddDef":0,"AddSatk":0,"AddSdef":1,"AddSpd":-1,"Health":36,"Injuries":0,"Money":0,"SkillAcrobatics":2,"SkillAthletics":2,"SkillCharm":2,"SkillCombat":2,"SkillCommand":2,"SkillGeneralEd":2,"SkillMedicineEd":2,"SkillOccultEd":2,"SkillPokemonEd":2,"SkillTechnologyEd":2,"SkillFocus":2,"SkillGuile":2,"SkillIntimidate":2,"SkillIntuition":2,"SkillPerception":2,"SkillStealth":2,"SkillSurvival":2,"ApSpent":0,"ApBound":0,"ApDrained":0,"BackgroundName":null,"BackgroundAdept":null,"BackgroundNovice":null,"BackgroundPthc1":null,"BackgroundPthc2":null,"BackgroundPthc3":null,"Afflictions":null,"Notes":"Discovered at Starter","Nature":"Sassy","SheetType":null,"Hp":11,"Atk":6,"Def":6,"Satk":10,"Sdef":8,"Spd":3},"move":{"Type":"Normal","Freq":"At-Will","AC":"4","DB":"4","Class":"Physical","Range":"Melee, 1 Target","Crits On":20},"acc":15,"hit":true,"is_crit":false,"dmg_rolled":7,"dmg_dealt":19,"dmg_final":13};

var ActionHelper = {

    evalPrereq: function (prereq) {
        try {
            var r = eval(prereq.stmt);

            if (r instanceof Function)
                r = r();

            return prereq.val[r.toString().toLowerCase()];
        }
        catch (err) {
            return undefined;
        }
    }
};

var ActionImpl = {
    /**
     * Handle a move request and dish out effects
     * @param move Move JSON or Name
     * @param target_id The Pokemon id of the target
     * @param dealer_id The Pokemon id of the user
     * @param mods JSON Object of optional modifiers
     */
    performMove: function (move, target_id, dealer_id, mods) {
        var dmg_bonus = mods && mods['dmg_bonus'] ? mods['dmg_bonus'] : 0,
            acc_bonus = mods && mods['acc_bonus'] ? mods['acc_bonus'] : 0;

        var dealer = getJSONNonAsync("api/v1/data/character/" + dealer_id);
        var target = target_id !== "other" ? getJSONNonAsync("api/v1/data/character/" + target_id) : null;

        if ($.type(move) !== "object") {
            move = getJSONNonAsync("api/v1/moves/" + move);
        }

        doMoveDialog(dealer, move["Title"], move);

        var damageDone = 0;
        var canMove = true;

        CurrentAction = {"dealer": dealer, "target": target, "move": move};


        // Paralysis check
        if (AfflictionHelper.hasAffliction(dealer_id, "Paralysis")) {

            // Save check roll
            var check = roll(1, 20, 1);

            if (check < 5) {
                canMove = false;
                doToast(dealer['Name'] + " is paralyzed! They can't move!");
            }
        }

        // Confusion check
        if (canMove && AfflictionHelper.hasAffliction(dealer_id, "Confused"))
            canMove = AfflictionHelper.handleAffliction("Confused", dealer_id);

        // Check if Frozen (but don't Let It Go)
        if (AfflictionHelper.hasAffliction(dealer_id, "Frozen")) {
            doToast(dealer["Name"] + " is frozen solid!");
        }
        // Check if Fainted
        else if (AfflictionHelper.hasAffliction(dealer_id, "Fainted")) {
            doToast("Fainted Pokemon cannot use actions, abilities, or features");
        }
        else if (canMove) {

            var acRoll = roll(1, 20, 1);
            var crit = 20, acCheck = acRoll + parseInt(acc_bonus);

            // Show roll

            addMoveDialogInfo('<strong>ACC:</strong> ' + acRoll + ' + ' + acc_bonus);

            CurrentAction["acc"] = acRoll + acc_bonus;

            // Subtract target evade

            if (target !== null) {
                // Find speed evade
                var speed_evade = Math.floor(target["Spd"] / 5);

                // Apply evade bonus
                acCheck -= CharacterHelper.getEvadeBonus(target_id);

                if (move["Class"] === "Physical") {
                    var phy_evade = Math.floor(target["Def"] / 5);

                    acCheck -= speed_evade > phy_evade ? speed_evade : phy_evade;
                }
                else if (move["Class"] === "Special") {
                    var spc_evade = Math.floor(target["Sdef"] / 5);

                    acCheck -= speed_evade > spc_evade ? speed_evade : spc_evade;
                }
                else
                    acCheck -= speed_evade;
            }

            // Move missed
            if (move.hasOwnProperty('AC') && acCheck < parseInt(move["AC"])) {
                doToast("It missed!");
                CurrentAction["hit"] = false;

                // Check for triggers for if missed TODO
                // if (move.hasOwnProperty("Triggers")) {
                //     $.each(move["Triggers"], function (k, trigger) {
                //         if (trigger.hasOwnProperty("prereq") && trigger.prereq === "miss")
                //             $.each(trigger["req"]["miss"], function (t) {
                //                 this.handleTrigger(t, dealer_id, target_id, damageDone, move["Title"], acRoll);
                //             });
                //     });
                // }
            }
            // Move hit
            else {
                CurrentAction["hit"] = true;

                if (move["Class"] === "Physical" || move["Class"] === "Special") {
                    var db = parseInt(move["DB"]);

                    var is_crit = acRoll >= crit;

                    // STAB is moved to Player Client

                    // Roll for damage

                    var rolledDmg = rollDamageBase(db, is_crit ? 2 : 1);
                    var damage = 0;

                    // Show roll

                    addMoveDialogInfo('<strong>DMG:</strong> Rolled ' + rolledDmg + ' on DB' + db);

                    CurrentAction["is_crit"] = is_crit;
                    CurrentAction["dmg_rolled"] = rolledDmg;

                    // Declare if critical hit
                    if (acRoll >= crit)
                        doToast("Critical hit!");

                    // Add stat bonus to damage
                    if (move["Class"] === "Physical") {
                        damage = rolledDmg + dealer["Atk"];
                    }
                    else if (move["Class"] === "Special") {
                        damage = rolledDmg + dealer["Satk"];
                    }

                    // Distribute damage

                    damage += parseInt(dmg_bonus);

                    CurrentAction["dmg_dealt"] = damage;

                    if (target_id === "other") {
                        doToast("OUTGOING DAMAGE = " + damage);
                        addMoveDialogInfo('<strong>OUTGOING DAMAGE:</strong> ' + damage);
                        damageDone = damage;
                    }
                    else {
                        damageDone = this.damageCharacter(target, move["Type"], move["Class"] === "Special", damage);
                        addMoveDialogInfo('<strong>'+ damageDone +'</strong> total damage');
                    }

                    CurrentAction["dmg_final"] = damageDone;
                }

                /*
                Triggers TODO
                 */

                if (move.hasOwnProperty("Triggers")) {
                    // $.each(move["Triggers"], function (k, trigger) {
                    //     this.handleTrigger(trigger, dealer_id, target_id, damageDone, move["Title"], acRoll);
                    // });
                }
            }
        }

        /*
         Afflictions (move end)
         */

        if (AfflictionHelper.hasAffliction(dealer_id, "Burned"))
            AfflictionHelper.handleAffliction("Burned", dealer_id);
        if (AfflictionHelper.hasAffliction(dealer_id, "Frozen"))
            AfflictionHelper.handleAffliction("Frozen", dealer_id);
    },

    /**
     * Inflict incoming damage onto a specified Pokemon
     * @param target JSON of the character taking damage
     * @param moveType The move type
     * @param moveIsSpecial True when special, false when physical
     * @param damage The amount of damage
     */
    damageCharacter: function (target, moveType, moveIsSpecial, damage) {

        if (target && $.type(target) !== "object") {
            target = getJSONNonAsync("api/v1/data/character/" + target);
        }

        damage -= moveIsSpecial ? target["Sdef"] : target["Def"];

        var effect1 = 1, effect2 = 1;

        if (moveType && target["Type1"]) {
            effect1 = typeEffects[moveType.toLowerCase()][target["Type1"].toLowerCase()];
            effect2 = target["Type2"] && target["Type2"] !== "" ?
                typeEffects[moveType.toLowerCase()][target["Type2"].toLowerCase()] : 1;
        }

        damage = damage * effect1 * effect2;

        if (effect1 * effect2 === 0)
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
        var max_hp = target['Level'] + target['Hp'] * 3 + 10;

        // Checking for injuries
        if (damage >= max_hp/2){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        if (target["Health"] > max_hp/2 && target["Health"] - damage <= max_hp/2){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        if (target["Health"] > 0 && target["Health"] - damage <= 0){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        if (target["Health"] > -max_hp/2 && target["Health"] - damage <= -max_hp/2){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        if (target["Health"] > -max_hp && target["Health"] - damage <= -max_hp){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        if (target["Health"] > -max_hp*3/2 && target["Health"] - damage <= -max_hp*3/2){
            target["Injuries"] = parseInt(target["Injuries"],10) + 1;
        }
        //No need to go to other thresholds, as you'd be dead at that point

        // Find Max HP based on Injuries
        max_hp = Math.round((10-target["Injuries"])/10 * max_hp);

        // Subtract health
        target["Health"] -= damage;

        //Limiting health by number of injuries if appropriate
        if (target["Health"] > max_hp){
            target["Health"] = max_hp;
        }

        // Check if fainted
        if (target["Health"] <= 0) {
            doToast(target["name"] + " fainted!");
            target["Health"] = 0;
            AfflictionHelper.addAffliction("Fainted", target["CharacterId"], 0);
        }

        // Update health bar
        var w = Math.floor((target['Health'] / max_hp) * 100);

        $("[data-name='"+target["CharacterId"]+"']").find(".progress-bar").css("width", w + "%");

        // Update Player client TODO
        // sendMessage(battle[target_id]["client_id"], JSON.stringify({
        //     "type": "health",
        //     "value": target['health']
        // }));

        // Check if cured target of Frozen
        if ((moveType === "Fire" || moveType === "Fighting" || moveType === "Rock" || moveType === "Steel") &&
                AfflictionHelper.hasAffliction("Frozen", target["CharacterId"])) {
            AfflictionHelper.deleteAffliction("Frozen", target["CharacterId"]);
        }

        return damage;
    },

    handleTrigger: function (trigger, dealer_id, target_id) {

        // If trigger is a prereq
        if (trigger.hasOwnProperty("prereq")) {

            // Accuracy prerequisite
            if (trigger.prereq == "accuracy" && trigger.req.hasOwnProperty(String(CurrentAction['acc']))) {
                // If not pointing to other entry
                if (typeof trigger.req[String(CurrentAction['acc'])] == "object")
                    this.handleTrigger(trigger.req[String(CurrentAction['acc'])], dealer_id, target_id);
                else
                    this.handleTrigger(trigger.req[String(trigger.req[String(CurrentAction['acc'])])], dealer_id, target_id);
            }
        }
        // Not a prereq
        else {
            //Making a variable for storing important ids
            var id;
            if (trigger.hasOwnProperty("target")){
                id = trigger.target == "SELF" ? dealer_id : target_id;
            }

            //Handling trigger by type
            if (trigger.type=="action-needed"){
                doToast(trigger.text);

                addMoveDialogInfo('<strong>MANUAL ACTION:</strong> ' + trigger.text);
            }
            else if (trigger.type=="CS"){
                //Raising/lowering stats
                $.each(trigger.stat, function(k, stat){
                    battle[id]["stage_"+stat] = parseInt(battle[id]["stage_"+stat]) + trigger.value;

                    if (battle[id]["stage_"+stat] > 6)
                        battle[id]["stage_"+stat] = 6;
                    else if (battle[id]["stage_"+stat] < -6)
                        battle[id]["stage_"+stat] = -6;

                    // Notify client
                    sendMessage(battle[id]['client_id'], JSON.stringify({
                        "type": "data_changed",
                        "field": "stage-"+stat,
                        "value": battle[id]['stage_'+stat]
                    }));

                    // Log change
                    if (trigger.value > 0)
                        addMoveDialogInfo(gm_data["pokemon"][id]['name'] + '\'s <strong>'+stat+'</strong> increased');
                    else
                        addMoveDialogInfo(gm_data["pokemon"][id]['name'] + '\'s <strong>'+stat+'</strong> decreased');
                });
            }
            else if (trigger.type=="heal"){
                //Seeing what type of healing is needed
                var arr = trigger.value.split(" ");

                // Getting max HP
                var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;

                //Getting multiplier
                var mult = arr[0] == "1/2" ? 0.5 : parseInt(arr[0], 10);

                //Checking type of healing and setting HP
                if (arr[1]=="HP"){
                    gm_data["pokemon"][id]['health'] = Math.min(max_hp*(10-gm_data["pokemon"][id]['injuries'])/10,
                        gm_data["pokemon"][id]['health']+mult*max_hp)
                } else if (arr[1]=="Damage"){
                    gm_data["pokemon"][id]['health'] = Math.min(max_hp*(10-gm_data["pokemon"][id]['injuries'])/10,
                        gm_data["pokemon"][id]['health']+mult*CurrentAction['dmg_dealt'])
                }

                //Setting Health bar
                var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);
                $("[data-name='"+id+"']").find(".progress-bar").css("width", w + "%");

                // Log change
                addMoveDialogInfo(gm_data["pokemon"][id]['name'] + ' <strong>was healed</strong>');
            }
            else if (trigger.type=="vortex"){
                //TODO: Figure out vortex
                // Log change
                addMoveDialogInfo('<strong>Vortex</strong> has yet to be implemented');
            }
            else if (trigger.type=="push"){
                //TODO: Wait until map is implemented
                // Log change
                addMoveDialogInfo('<strong>Push</strong> has yet to be implemented');
            }
            else if (trigger.type=="switch"){
                //TODO: Not really a mechanism for this at present
                // Log change
                addMoveDialogInfo('<strong>Switch</strong> has yet to be implemented');
            }
            else if (trigger.type=="status"){
                $.each(trigger.stat, function (k, status) {
                    AfflictionHelper.addAffliction(status, id, 0);
                });
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
                if (target["Health"] > max_hp/2 && target["Health"] - damage <= max_hp/2){
                    target["Injuries"] = parseInt(target["Injuries"],10) + 1;
                }
                if (target["Health"] > 0 && target["Health"] - damage <= 0){
                    target["Injuries"] = parseInt(target["Injuries"],10) + 1;
                }
                if (target["Health"] > -max_hp/2 && target["Health"] - damage <= -max_hp/2){
                    target["Injuries"] = parseInt(target["Injuries"],10) + 1;
                }
                if (target["Health"] > -max_hp && target["Health"] - damage <= -max_hp){
                    target["Injuries"] = parseInt(target["Injuries"],10) + 1;
                }
                if (target["Health"] > -max_hp*3/2 && target["Health"] - damage <= -max_hp*3/2){
                    target["Injuries"] = parseInt(target["Injuries"],10) + 1;
                }
                //No need to go to other thresholds, as you'd be dead at that point

                //Lowering health
                gm_data["pokemon"][id]['health'] = Math.min(gm_data["pokemon"][id]['health'] - dmg,max_hp*(10-gm_data["pokemon"][id]['injuries'])/10);

                //Setting Health bar
                var w = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);
                $("[data-name='"+id+"']").find(".progress-bar").css("width", w + "%");
            }
            else if (trigger.type=="protect"){
                //TODO: Need ability to interrupt to implement

                // Log change
                addMoveDialogInfo('<strong>Protect/Interrupt</strong> has yet to be implemented');
            }
            else if (trigger.type=="execute"){
                var r = roll(1,100,1);
                if (r <= 30+gm_data["pokemon"][dealer_id]['level']-target['level']){
                    doToast(target["name"] + " fainted!");
                    target["Health"] = 0;
                } else {
                    doToast(CurrentAction.move.Name + " missed "+target["name"]+"!");
                }
            }
        }
    }
};

function getStatByAction(stat_name, action_data, battler) {
    var character = battler === "TARGET" ? action_data.target : action_data.dealer;

    switch (stat_name) {
        case "HP":
            return character.BaseHp + character.AddHp + character.LvlUpHp;
        case "ATK":
            return character.BaseAtk + character.AddAtk + character.LvlUpAtk;
        case "DEF":
            return character.BaseDef + character.AddDef + character.LvlUpDef;
        case "SATK":
            return character.BaseSatk + character.AddSatk + character.LvlUpSatk;
        case "SDEF":
            return character.BaseSdef + character.AddSdef + character.LvlUpSdef;
        case "SPD":
            return character.BaseSpd + character.AddSpd + character.LvlUpSpd;
        default:
            return 0;
    }
}

function startBattle() {
    in_battle = {};
}

function endBattle() {
    if (window.confirm("Are you sure you want to reset the battle?")) {

        // Notify player clients
        $.each(in_battle, function (k, v) {
            sendMessage(v, JSON.stringify({
                "type": "battle_end"
            }));
        });

        // Reset data
        in_battle = {};

        // Redraw battler
        renderBattler();
    }
}

//TODO: Move to host.js after refining
/**
 * Generates the Pokemon battle, primarily the health visual
 */
function renderBattler() {
    if (currentView == 0) {
        // Create grid
        generateGrid($(".battle-grid"), parseInt($("#zoom-slider").val()) * 6);

        var html = '';

        // If no one is in battle
        if ($.isEmptyObject(in_battle)) {
            html = '<h3 class="text-muted">No one\'s here yet 😟</h3>' +
                '<h4 class="text-muted">Send your <a data-toggle="modal" data-target="#modalShare">customized link</a> to your players. ' +
                'Then, have them hit "Join Battle" when they\'re ready.</h4>';
        }
        else {

            // Create health bars

            $.each(in_battle, function (key, id) {
                var max_hp = gm_data["entities"][id]['level'] + getStatById('hp', id) * 3 + 10;
                var w = Math.floor((getStatById('health', id) / max_hp) * 100);

                if (w > 100)
                    console.log("Warning: Pokemon with ID " + id + " has hit points above its max: " +
                        getStatById('health', id) + "/" + max_hp);

                // TODO: Render afflictions
                var afflictions = "";
                //
                // if (gm_data["pokemon"][id]['afflictions'] != null)
                //     $.each(gm_data["pokemon"][id]['afflictions'], function (k, a) {
                //         afflictions += ' <span class="label label-danger">' + a + '</span>';
                //     });
                //
                // if (data['afflictions'] != null)
                //     $.each(data['afflictions'], function (a, v) {
                //         afflictions += ' <span class="label label-danger">' + a + '</span>';
                //     });

                // Generate HTML
                html += '<div class="col-md-6 col-md-offset-3 pokemon" data-name="' + id + '">' +
                    '<h2 class="name">' + gm_data["pokemon"][id]["name"] + afflictions + '</h2>' +
                    '<div class="progress" data-hp="' + gm_data["pokemon"][id]["hp"] + '" data-max-hp="' + gm_data["pokemon"][id]["max_hp"] + '">' +
                    '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="' + w + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + w + '%;"></div>' +
                    '</div>' +
                    '</div>';
            });

            html += '<br/><button class="btn btn-danger btn-raised" onclick="endBattle()">End Battle</button>';
        }

        //$("#view-holder").html(html);
        $("#tab-battle-list").html(html);
    }
}

// TODO: convert at upload

function doGMDataConvert_v1_v2() {
    gm_data.entities = {};
    $.each(gm_data.pokemon, function (id, data) {
        data.entity_type = 'POKEMON';
        data.hp = [data.hp];
        data.health = [data.health];
        data.atk = [data.atk];
        data.def = [data.def];
        data.spatk = [data.spatk];
        data.spdef = [data.spdef];
        data.speed = [data.speed];
        data.notes_discovery = data.discovery;
        data.type = data.type.split("/");

        delete data.afflictions;
        delete data.discovery;

        gm_data.entities[id] = data;
    });
}