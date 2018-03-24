var gm_data, battle = {};

var CharacterHelper = {
    fetchCharWithBuffs: function (charId) {
        //TODO implement
        return {};
    },

    getEvadeBonus: function (char_id) {
        //TODO implement
        return 0;
    },

    modifyCombatStage: function (charId, stat, amnt) {
        //TODO implement
    },

    updateCharData: function (charId, data, callback) {
        //TODO implement
    }
};

var CampaignHelper = $.extend(DataHelperBase, (function(){
    $("#uploadAnchor").change(function() {
        {
            if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
                alert('The File APIs are not fully supported in this browser.');
                return;
            }

            input = document.getElementById('uploadAnchor');
            if (!input) {
                alert("Um, couldn't find the fileinput element.");
            }
            else if (!input.files) {
                alert("This browser doesn't seem to support the `files` property of file inputs.");
            }
            else if (!input.files[0]) {
                alert("Please select a file before clicking 'Load'");
            }
            else {
                file = input.files[0];
                fr = new FileReader();
                fr.onload = (function (theFile) {
                    return function (e) {
                        //console.log('e readAsText = ', e);
                        //console.log('e readAsText target = ', e.target);
                        try {
                            json = JSON.parse(e.target.result);
                            gm_data = json;

                            CampaignHelper.onDataLoaded();

                            // Create new entry in the database
                            // if (firebase.auth().currentUser && !firebase.auth().currentUser.isAnonymous)
                            //     $.ajax({
                            //         type: "POST",
                            //         url: "api/v1/campaign/",
                            //         dataType: 'json',
                            //         data: {"name": "Campaign", "data": JSON.stringify(gm_data)},
                            //         async: false,
                            //         beforeSend: function (xhr) {
                            //             xhr.setRequestHeader ("Authorization",
                            //                 "Basic " + btoa(firebase.auth().currentUser.uid+ ":" + f_token));
                            //         },
                            //         success: function (data, status, xhr){
                            //             if (data) {
                            //                 campaignId = data;
                            //             }
                            //         },
                            //         error: function (xhr, status, error) {
                            //             window.alert(status + " " + error);
                            //         }
                            //     });
                        } catch (ex) {
                            alert('ex when trying to parse json = ' + ex);
                        }
                    };
                })(file);
                fr.readAsText(file);
            }
        }
    });

    return {
        /**
         * Creates a new campaign
         */
        createNewCampaign: function () {
            //New blank gm_data object
            gm_data = {characters:{},pokemon:{},settings:{}};

            // Update display
            this.onDataLoaded();
        },

        /**
         * Upload a campaign save
         */
        uploadCampaign: function () {
            // Update display
            var ulAnchorElem = document.getElementById('uploadAnchor');
            ulAnchorElem.click();
        },

        checkData: function (json) {
            // Check if using older data
            if (json.hasOwnProperty("pokemon")) {

            }
        }
    };
})());