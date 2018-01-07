/**
 * Universal scripts for Pokemon Manager/Battler
 * @author Will Stephenson
 */

var host_id = null;
var client_id = "";
var campaign_id = 34;

var peer = new Peer({key: '0ecbb01z4hkc5wmi', debug: 3});

var EXP_CHART = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90,
110, 135, 160, 190, 220, 250, 285, 320, 260, 400,
    460, 530, 600, 670, 745, 820, 900, 990, 1075, 1165,
1260, 1355, 1455, 1555, 1660, 1770, 1880, 1995, 2110, 2230,
2355, 2480, 2610, 2740, 2875, 3015, 3155, 3300, 3445, 3645,
3850, 4060, 4270, 4485, 4705, 4930, 5160, 5390, 5625, 5865,
6110, 6360, 6610, 6868, 7125, 7390, 7660, 7925, 8205, 8485,
8770, 9060]; //TODO: finish exp chart

peer.on('open', function(id){
    client_id = id;
});

peer.on('error', function(err) {
    console.log(err);
});

$(function () {
    $.material.init();
    $('[data-toggle="tooltip"]').tooltip();
});

function receiveMessages(connection, callback) {
    connection.on('data', function(data) {
        callback(connection, data);
    });
}

function sendMessage(to, message) {

    var c = peer.connections[to][0];

    if (peer.disconnected)
        peer.reconnect();

    if (c !== null && !c.open) {
        if (peer.connections[to].length > 1){
            for (var i=0; i < peer.connections[to].length; i++) {
                if (!peer.connections[to][i].open)
                    peer.connections[to].splice(i, 1);
                else
                    c = peer.connections[to][i];
            }
        }

        if (!c.open) {
            doToast("Connection to peer lost. Attempting to communicate");

            c = null;

            var connect = peer.connect(to, {
                label: 'chat',
                serialization: 'none',
                metadata: {message: 'connect to host'}
            });
            connect.on('open', function () {
                doToast("Connection to peer found");
                connect.send(message);
            });
            connect.on('error', function (err) {
                alert(err);
            });
        }
    }

    if (c !== null)
        c.send(message);
}

function sendMessageToAll(message) {
    $.each(peer.connections, function (k, v) {
        for (var i=0; i < v.length; i++)
            v[i].send(message);
    });
}

function rollDamageBase(base, rollMultiplier) {
    var damage = 0;
    switch (base) {
        case 1:
            return roll(1*rollMultiplier, 6, 1) + 1*rollMultiplier;
        case 2:
            return roll(1*rollMultiplier, 6, 1) + 3*rollMultiplier;
        case 3:
            return roll(1*rollMultiplier, 6, 1) + 5*rollMultiplier;
        case 4:
            return roll(1*rollMultiplier, 8, 1) + 6*rollMultiplier;
        case 5:
            return roll(1*rollMultiplier, 8, 1) + 8*rollMultiplier;
        case 6:
            return roll(2*rollMultiplier, 6, 1) + 8*rollMultiplier;
        case 7:
            return roll(2*rollMultiplier, 6, 1) + 10*rollMultiplier;
        case 8:
            return roll(2*rollMultiplier, 8, 1) + 10*rollMultiplier;
        case 9:
            return roll(2*rollMultiplier, 10, 1) + 10*rollMultiplier;
        case 10:
            return roll(3*rollMultiplier, 8, 1) + 10*rollMultiplier;
        case 11:
            return roll(3*rollMultiplier, 10, 1) + 10*rollMultiplier;
        case 12:
            return roll(3*rollMultiplier, 12, 1) + 10*rollMultiplier;
        case 13:
            return roll(4*rollMultiplier, 10, 1) + 10*rollMultiplier;
        case 14:
            return roll(4*rollMultiplier, 10, 1) + 15*rollMultiplier;
        case 15:
            return roll(4*rollMultiplier, 10, 1) + 20*rollMultiplier;
        case 16:
            return roll(5*rollMultiplier, 10, 1) + 20*rollMultiplier;
        case 17:
            return roll(5*rollMultiplier, 12, 1) + 25*rollMultiplier;
        case 18:
            return roll(6*rollMultiplier, 12, 1) + 25*rollMultiplier;
        case 19:
            return roll(6*rollMultiplier, 12, 1) + 30*rollMultiplier;
        case 20:
            return roll(6*rollMultiplier, 12, 1) + 35*rollMultiplier;
        case 21:
            return roll(6*rollMultiplier, 12, 1) + 40*rollMultiplier;
        case 22:
            return roll(6*rollMultiplier, 12, 1) + 45*rollMultiplier;
        case 23:
            return roll(6*rollMultiplier, 12, 1) + 50*rollMultiplier;
        case 24:
            return roll(6*rollMultiplier, 12, 1) + 55*rollMultiplier;
        case 25:
            return roll(6*rollMultiplier, 12, 1) + 60*rollMultiplier;
        case 26:
            return roll(7*rollMultiplier, 12, 1) + 65*rollMultiplier;
        case 27:
            return roll(8*rollMultiplier, 12, 1) + 70*rollMultiplier;
        case 28:
            return roll(8*rollMultiplier, 12, 1) + 80*rollMultiplier;
        default:
            return 0;
    }
}

function roll(num, die, multiplier) {
    var r = 0;

    for (var i=0; i<num; i++) {
        r += Math.floor(Math.random() * (die + 1)) * multiplier;
    }

    console.log("rolled " + r + " on d" + die);

    return r;
}

function getStageMultiplier(stage) {
    switch (stage) {
        case -6: return 0.4;
        case -5: return 0.5;
        case -4: return 0.6;
        case -3: return 0.7;
        case -2: return 0.8;
        case -1: return 0.9;
        case 0: return 1;
        case 1: return 1.2;
        case 2: return 1.4;
        case 3: return 1.6;
        case 4: return 1.8;
        case 5: return 2;
        case 6: return 2.2;
        default: return 1;
    }
}

function doToast(content) {

    var options =  {
        content: content, // text of the snackbar
        style: "snackbar", // add a custom class to your snackbar
        timeout: 6000 // time in milliseconds after the snackbar autohides, 0 is disabled
    };

    $.snackbar(options);
}

/**
 * Autopopulate attributed fields with data
 */
$(function () {

    if ($("[data-populate='type']").length > 0){
        $.getJSON("api/v1/types", function (json) {
            var html = "";
            $.each(json, function (k, v) {
                html += "<option>" + k.charAt(0).toUpperCase() + k.slice(1) + "</option>";
            });

            $("select[data-populate='type']").each(function () {
                $(this).html($(this).html() + html);
                $(this).removeAttr("data-populate");
            });
        });
    }

    if ($("[data-populate='nature']").length > 0){
        $.getJSON("api/v1/natures", function (json) {
            var html = "";
            $.each(json, function (k, v) {
                html += "<option>" + k + "</option>";
            });

            $("select[data-populate='nature']").each(function () {
                $(this).html($(this).html() + html);
                $(this).removeAttr("data-populate");
            });
        });
    }

    if ($("[data-populate='move']").length > 0){
        $.getJSON("api/v1/moves", function (json) {
            var html = "";
            $.each(json, function (k, v) {
                html += "<option>" + k + "</option>";
            });

            $("select[data-populate='move']").each(function () {
                $(this).html($(this).html() + html);
                $(this).removeAttr("data-populate");
            });
        });
    }

    if ($("[data-populate='ability']").length > 0){
        $.getJSON("api/v1/abilities", function (json) {
            var html = "";
            $.each(json, function (k, v) {
                html += "<option>" + k + "</option>";
            });

            $("select[data-populate='ability']").each(function () {
                $(this).html($(this).html() + html);
                $(this).removeAttr("data-populate");
            });
        });
    }

    if ($("[data-populate='dex']").length > 0)
        fetchPokemon(0, 50);
});

var mon_list = [];

function fetchPokemon(offset, size) {
    $.getJSON("api/v1/pokemon/?offset=" + offset + "&size=" + size, function(json) {
        if ($.isEmptyObject(json)) {
            $("[data-populate='dex']").autocomplete({
                source: mon_list
            }).focus(function() {
                var val = $(this).val() === "" ? " " : $(this).val();
                $(this).autocomplete('search', val);
            });
        }
        else {
            $.each(json, function (k, v) {
                mon_list.push({
                    label: k + " - " + v["Species"],
                    value: k
                });
            });
            fetchPokemon(offset + size, size);
        }
    });
}

function typeColor(type) {
    var color = "#000";

    switch (type.toLowerCase()) {
        case "bug":
            color = "rgb(158, 173, 30)";
            break;
        case "dark":
            color = "rgb(99, 78, 64)";
            break;
        case "dragon":
            color = "rgb(94, 33, 243)";
            break;
        case "electric":
            color = "rgb(244, 200, 26)";
            break;
        case "fairy":
            color = "rgb(223, 116, 223)";
            break;
        case "fighting":
            color = "rgb(179, 44, 37)";
            break;
        case "fire":
            color = "rgb(232, 118, 36)";
            break;
        case "flying":
            color = "rgb(156, 136, 218,)";
            break;
        case "ghost":
            color = "rgb(98, 77, 134)";
            break;
        case "grass":
            color = "rgb(112, 191, 72)";
            break;
        case "ground":
            color = "rgb(217, 178, 71)";
            break;
        case "ice":
            color = "rgb(130, 208, 208)";
            break;
        case "normal":
            color = "rgb(158, 158, 109)";
            break;
        case "poison":
            color = "rgb(149, 59, 149)";
            break;
        case "psychic":
            color = "rgb(247, 64, 119)";
            break;
        case "rock":
            color = "rgb(169, 147, 51)";
            break;
        case "steel":
            color = "rgb(166, 166, 196)";
            break;
        case "water":
            color = "rgb(82, 127, 238)";
            break;
    }
    return color;
}
