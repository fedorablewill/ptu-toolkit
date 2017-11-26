var connections = {}, previous_moves = [], in_battle = [];

function readMessage(connection, data) {

    var json = JSON.parse(data);

    /*
         Snackbar Alert Received
         */
    if (json.type == "alert"){
        doToast(message["content"]);
    }
    /*
     Send Pokemon Data
     */
    else if (json.type == "pokemon_get") {
        var msg = {
            "type": "pokemon",
            "pokemon": gm_data["entities"][json.pokemon_id]
        };
        connection.send(JSON.stringify(msg));
    }
    /*
     Send Pokemon List
     */
    else if (json.type == "pokemon_list") {
        var msg1 = {
            "type": "pokemon_list",
            "pokemon": gm_data["entities"]
        };
        connection.send(JSON.stringify(msg1));
    }
    /*
     Add Pokemon to Battle
     */
    else if (json.type == "battle_add") {

        var pokemon_id = json.pokemon;

        $.each(in_battle, function (key, id) {
            sendMessageToAll(JSON.stringify({
                "type": "battle_added",
                "pokemon_id": pokemon_id,
                "pokemon_name": gm_data["entities"][pokemon_id]["name"]
            }));

            connection.send(JSON.stringify({
                "type": "battle_added",
                "pokemon_id": id,
                "pokemon_name": gm_data["entities"][id]["name"]
            }));
        });

        // Record peer id
        connections[json.pokemon] = json.from;

        // Add as "In Battle"
        in_battle.push(json.pokemon);

        // TODO: reset CS on player client when joining battle

        connection.send(JSON.stringify({
            "type": "battle_added",
            "pokemon_id": pokemon_id,
            "pokemon_name": gm_data["entities"][pokemon_id]["name"]
        }));

        // TODO: If has persistent affliction, update data appropriately

        // Display Message
        doToast(gm_data["entities"][json.pokemon]["name"] + " Appears!");

        renderBattler();
    }
    /*
     Update Field Received
     */
    else if (json.type == "pokemon_update") {
        gm_data["entities"][json.pokemon][json.field][0] = json.value;

        if (this.field === "health") {
            gm_data["entities"][json.pokemon]['health'][0] = json.value;
        }
    }
    /*
     Update Combat Stage Received
     */
    else if (json.type == "pokemon_setcs") { //TODO: new logic for CS
        battle[json.pokemon][json.field] = json.value;
    }
    /*
     Add an affliction
     */
    else if (json.type == "pokemon_afflict_add") {
        addAffliction(json.affliction, json.pokemon, json['value']);
    }
    /*
     Remove an affliction
     */
    else if (json.type == "pokemon_afflict_delete") {
        deleteAffliction(json.affliction, json.pokemon);
    }
    /*
     Trigger an affliction's handler
     */
    else if (json.type == "pokemon_afflict_trigger") {
        handleAffliction(json.affliction, json.pokemon);
    }
    /*
     Request for battle grid
     */
    else if (json.type == "battle_grid") {
        // Get grid size
        var size = (json.max_width / parseInt($("#grid-w").val())) - 2;
        // Create parent
        var grid = $('<div />');

        // Create ready callback
        grid.ready_callback = function () {
            // Send result
            connection.send(JSON.stringify({
                'type': 'battle_grid',
                'html': grid.html()
            }));
        };

        // Generate grid
        generateGrid(grid, size);
    }
    /*
     Attack Received
     */
    else if (json.type == "battle_move") {
        performMove(json.move, json.target, json.dealer, json.bonus_acc, json.bonus_dmg);
    }
    /*
     Manual Damage Received
     */
    else if (json.type == "battle_damage") {
        var target = $.get("api/v1/data/character/" + json.target);
        damagePokemon(target, json.moveType, json.isSpecial, json.damage);
    }
    /*
     Request for Status
     */
    else if (json.type == "status") {
        connection.send(JSON.stringify({
            "type": "gm_status",
            "value": "online"
        }));
    }
}

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

var current_move = {
    "move": {
        "Name":"Bugg Buzz",
        "Type":"Bug",
        "Freq":"Scene x2",
        "AC":"2","DB":"9",
        "Class":"Special",
        "Range":"Cone 2 or Close Blast 2; Sonic, Smite",
        "Effect":"Bug Buzz lowers the Special Defense of all legal targets by -1 CS on 19+.",
        "Contest Type":"Cute",
        "Contest Effect":"Incentives",
        "Crits On":20,
        "Triggers":[{"prereq":{
            "stmt": "current_move.acc >= 18",
            "val": {
                "true": {"type":"CS","stat":["spdef"],"value":-1,"target":"TARGET"}
            }
        }}]
    },
    "dealer": "AAA",
    "target": "BBB",
    "acc": 17,
    "hit": true,
    "dmg-rolled": 17,
    "dmg-dealt": 27
};

function evalPrereq(prereq) {
    try {
        var r = eval(prereq.stmt);

        if (r instanceof Function)
            r = r();

        return prereq.val[r.toString().toLowerCase()];
    }
    catch (err) { return undefined; }
}

function hasAffliction(id, affliction) {
    //TODO: afflictions
    return false;
}

function getStatByAction(stat_name, action_data, battler) {
    var character = battler === "TARGET" ? action_data.target : action_data.dealer;

    switch (stat_name) {
        case "HP":
            return character.BaseHp + character.AddHp;
        case "ATK":
            return character.BaseAtk + character.AddAtk;
        case "DEF":
            return character.BaseDef + character.AddDef;
        case "SATK":
            return character.BaseSatk + character.AddSatk;
        case "SDEF":
            return character.BaseSdef + character.AddSdef;
        case "SPD":
            return character.BaseSpd + character.AddSpd;
        default:
            return 0;
    }
}

/**
 * Handle a move request and dish out effects
 * @param move Move JSON
 * @param target_id The Pokemon id of the target
 * @param dealer_id The Pokemon id of the user
 * @param mods JSON Object of optional modifiers
 */
function performMove(move, target_id, dealer_id, mods) {
    var dmg_bonus = mods && mods['dmg_bonus'] ? mods['dmg_bonus'] : 0,
        acc_bonus = mods && mods['acc_bonus'] ? mods['acc_bonus'] : 0;

    var dealer = $.getJSON("api/v1/data/character/" + dealer_id);
    if (target_id !== "other")
        var target = $.getJSON("api/v1/data/character/" + target_id);

    doMoveDialog(dealer_id, move["Title"], move);

    var damageDone = 0;
    var canMove = true;

    current_move = {"dealer": dealer, "target": target, "move": move};


    // Paralysis check
    if (hasAffliction(dealer_id, "Paralysis")) {

        // Save check roll
        var check = roll(1, 20, 1);

        if (check < 5) {
            canMove = false;
            doToast(dealer['Name'] + " is paralyzed! They can't move!");
        }
    }

    // Confusion check
    if (canMove && hasAffliction(dealer_id, "Confused"))
        canMove = handleAffliction("Confused", dealer_id);

    // Check if Frozen (but don't Let It Go)
    if (hasAffliction(dealer_id, "Frozen")) {
        doToast(dealer["Name"] + " is frozen solid!");
    }
    // Check if Fainted
    else if (hasAffliction(dealer_id, "Fainted")) {
        doToast("Fainted Pokemon cannot use actions, abilities, or features");
    }
    else if (canMove) {

        var acRoll = roll(1, 20, 1);
        var crit = 20, acCheck = acRoll + parseInt(acc_bonus);

        // Show roll

        addMoveDialogInfo('<strong>ACC:</strong> ' + acRoll + ' + ' + acc_bonus);

        current_move["acc"] = acRoll + acc_bonus;

        // Subtract target evade

        if (target_id !== "other") {
            // Find speed evade
            var speed_evade = Math.floor(getStatByAction('SPD', current_move, "TARGET") / 5);

            // Apply evade bonus
            acCheck -= getEvadeBonus(target_id);

            if (move["Class"] === "Physical") {
                var phy_evade = Math.floor(getStatByAction('DEF', current_move, "TARGET") / 5);

                acCheck -= speed_evade > phy_evade ? speed_evade : phy_evade;
            }
            else if (move["Class"] === "Special") {
                var spc_evade = Math.floor(getStatByAction('SDEF', current_move, "TARGET") / 5);

                acCheck -= speed_evade > spc_evade ? speed_evade : spc_evade;
            }
            else
                acCheck -= speed_evade;
        }

        // Move missed
        if (move.hasOwnProperty('AC') && acCheck < parseInt(move["AC"])) {
            doToast("It missed!");
            current_move["hit"] = false;

            // Check for triggers for if missed
            if (move.hasOwnProperty("Triggers")) {
                $.each(move["Triggers"], function (k, trigger) {
                    if (trigger.hasOwnProperty("prereq") && trigger.prereq === "miss")
                        $.each(trigger["req"]["miss"], function (t) {
                            handleTrigger(t, dealer_id, target_id, damageDone, move["Title"], acRoll);
                        });
                });
            }
        }
        // Move hit
        else {
            current_move["hit"] = true;

            if (move["Class"] === "Physical" || move["Class"] === "Special") {
                var db = parseInt(move["DB"]);

                // STAB is moved to Player Client

                // Roll for damage

                var rolledDmg = rollDamageBase(db, acRoll >= crit ? 2 : 1);
                var damage = 0;

                // Show roll

                addMoveDialogInfo('<strong>DMG:</strong> Rolled ' + rolledDmg + ' on DB' + db);
                current_move["dmg_rolled"] = rolledDmg;

                // Declare if critical hit
                if (acRoll >= crit)
                    doToast("Critical hit!");

                // Add stat bonus to damage
                if (move["Class"] === "Physical") {
                    damage = rolledDmg + getStatByAction('ATK', current_move, "DEALER");
                }
                else if (move["Class"] === "Special") {
                    damage = rolledDmg + getStatByAction('SATK', current_move, "DEALER");
                }

                // Distribute damage

                damage += parseInt(dmg_bonus);

                current_move["dmg_dealt"] = damage;

                if (target_id === "other") {
                    doToast("OUTGOING DAMAGE = " + damage);
                    addMoveDialogInfo('<strong>OUTGOING DAMAGE:</strong> ' + damage);
                    damageDone = damage;
                }
                else {
                    damageDone = damagePokemon(target, move["Type"], move["Class"] === "Special", damage);
                    addMoveDialogInfo('<strong>'+ damageDone +'</strong> total damage');
                }
            }

            /*
            Triggers
             */

            if (move.hasOwnProperty("Triggers")) {
                $.each(move["Triggers"], function (k, trigger) {
                    handleTrigger(trigger, dealer_id, target_id, damageDone, move["Title"], acRoll);
                });
            }
        }
    }

    /*
     Afflictions (move end)
     */

    if (hasAffliction(dealer_id, "Burned"))
        handleAffliction("Burned", dealer_id);
    if (hasAffliction(dealer_id, "Frozen"))
        handleAffliction("Frozen", dealer_id);
}

/**
 * Inflict incoming damage onto a specified Pokemon
 * @param target JSON of the character taking damage
 * @param moveType The move type
 * @param moveIsSpecial True when special, false when physical
 * @param damage The amount of damage
 */
function damagePokemon(target, moveType, moveIsSpecial, damage) {
    if (moveIsSpecial)
        damage -= getStatByAction('SDEF', current_move, "TARGET");
    else
        damage -= getStatByAction('SPD', current_move, "TARGET");

    var effect1 = 1, effect2 = 1;

    if (moveType == null) {
        effect1 = typeEffects[moveType.toLowerCase()][target["Type1"].toLowerCase()];
        effect2 = target["Type2"] !== null && target["Type2"] !== "" ?
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
    var max_hp = gm_data["pokemon"][target_id]['level'] + gm_data["pokemon"][target_id]['hp'] * 3 + 10;

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

    // Subtract health
    target["Health"] -= damage;

    //Limiting health by number of injuries if appropriate
    if ((10-target["Injuries"])/10 * max_hp < target["Health"]){
        target["Health"] = (10-target["Injuries"])/10;
    }

    // Check if fainted
    if (target["Health"] <= 0) {
        doToast(target["name"] + " fainted!");
        target["Health"] = 0;
        addAffliction("Fainted", target_id, 0);
    }

    // Update health bar
    var w = Math.floor((target['health'] / max_hp) * 100);

    $("[data-name='"+target_id+"']").find(".progress-bar").css("width", w + "%");

    // Update Player client
    sendMessage(battle[target_id]["client_id"], JSON.stringify({
        "type": "health",
        "value": target['health']
    }));

    // Check if cured target of Frozen
    if ((moveType === "Fire" || moveType === "Fighting" || moveType === "Rock" || moveType === "Steel") &&
        $.inArray("Frozen", target['afflictions']) >= 0) {

        deleteAffliction("Frozen", target_id);
    }

    return damage;
}

function handleTrigger(trigger, dealer_id, target_id){

    // If trigger is a prereq
    if (trigger.hasOwnProperty("prereq")) {

        // Accuracy prerequisite
        if (trigger.prereq == "accuracy" && trigger.req.hasOwnProperty(String(current_move['acc']))) {
            // If not pointing to other entry
            if (typeof trigger.req[String(current_move['acc'])] == "object")
                handleTrigger(trigger.req[String(current_move['acc'])], dealer_id, target_id);
            else
                handleTrigger(trigger.req[String(trigger.req[String(current_move['acc'])])], dealer_id, target_id);
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
                    gm_data["pokemon"][id]['health']+mult*current_move['dmg_dealt'])
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
                addAffliction(status, id, 0);
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
                doToast(current_move.move.Name + " missed "+target["name"]+"!");
            }
        }
    }
}



function addAffliction(affliction, entity_id, value) {
    
    affliction = affliction.toUpperCase();

    // Create array if not found
    if (!gm_data["entities"][entity_id].hasOwnProperty('tags'))
        gm_data["entities"][entity_id]['tags'] = [];

    // Persistent Afflictions
    if ((affliction == "BURNED" && $.inArray("Fire", gm_data["entities"][entity_id]['type'].split(" / ")) < 0) ||
        (affliction == "FROZEN" && $.inArray("Ice", gm_data["entities"][entity_id]['type'].split(" / ")) < 0) ||
        (affliction == "PARALYSIS" && $.inArray("Electric", gm_data["entities"][entity_id]['type'].split(" / ")) < 0) ||
        (affliction == "POISONED"  && $.inArray("Poison", gm_data["entities"][entity_id]['type'].split(" / ")) < 0 &&
            $.inArray("Steel", gm_data["entities"][entity_id]['type'].split(" / ")) < 0)) {

        // Add affliction to list
        gm_data["entities"][entity_id]['tags'].push(affliction);

        // SPECIAL EFFECTS

        // Burn: Defense -2 CS during burn
        if (affliction == "BURNED") {
            modifyCombatStage(entity_id, 'def', -2);

            doToast(gm_data["entities"][entity_id]['name'] + " is being burned!");
        }
        else if (affliction == "FROZEN") {
            doToast(gm_data["entities"][entity_id]['name'] + " is frozen solid!");
        }
        else if (affliction == "PARALYSIS") {
            doToast(gm_data["entities"][entity_id]['name'] + " has been paralyzed!");
        }
        else if (affliction == "POISONED") {
            modifyCombatStage(entity_id, 'spdef', -2);

            doToast(gm_data["entities"][entity_id]['name'] + " has been poisoned!");
        }
    }
    // Other Afflictions
    else {
        // Set affliction in battle entry
        gm_data["entities"][entity_id]['battle_tags'].push(affliction);

        // Fainted: Cure of Persistent and Volatile afflictions
        if (affliction == "FAINTED") {
            if (hasAffliction("FROZEN"))
                deleteAffliction("Frozen", entity_id);
            if (hasAffliction("BURNED"))
                deleteAffliction("Burned", entity_id);
            if (hasAffliction("PARALYSIS"))
                deleteAffliction("Paralysis", entity_id);
            if (hasAffliction("POISONED"))
                deleteAffliction("Poisoned", entity_id);
            if (hasAffliction("BAD SLEEP"))
                deleteAffliction("Bad Sleep", entity_id);
            if (hasAffliction("CONFUSED"))
                deleteAffliction("Confused", entity_id);
            if (hasAffliction("CURSED"))
                deleteAffliction("Cursed", entity_id);
            if (hasAffliction("DISABLED"))
                deleteAffliction("Disabled", entity_id);
            if (hasAffliction("RAGE"))
                deleteAffliction("Rage", entity_id);
            if (hasAffliction("FLINCH"))
                deleteAffliction("Flinch", entity_id);
            if (hasAffliction("INFATUATION"))
                deleteAffliction("Infatuation", entity_id);
            if (hasAffliction("SLEEP"))
                deleteAffliction("Sleep", entity_id);
            if (hasAffliction("SUPPRESSED"))
                deleteAffliction("Suppressed", entity_id);
            if (hasAffliction("TEMPORARY HIT POINTS"))
                deleteAffliction("Temporary Hit Points", entity_id);
        }
        else if (affliction == "CONFUSED") {
            doToast(gm_data["entities"][entity_id]['name'] + " is Confused!");
        }
    }

    // Update Player client
    sendMessage(connections[entity_id]["client_id"], JSON.stringify({
        "type": "afflict_add",
        "affliction": affliction
    }));

    if (currentView == 0)
        renderBattler();
}

function deleteAffliction(affliction, entity_id) {

    affliction = affliction.toUpperCase();
    
    if (affliction == "BURNED" || affliction == "FROZEN" ||
        affliction == "PARALYSIS" || affliction == "POISONED") {

        // Remove from array
        gm_data["entities"][entity_id]['tags'].push(affliction).splice(array.indexOf(affliction), 1);

        // SPECIAL EFFECTS

        // Burn: Defense -2 CS during burn
        if (affliction == "BURNED") {
            modifyCombatStage(entity_id, 'def', 2);

            doToast(gm_data["entities"][entity_id]['name'] + " was cured of their burn");
        }
        else if (affliction == "FROZEN") {
            doToast(gm_data["entities"][entity_id]['name'] + " was cured of Frozen");
        }
        else if (affliction == "PARALYSIS") {
            doToast(gm_data["entities"][entity_id]['name'] + " was cured of Paralysis");
        }
        else if (affliction == "POISONED") {
            modifyCombatStage(entity_id, 'spdef', 2);

            doToast(gm_data["entities"][entity_id]['name'] + " was cured of Poison");
        }
    }
    else {
        // Remove from battle entry
        gm_data["entities"][entity_id]['battle_tags'].push(affliction).splice(array.indexOf(affliction), 1);

        // Toast
        doToast(gm_data["entities"][entity_id]['name'] + " was cured of " + affliction);
    }

    // Update Player client
    sendMessage(connections[entity_id], JSON.stringify({
        "type": "afflict_delete",
        "affliction": affliction
    }));

    if (currentView == 0)
        renderBattler();
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