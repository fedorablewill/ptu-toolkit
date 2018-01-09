
// TODO: move Firebase logic here
// TODO: move PeerJS logic here
// TODO: move Data Management functions here

function saveGM() {
    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(gm_data));
    var dlAnchorElem = document.getElementById('downloadAnchor');
    dlAnchorElem.setAttribute("href",     dataStr     );
    dlAnchorElem.setAttribute("download", "GMData.json");
    dlAnchorElem.click();

    // If signed-in, save to database
    if (firebase.auth().currentUser) {

    }
}

function fetchCharacterById(characterId, callback) {
    $.getJSON("api/v1/data/character/" + characterId, callback)
}

function fetchCharactersByCampaignId(campaignId, callback) {
    $.getJSON("api/v1/data/character/list/?campaign_id=" + campaignId, callback)
}

function fetchCharacterMoves(characterId, callback) {
    $.getJSON("/api/v1/data/character/moves/?character_id=" + characterId, callback)
}

function fetchPage(pageName, callback) {
    $.get("/pages/" + pageName + ".php", callback)
}

function createCharacterEditor(character_id, parent) {
    $.get("/pages/char-edit.php", {"id": character_id}, function (html) {
        var parent_elem = $(parent);

        parent_elem.html(html);
    });
}

function getJSONNonAsync(url) {
    var result;
    $.ajax({
        type:'GET',
        url:url,
        dataType:'json',
        async:false,
        success:function(data){
            result = data;
        }
    });
    return result;
}

function getJSONNonAsync(url, data) {
    var result;
    $.ajax({
        type:'GET',
        url:url,
        dataType:'json',
        async:false,
        data: data,
        success:function(data){
            result = data;
        }
    });
    return result;
}