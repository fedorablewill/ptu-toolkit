function addPokemonToBattle() {
    var pokemon = $("#mon1");
    var health = pokemon.find(".progress");

    var url = "api/battles/add.php?id=" + $("#battle-id").val() +
            "&name=" + pokemon.find(".name").html() +
            "&hp=" + health.attr("data-hp") +
            "&maxhp=" + health.attr("data-max-hp");

    $.get(url, function (data) {
        window.alert(data);

        update();
    });
}

function update() {
    var battleid = $("#battle-id").val();
    var url = "api/battles/get.php?id=" + battleid +
        "&name=" + $(".name").html();

    var health = $(".progress");

    $.get(url, function (data) {
        if (data != "error") {
            var json = JSON.parse(data);

            if (health.attr("data-hp") != json["hp"])
                damage(parseInt(json["damage"]), json["dmgType"], json["special"] == "true");
        }

        setTimeout(update, 500);
    });

    $.getJSON("api/battles/list.php?id=" + battleid, function (json) {
        var html = '<option value="other">Other Target</option>';

        $.each(json, function (k, v) {
            html += "<option>" + v["name"] + "</option>";
        });

        var select = $("#target");

        if (select.html() != html)
            select.html(html);
    });
}

function sendUpdate(key, value) {
    var pokemon = $("#mon1");
    var health = pokemon.find(".progress");

    var url = "api/battles/update.php?id=" + $("#battle-id").val() +
        "&name=" + pokemon.find(".name").html() +
        "&field=" + key +
        "&value=" + value;

    $.get(url);
}

function listPokemon() {
    var url = "api/battles/list.php?id=" + $("#battle-id").val();

    $.get(url, function (data) {
        var json = JSON.parse(data);
    });
}

function attackPokemon(name, damage, type, special) {
    var url = "api/battles/attack.php?id=" + $("#battle-id").val() +
        "&name=" + name +
        "&damage=" + damage +
        "&type=" + type +
        "&special=" + special;

    $.get(url);
}