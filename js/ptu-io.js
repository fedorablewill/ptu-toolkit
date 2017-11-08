
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