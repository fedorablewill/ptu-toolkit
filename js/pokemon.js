/**
 * Scripts for Player Client
 * @author Will Stephenson
 */

/**
 * JSON data of loaded Pokemon
 * @type JSON
 */
var pokemon_data = {}, moves_data = [], battle_data = {};

var client_id = "";


/**
 * JQuery Bindings & Initialization
 */
$(function () {

    // GENERATE CLIENT ID
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < 5; i++ )
        client_id += chars.charAt(Math.floor(Math.random() * chars.length));

    // ON MOVE CLICKED
    $(".btn-move").click(function () {
        var move_name = $(this).find(".move-name").html();
        var target = $("#target").val();
        
        var json = {
            "type": "battle_move",
            "dealer": $("#pokemonId").val(),
            "target": target,
            "move": move_name
        };
        
        sendMessage("host:"+host_id, JSON.stringify(json));
    });

    $("#btn-do-dmg").click(function () {
        sendMessage("host:"+host_id, JSON.stringify({
            "type": "battle_damage",
            "target": $("#pokemonId").val(),
            "moveType": $("#dmg-type").val(),
            "isSpecial": $("#do-dmg-sp").is(':checked'),
            "damage": $("#do-dmg").val()
        }))
    });

    $("#btn-do-heal").click(function () {
        var max_hp = pokemon_data['level'] + pokemon_data['hp'] * 3 + 10;

        pokemon_data["health"] += $("#do-heal").val();

        if (pokemon_data["health"] > max_hp)
            pokemon_data["health"] = max_hp;

        sendMessage("host:"+host_id, JSON.stringify({
            "type": "pokemon_update",
            "pokemon": $("#pokemonId").val(),
            "field": "health",
            "value": pokemon_data["health"]
        }));
    });

    $("#stages").find("input").change(function () {
        sendMessage("host:"+host_id, JSON.stringify({
            "type": "pokemon_setcs",
            "pokemon": $("#pokemonId").val(),
            "field": $(this).attr("data-target"),
            "value": $(this).val()
        }));

        if ($(this).attr("id") == "stage-speed") {
            var s = pokemon_data["speed"] * getStageMultiplier(parseInt($(this).val()));
            $("#speed").html(s);
        }
    });

    $(".progress").click(function () {
        window.alert($(this).attr("data-hp"));
    });
});


// DISPLAY FUNCTIONS

/**
 * Display the imported Pokemon
 */
function displayInit() {
    var display = $("#mon1");

    $(".content-header").find(".name").html(pokemon_data["name"] + ' <small>Level ' + pokemon_data['level'] + '</small>');
    $(".pokemon-image").attr("src", "http://www.ptu.panda-games.net/images/pokemon/"+pokemon_data["dex"]+".png");

    $("#dex-species").html('#' + pokemon_data["dex"] + ' - Species');

    $("#speed").html(pokemon_data["speed"]);

    $.each(moves_data, function (i, move) {

        var movesEntry = display.find(".btn-move-" + (i + 1));

        movesEntry.css("display", "block");

        var title = move["Title"];
        var freq = move["Freq"];
        var type = typeToNum(move["Type"].toLowerCase());
        var desc = move["Effect"];
        var dmgType = move["Class"];

        movesEntry.find(".move-name").html(title);
        movesEntry.find(".move-freq").html(freq);
        movesEntry.find(".move-desc").html(desc);
        movesEntry.find(".img-class").attr("src", "http://www.ptu.panda-games.net/images/types/" + dmgType + ".png");
        movesEntry.find(".img-type").attr("src", "http://www.ptu.panda-games.net/images/types/" + type + ".png");

        //Stylize by Type
        switch (move["Type"]) {
            case "Bug":
                movesEntry.css("background-color", "rgba(158, 173, 30, 0.5)");
                break;
            case "Dark":
                movesEntry.css("background-color", "rgba(99, 78, 64, 0.5)");
                break;
            case "Dragon":
                movesEntry.css("background-color", "rgba(94, 33, 243, 0.5)");
                break;
            case "Electric":
                movesEntry.css("background-color", "rgba(244, 200, 26, 0.5)");
                break;
            case "Fairy":
                movesEntry.css("background-color", "rgba(223, 116, 223, 0.5)");
                break;
            case "Fighting":
                movesEntry.css("background-color", "rgba(179, 44, 37, 0.5)");
                break;
            case "Fire":
                movesEntry.css("background-color", "rgba(232, 118, 36, 0.5)");
                break;
            case "Flying":
                movesEntry.css("background-color", "rgba(156, 136, 218, 0.5)");
                break;
            case "Ghost":
                movesEntry.css("background-color", "rgba(98, 77, 134, 0.5)");
                break;
            case "Grass":
                movesEntry.css("background-color", "rgba(112, 191, 72, 0.5)");
                break;
            case "Ground":
                movesEntry.css("background-color", "rgba(217, 178, 71, 0.5)");
                break;
            case "Ice":
                movesEntry.css("background-color", "rgba(130, 208, 208, 0.5)");
                break;
            case "Normal":
                movesEntry.css("background-color", "rgba(158, 158, 109, 0.5)");
                break;
            case "Poison":
                movesEntry.css("background-color", "rgba(149, 59, 149, 0.5)");
                break;
            case "Psychic":
                movesEntry.css("background-color", "rgba(247, 64, 119, 0.5)");
                break;
            case "Rock":
                movesEntry.css("background-color", "rgba(169, 147, 51, 0.5)");
                break;
            case "Steel":
                movesEntry.css("background-color", "rgba(166, 166, 196, 0.5)");
                break;
            case "Water":
                movesEntry.css("background-color", "rgba(82, 127, 238, 0.5)");
                break;
        }
    });

    display.find(".new-form").css("display", "none");
    display.find(".pokemon-enemy").css("display", "block");

    updateStatus();
}

function updateStatus() {
    var max_hp = pokemon_data['level'] + pokemon_data['hp'] * 3 + 10;

    $(".bar-hp").css("width", Math.floor((parseInt(pokemon_data['health']) / max_hp) * 100) + "%");
    $(".bar-exp").css("width", Math.floor((parseInt(pokemon_data['EXP']) / EXP_CHART[parseInt(pokemon_data['level'])]) * 100) + "%");
}

function updateTargetList() {
    var html = '<option value="other">Other Target</option>';

    $.each(battle_data, function (id, name) {
        html += '<option value="'+id+'">'+name+'</option>';
    });

    $("#target").html(html);
}


// SERVER FUNCTIONS

function onClickConnect() {
    host_id = $("#gm-id").val();

    sendMessage("host:"+host_id, JSON.stringify({
        "type": "pokemon_list",
        "from": client_id
    }));

    onUpdate();
}

function onClickLoadFromSelected() {
    var pmon_id = $("#pokemonId").val();

    sendMessage("host:"+host_id, JSON.stringify({
        "type": "pokemon_get",
        "from": client_id,
        "pokemon_id": pmon_id
    }));
}

function addPokemonToBattle() {

    var message = {
        "type": "battle_add",
        "from": client_id,
        "pokemon": $("#pokemonId").val(),
        "stage_atk": $("#stage-atk").val(),
        "stage_def": $("#stage-def").val(),
        "stage_spatk": $("#stage-spatk").val(),
        "stage_spdef": $("#stage-spdef").val(),
        "stage_speed": $("#stage-speed").val(),
        "stage_acc": $("#stage-acc").val(),
        "stage_eva": $("#stage-eva").val()
    };

    sendMessage("host:"+host_id, JSON.stringify(message));
}

function onUpdate() {

    // Check for incoming requests
    receiveMessages(client_id, function (data) {
        $.each(data, function (message) {
            /*
                Pokemon received
             */
            if (this.type == "pokemon") {
                pokemon_data = this.pokemon;
                fetchMoves();
            }
            /*
                List of Pokemon received
             */
            else if (this.type == "pokemon_list") {
                var html = "";
                $.each(this.pokemon, function (id, pmon) {
                    html += '<option value="'+id+'">'+pmon['name']+'</option>';
                });
                $("#pokemonId").html(html);

                $("#init-select").css("display", "block");
                $("#init-connect").css("display", "none");
            }
            /*
                Pokemon Added to Battle
             */
            else if (this.type == "battle_added") {
                battle_data[this.pokemon_id] = this.pokemon_name;
                updateTargetList();
            }
            /*
                Health changed
             */
            else if (this.type == "health") {
                pokemon_data["health"] = this.value;
                updateStatus();
            }
            /*
                Snackbar Alert Received
             */
            else if (this.type == "alert"){
                doToast(message["content"]);
            }
        });
    });

    // Recursion
    setTimeout(onUpdate, 500);
}

function fetchMoves() {
    $.getJSON("/api/v1/moves/?names="+encodeURIComponent(JSON.stringify(pokemon_data["moves"])), function (json) {
        var i = 0;
        $.each(json, function (name, move) {
            if (name != "") {
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


// MANAGEMENT FUNCTIONS

function setStage (field, attr) {
    var stage = parseInt(field.val());

    var mon = $("#mon1");

    if (stage < -6) {
        stage = -6;
        field.val("-6");
    }
    else if (stage > 6) {
        stage = 6;
        field.val("6");
    }

    if (stage == -6)
        mon.attr(attr, "0.4");
    else if (stage == -5)
        mon.attr(attr, "0.5");
    else if (stage == -4)
        mon.attr(attr, "0.6");
    else if (stage == -3)
        mon.attr(attr, "0.7");
    else if (stage == -2)
        mon.attr(attr, "0.8");
    else if (stage == -1)
        mon.attr(attr, "0.9");
    else if (stage == 0)
        mon.attr(attr, "1.0");
    else if (stage == 1)
        mon.attr(attr, "1.2");
    else if (stage == 2)
        mon.attr(attr, "1.4");
    else if (stage == 3)
        mon.attr(attr, "1.6");
    else if (stage == 4)
        mon.attr(attr, "1.8");
    else if (stage == 5)
        mon.attr(attr, "2.0");
    else if (stage == 6)
        mon.attr(attr, "2.2");
}

function damage(dmg, moveType, isSpecial) {
    moveType = moveType.toLocaleLowerCase();

    var progress = $(".progress");
    var mon = $("#mon1");

    var maxHp = parseInt(progress.attr("data-max-hp"));
    var hp = parseInt(progress.attr("data-hp"));

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

    $.getJSON("/api/v1/types", function(json) {
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

$.getJSON("/api/v1/types", function(json) {
    $.each(json, function (k, v) {
        document.getElementById("dmg-type").innerHTML += "<option>" + k + "</option>";
    })
});

// UTILITY FUNCTIONS

function numToType(num) {
    switch (num) {
        case 1 :
            return "bug";
        case 2 :
            return "dark";
        case 3 :
            return "dragon";
        case 4 :
            return "electric";
        case 5 :
            return "fairy";
        case 6 :
            return "fighting";
        case 7 :
            return "fire";
        case 8 :
            return "flying";
        case 9 :
            return "ghost";
        case 10 :
            return "grass";
        case 11 :
            return "ground";
        case 12 :
            return "ice";
        case 13 :
            return "normal";
        case 14 :
            return "poison";
        case 15 :
            return "psychic";
        case 16 :
            return "rock";
        case 17 :
            return "steel";
        case 18 :
            return "water";
    }
}

function typeToNum(type) {
    switch (type) {
        case "bug":
            return 1;
        case "dark":
            return 2;
        case "dragon":
            return 3;
        case "electric":
            return 4;
        case "fairy":
            return 5;
        case "fighting":
            return 6;
        case "fire":
            return 7;
        case "flying":
            return 8;
        case "ghost":
            return 9;
        case "grass":
            return 10;
        case "ground":
            return 11;
        case "ice":
            return 12;
        case "normal":
            return 13;
        case "poison":
            return 14;
        case "psychic":
            return 15;
        case "rock":
            return 16;
        case "steel":
            return 17;
        case "water":
            return 18;
    }
}