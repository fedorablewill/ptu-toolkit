var connectionMap = {};

/**
 * Receives commands/messages
 */
peer.on('connection', function (c) {

    c.on('open', function () {
        receiveMessages(c, GMPeer.readMessage);

        c.send(JSON.stringify({
            "type": "pokemon_list",
            "pokemon": gm_data["pokemon"]
        }));
    });

});

/**
 * PeerJS Implementation for GM Client
 * @class
 * @name GMPeer
 */
var GMPeer = (function(){
    return {
        /**
         * Reconnects. It's genius.
         */
        reconnect: function() {
            peer.reconnect();
        },

        /**
         * Takes data received from a connection and executes commands
         * @param {RTCPeerConnection} connection
         * @param {Object} data
         */
        readMessage: function(connection, data) {

            var json = JSON.parse(data);

            /*
                 Snackbar Alert Received
                 */
            if (json.type === "alert"){
                doToast(json["content"]);
            }
            /*
             Send Pokemon Data
             */
            else if (json.type == "pokemon_get") {
                var msg = {
                    "type": "pokemon",
                    "pokemon": gm_data["pokemon"][json.pokemon_id]
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
            else if (json.type === "battle_add") {

                $.post("api/v1/battle/join", {"character_id": json.character_id}, function (result) {
                    if (result === "false") {
                        connection.send({
                            "type": "alert",
                            "content": "Already in battle"
                        })
                    }
                    else {
                        alert(result);
                    }
                    // sendMessageToAll(JSON.stringify({
                    //     "type": "battle_added",
                    //     "list": TODO
                    // }));
                });

                // Record peer id
                connections[json.character_id] = json.from;

                // Add as "In Battle"
                in_battle.push(json.character_id);

                connection.send(JSON.stringify({
                    "type": "battle_added",
                    "pokemon_id": json.character_id
                }));

                // TODO: If has persistent affliction, update data appropriately

                // Display Message
                doToast(gm_data["entities"][json.pokemon]["name"] + " Appears!");

                BattlerView.render();
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
                AfflictionHelper.addAffliction(json.affliction, json.pokemon, json['value']);
            }
            /*
             Remove an affliction
             */
            else if (json.type == "pokemon_afflict_delete") {
                AfflictionHelper.deleteAffliction(json.affliction, json.pokemon);
            }
            /*
             Trigger an affliction's handler
             */
            else if (json.type == "pokemon_afflict_trigger") {
                AfflictionHelper.handleAffliction(json.affliction, json.pokemon);
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
                ActionImpl.performMove(json.move, json.target, json.dealer, json.bonus_acc, json.bonus_dmg);
            }
            /*
             Manual Damage Received
             */
            else if (json.type == "battle_damage") {
                var target = $.get("api/v1/data/character/" + json.target);
                ActionImpl.damageCharacter(target, json.moveType, json.isSpecial, json.damage);
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
    };
})();