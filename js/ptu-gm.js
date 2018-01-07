/**
 *  Game Master (GM) Client Functionality
 */

// Imports
$.getScript('js/script.js');
$.getScript('js/ptu-io.js');
$.getScript('js/ptu-char.js');
$.getScript('js/ptu-battle.js');

function readMessage(connection, data) {

    var json = JSON.parse(data);

    /*
         Snackbar Alert Received
         */
    if (json.type == "alert"){
        doToast(json["content"]);
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

function doMoveDialog(dealer, move_name, move_json) {
    if (currentView !== 0)
        doToast(dealer["Name"] + " used " + move_name + "!");

    var html = '<img src="img/pokemon/' + dealer["PokedexNo"] + '.gif" />' +
        '<div class="battle-dialog">' +
        '<p>' + dealer["Name"] + ' used <span style="color:' + typeColor(move_json["Type"]) + '">' + move_name + '</span></p>' +
        '</div>';

    $("#battle-message").html(html);
}

function renderCharacterList() {
    $.getJSON('api/v1/data/character/list', {"campaign_id": 34}, function (json) {
        var list = $(".list-pokemon").html('');

        $.each(json, function (i, char) {
            var img = '<img class="img-circle pull-left bg-danger" height="60px" width="60px" />';

            if (char['type'] === "POKEMON")
                img = '<img src="img/pokemon-profiles/' + char['dex'] + '.png" class="img-circle pull-left bg-danger" height="60px" width="60px" />';

            list.append('<div class="char-entry char-owner col-sm-6">'+ img +
                '<div class="btn-group-vertical pull-right">'+
                    '<button onclick="onClickEditCharacter(\''+char['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                    '<button onclick="onClickDeletePokemon(\''+char['id']+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                '</div>'+
                    '<span class="char-name">'+char["name"]+'</span>'+
                '</div>');

            $.each(char["owned"], function (i, char2) {

                var img = '<img class="img-circle pull-left bg-danger" height="60px" width="60px" />';

                if (char2['type'] === "POKEMON")
                    img = '<img src="img/pokemon-profiles/' + char2['dex'] + '.png" class="img-circle pull-left bg-danger" height="60px" width="60px" />';

                list.append('<div class="char-entry col-sm-6">'+ img +
                    '<div class="btn-group-vertical pull-right">'+
                        '<button onclick="onClickEditCharacter(\''+char2['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                        '<button onclick="onClickDeletePokemon(\''+char2['id']+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                    '</div>'+
                    '<span class="char-name">'+char2["name"]+'</span>'+
                    '</div>');
            });

            list.append('<hr/>');
        });
    });
}

//TODO: depricate
function renderPokemonList() {
    renderCharacterList();
}

function onClickEditCharacter(char_id) {
    createCharacterEditor(char_id, "#tab-char-io");
    changeView(1, true);

    $('a[href="#tab-char-io"]').tab('show');
}

function changeView(index, suppressRender) {
    currentView = index;

    if (index === 0) {
        $("#body-battle").removeClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").addClass("hidden");

        if (!suppressRender)
            renderBattler();
    }
    else if (index === 1) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").removeClass("hidden");
        $("#body-settings").addClass("hidden");

        if (!suppressRender)
            renderPokemonList();
    }
    else if (index === 2) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").removeClass("hidden");
    }
}

//TODO: depricate
function changeGMView(index) {
    changeView(index);
}