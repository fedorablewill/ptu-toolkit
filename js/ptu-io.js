
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