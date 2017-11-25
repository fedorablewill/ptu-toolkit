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
                        '<button onclick="onClickEditPokemon(\''+char['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
                        '<button onclick="onClickDeletePokemon(\''+char['id']+'\')" class="btn btn-danger btn-xs"><i class="material-icons">delete</i></button>'+
                    '</div>'+
                '</div>');

            $.each(char["owned"], function (i, char2) {
                list.append('<div class="char-entry col-sm-6">'+
                    '<span class="char-name">'+char2["name"]+'</span>'+
                        '<div class="btn-group-vertical pull-right">'+
                            '<button onclick="onClickEditPokemon(\''+char2['id']+'\')" class="btn btn-info btn-xs"><i class="material-icons">edit</i></button>'+
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

function onClickEditPokemon(char_id) {
    createCharacterEditor(char_id);
}