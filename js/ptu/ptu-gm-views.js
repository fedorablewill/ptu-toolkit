
var BattlerView = {
    /**
     * Render the Battler View
     */
    render: function () {
        if (currentView === 0) {

            var elems = [], html = '';

            // If no one is in battle
            if ($.isEmptyObject(battle)) {
                html = '<h3 class="text-muted">No one\'s here yet 😟</h3>' +
                    '<h4 class="text-muted">Send your <a data-toggle="modal" data-target="#modalShare">customized link</a> to your players. ' +
                    'Then, have them hit "Join Battle" when they\'re ready.</h4>';
            }
            else {

                // Create health bars

                $.each(battle, function (id, data) {
                    var max_hp = gm_data["pokemon"][id]['level'] + gm_data["pokemon"][id]['hp'] * 3 + 10;
                    var health_pcent = Math.floor((gm_data["pokemon"][id]['health'] / max_hp) * 100);
                    var injuries = gm_data["pokemon"][id]['injuries'];

                    if (health_pcent > 100)
                        console.log("Warning: Pokemon with ID " + id + " has hit points above its max: " +
                            gm_data["pokemon"][id]['health'] + "/" + max_hp);

                    // Gather afflictions
                    var afflictions = "";

                    if (gm_data["pokemon"][id]['afflictions'] != null)
                        $.each(gm_data["pokemon"][id]['afflictions'], function (k, a) {
                            afflictions += ' <span class="label label-danger">' + a + '</span>';
                        });

                    if (data['afflictions'] != null)
                        $.each(data['afflictions'], function (a, v) {
                            afflictions += ' <span class="label label-danger">' + a + '</span>';
                        });

                    // Generate HTML Elements in order of initiative

                    var i = 0, speed = gm_data["pokemon"][id]['speed'] * getStageMultiplier(battle[id]["stage_speed"]);

                    while (i < elems.length) {
                        if (speed > elems[i]["speed"])
                            break;
                        i++;
                    }

                    // Generate HTML
                    elems.splice(i, 0, {'html': '<div class="col-md-6 col-md-offset-3 pokemon" data-name="' + id + '">' +
                        '<h2 class="name">' + gm_data["pokemon"][id]["name"] + afflictions + '</h2>' +
                        '<div class="progress" data-hp="' + gm_data["pokemon"][id]["hp"] + '" data-max-hp="' + gm_data["pokemon"][id]["max_hp"] + '">' +
                        '<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="' + health_pcent + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + health_pcent + '%;"></div>' +
                        '<div class="progress-bar progress-bar-injuries pull-right" role="progressbar" aria-valuenow="' + injuries + '0" aria-valuemin="0" aria-valuemax="100" style="width: ' + injuries + '0%;"></div>' +
                        '</div>' +
                        '</div>',
                        'speed': speed});
                });

                $.each(elems, function (k, e) {
                    html += e['html'];
                });

                html += '<br/><button class="btn btn-danger btn-raised" onclick="endBattle()">End Battle</button>';
            }

            //$("#view-holder").html(html);
            $("#tab-battle-list").html(html);
        }
    },
    /**
     * Creates new dealer
     * @param {Object} dealer
     * @param {string} move_name
     * @param {Object} move_json
     */
    createMoveDialog: function (dealer, move_name, move_json) {
        if (currentView !== 0)
            doToast(dealer["Name"] + " used " + move_name + "!");

        var html = '<img src="img/pokemon/' + dealer["PokedexNo"] + '.gif" />' +
            '<div class="battle-dialog">' +
            '<p>' + dealer["Name"] + ' used <span style="color:' + typeColor(move_json["Type"]) + '">' + move_name + '</span></p>' +
            '</div>';

        $("#battle-message").html(html);
    },

    /**
     * Adds a line to the Move Dialog
     * @param html
     */
    addMoveDialogInfo: function (html) {
        $(".battle-dialog").append('<p>' + '<strong>&gt;</strong> ' + html + '</p>');
    }
};

var CharacterView = {
    renderCharacterList: function () {
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
    },
    onClickEditCharacter: function (char_id) {
        createCharacterEditor(char_id, "#tab-char-io");
        changeView(1, true);

        $('a[href="#tab-char-io"]').tab('show');
    }
};