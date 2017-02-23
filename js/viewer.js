function loadBattle() {
    var battleId = $("#battle-id").val();

    $.getJSON("battles/list.php?id=" + battleId, function (json) {
        var html = '';

        $.each(json, function (k, v) {
            var w = Math.floor((hp / maxHp) * 100);

            html += '<div class="col-md-6 col-md-offset-3 pokemon" data-name="'+v["name"]+'">' +
                '<h2 class="name">'+v["name"]+'</h2>' +
                '<div class="progress" data-hp="'+v["hp"]+'" data-max-hp="'+v["maxhp"]+'">' +
                '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'+w+'" aria-valuemin="0" aria-valuemax="100" style="width: '+w+'%;"></div>' +
                '</div>' +
                '</div>';
        });

        $("#view-holder").html(html);

        onUpdate();
    });
}

function onUpdate() {
    var battleId = $("#battle-id").val();

    $.getJSON("battles/list.php?id=" + battleId, function (json) {
        $.each(json, function (k, v) {
            var health = $("[data-name='" + v["name"].replace("'", "\'") + "']").find(".progress");

            var hp = v["hp"];
            var maxHp = v["maxhp"];

            if (hp != "change" && health.attr("data-hp") != hp) {
                health.attr("data-hp", hp);
                health.find(".progress-bar").css("width", Math.floor((hp / maxHp) * 100) + "%");
            }
        });

        setTimeout(onUpdate, 500);
    });
}