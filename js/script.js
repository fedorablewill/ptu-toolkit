/**
 * Universal scripts for Pokemon Manager/Battler
 * @author Will Stephenson
 */

var host_id = null;

var EXP_CHART = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90,
110, 135, 160, 190, 220, 250, 285, 320, 260, 400,
    460, 530, 600, 670, 745, 820, 900, 990, 1075, 1165,
1260, 1355, 1455, 1555, 1660, 1770, 1880, 1995, 2110, 2230,
2355, 2480, 2610, 2740, 2875, 3015, 3155, 3300, 3445, 3645,
3850, 4060, 4270, 4485, 4705, 4930, 5160, 5390, 5625, 5865,
6110, 6360, 6610, 6868, 7125, 7390, 7660, 7925, 8205, 8485,
8770, 9060]; //TODO: finish exp chart

$(function () {
    $.material.init();
    $('[data-toggle="tooltip"]').tooltip();
});

function receiveMessages(name, callback) {
    if (host_id != null) {
        $.getJSON("api/message/?id=" + host_id + "&name=" + name, callback);
    }
}

function sendMessage(to, message) {
    if (host_id != null) {
        $.ajax({
            url: "/api/message/",
            type:"post",
            async: false,
            data: {
                "id": host_id,
                "to": to,
                "msg": message
            },
            success: function(response){
            },
            error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ?????? ??????? ????","fail");}
        });
    }
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
