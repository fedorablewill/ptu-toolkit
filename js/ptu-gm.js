/**
 *  Game Master (GM) Client Functionality
 */

// Imports
$.getScript('js/script.js');
$.getScript('js/ptu-io.js');
$.getScript('js/ptu-battle.js');

function renderCharacterList() {
    fetchPage('char-list', function (html) {
        var list = $(".list-pokemon").html('');
        var json = JSON.parse(html);

        $.each(json, function (i, char) {
            list.append('<div class="char-entry char-owner col-sm-6">'+
                    '<span class="char-name">'+char["name"]+'</span>'+
                    '<div class="btn-group-vertical pull-right">'+
                        '<button onclick="onClickEditCharacter(\''+char['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                        '<button onclick="onClickDeletePokemon(\''+char['id']+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                    '</div>'+
                '</div>');

            $.each(char["owned"], function (i, char2) {
                list.append('<div class="char-entry col-sm-6">'+
                    '<span class="char-name">'+char2["name"]+'</span>'+
                        '<div class="btn-group-vertical pull-right">'+
                            '<button onclick="onClickEditCharacter(\''+char2['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                            '<button onclick="onClickDeletePokemon(\''+char2['id']+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                        '</div>'+
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