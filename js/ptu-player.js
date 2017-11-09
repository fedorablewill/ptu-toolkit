
function onClickLoadFromSelected() {
    var pmon_id = $("#pokemonId").val();

    pokemon_data = getCharacterById(pmon_id);

    fetchMoves();
}