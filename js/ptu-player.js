/**
 *  Player Client Functionality
 */

// Imports
$.getScript('js/script.js');
$.getScript('js/ptu-io.js');

function onClickConnect() {
    debugger;
    host_id = $("#gm-id").val();

    if (peer.connections[host_id] != null) {
        for (var i = 0; i < peer.connections[host_id].length; i++) {
            peer.connections[host_id][i].close();
            peer.connections[host_id].splice(i, 1);
        }
    }

    connection = peer.connect(host_id, {
        label: 'chat',
        serialization: 'none',
        metadata: {message: 'connect to host'}
    });

    connection.on('open', function () {
        receiveMessages(connection, readMessage);

        // Connection established - make appropriate calls

        if ($.isEmptyObject(character_data)) {
            createCharacterList();

            $("#init-select").css("display", "block");
            $("#init-connect").css("display", "none");
        } else {
            connection.send(JSON.stringify({
                "type": "reconnect",
                "character": character_data["ID"]
            }));
        }
    });
    connection.on('error', function (err) {
        alert(err);
    });
}

function readMessage(connection, data) {
    var json = JSON.parse(data);

    /*
     Pokemon received
     */
    if (json.type == "pokemon") {
        character_data = json.pokemon;
        fetchMoves();
    }
    /*
     Pokemon Added to Battle
     */
    else if (json.type == "battle_added") {
        battle_data[json.pokemon_id] = json.pokemon_name;
        updateTargetList();

        // Show target list
        $("#modalTarget-join").addClass("hidden");
        $("#modalTarget-select").removeClass("hidden");
    }
    /*
     Battle ended
     */
    else if (json.type == "battle_end") {
        // Hide target list
        $("#modalTarget-join").removeClass("hidden");
        $("#modalTarget-select").addClass("hidden");
    }
    /*
     Grid returned
     */
    else if (json.type == "battle_grid") {
        $(".battle-grid").html(json.html);
        onTargetGridLoaded();
    }
    /*
     Health changed
     */
    else if (json.type == "health") {
        character_data["health"] = json.value;
        updateStatus();
    }
    /*
     Battle data changed
     */
    else if (json.type == "data_changed") {
        if (json.field == "affliction") {
            afflictions = json.value;
            updateAfflictions();
        }
        else {
            $("#" + json.field).val(json.value);
        }
    }
    /*
     Add affliction
     */
    else if (json.type == "afflict_add") {
        // Check if affliction is already on Pokemon
        if ($.inArray(json.affliction) < 0) {
            afflictions.push(json.affliction);
            updateAfflictions();
        }
    }
    /*
     Remove affliction
     */
    else if (json.type == "afflict_delete") {
        // Check if affliction is on Pokemon
        if ($.inArray(json.affliction) >= 0) {
            afflictions.splice(array.indexOf(json.affliction), 1);
            updateAfflictions();
        }
    }
    /*
     Snackbar Alert Received
     */
    else if (json.type == "alert") {
        doToast(message["content"]);
    }

}

function createCharacterList() {
    fetchPage('char-list', function (html) {
        html = '<h2>Select Character</h2>' + html;

        $('#init-select').html(html);

        $('<button class="btn btn-xs btn-danger btn-simple">SELECT</button>').click(onClickLoadFromSelected).prependTo(".char-list .char-item");
    });
}

function onClickLoadFromSelected() {
    var char_id = $(this).parent().attr("data-id");

    fetchCharacterById(char_id, function (data) {
        character_data = data;

        fetchMoves();
    });
}

function fetchMoves() {
    var char_id = character_data['CharacterId'];
    
    fetchCharacterMoves(char_id, function (json) {
        var i = 0;
        $.each(json, function (name, move) {
            if (name !== "") {
                move["Title"] = name;

                moves_data[i] = move;
            }

            i++;
        });

        displayInit();

        $(".content-init").css("display", "none");
        $(".content-main").css("display", "block");
    });
}

function addPokemonToBattle() { //TODO deprecate
    onClickJoinBattle();
}

function onClickJoinBattle() {
    var message = {
        "type": "battle_add",
        "from": client_id,
        "character_id": character_id,
        "stage_atk": $("#stage-atk").val(),
        "stage_def": $("#stage-def").val(),
        "stage_spatk": $("#stage-spatk").val(),
        "stage_spdef": $("#stage-spdef").val(),
        "stage_speed": $("#stage-speed").val(),
        "stage_acc": $("#stage-acc").val(),
        "stage_eva": $("#stage-eva").val()
    };

    sendMessage(host_id, JSON.stringify(message));
}