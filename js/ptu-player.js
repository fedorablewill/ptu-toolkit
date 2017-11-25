/**
 *  Player Client Functionality
 */

// Imports
$.getScript('js/script.js');
$.getScript('js/ptu-io.js');

function createPlayerList() {
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