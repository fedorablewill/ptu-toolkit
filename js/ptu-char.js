var CharacterHelper = {
    getEvadeBonus: function (char_id) {
        //TODO implement
        return 0;
    }
};

var AfflictionHelper = {
    hasAffliction: function (id, affliction) {
        //TODO: afflictions
        return false;
    },

    addAffliction: function (affliction, entity_id, value) {

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
    },

    deleteAffliction: function (affliction, entity_id) {

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
    },
    /**
     * Handle the effects of an affliction when triggered
     * @param affliction String affliction name
     * @param monId Id of the Pokemon
     * @return boolean Returns true if allowed to perform an action
     */
    handleAffliction: function (affliction, monId) {
        // Afflictions that take a Tick of Hit Points
        if (affliction == "Burned" || affliction == "Poisoned") {

            // Calculating max_hp
            var max_hp = gm_data["pokemon"][monId]['level'] + gm_data["pokemon"][monId]['hp'] * 3 + 10;

            // Subtract health
            gm_data["pokemon"][monId]["health"] -= Math.floor(max_hp * 0.1);

            // Show message
            if (affliction == "Burned")
                doToast(gm_data["pokemon"][monId]["name"] + " was damaged by their burn");
            else if (affliction == "Poisoned")
                doToast(gm_data["pokemon"][monId]["name"] + " was damaged from poison");

            // Check if fainted
            if (gm_data["pokemon"][monId]["health"] <= 0) {
                doToast(gm_data["pokemon"][monId]["name"] + " fainted!");
                gm_data["pokemon"][monId]["health"] = 0;
            }

            // Update health bar
            var w = Math.floor((gm_data["pokemon"][monId]['health'] / max_hp) * 100);

            $("[data-name='"+monId+"']").find(".progress-bar").css("width", w + "%");

            // Update Player client
            sendMessage(battle[monId]["client_id"], JSON.stringify({
                "type": "health",
                "value": gm_data["pokemon"][monId]['health']
            }));
        }
        // Frozen save check
        else if (affliction == "Frozen") {
            // TODO: weather bonuses (+4 sunny, -2 hail)

            // Save check roll
            var check = roll(1, 20, 1);

            // If rolled higher than 16, or 11 for Fire types, cure of Frozen
            if (check >= 16 || (check >= 11 && (gm_data["pokemon"][monId]["type"] == "Fire" ||
                    $.inArray("Fire", gm_data["pokemon"][monId]["type"].split(" / ")) >= 0))) {

                deleteAffliction("Frozen", monId);

                return true;
            }

            return false;
        }
        // Confused save check
        else if (affliction == "Confused") {
            // Save check roll
            var check_cf = roll(1, 20, 1);

            // If rolled higher than 16, cure of Confusion
            if (check_cf <= 8) {
                doPhysicalStruggle(monId);
                doToast(gm_data["pokemon"][monId]["name"] + " hurt itself in confusion!");

                return false;
            }
            else if (check_cf >= 16)
                deleteAffliction("Confused", monId);
        }

        return true;
    }
};