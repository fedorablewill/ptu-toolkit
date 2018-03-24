var CharacterHelper = {
    fetchCharWithBuffs: function (charId) {
        var char = getJSONNonAsync("api/v1/data/character/" + charId, {"buffs": true});

        $.each(char["Buffs"], function (k, v) {
            // TODO prereqs
            if (v.type === "CS" && !v.prereq) {
                var multiplier = getStageMultiplier(parseInt(v.value));

                switch (v.target_stat) {
                    case "HP":
                        char["Hp"] = Math.round(char["Hp"] * multiplier);
                        break;
                    case "ATK":
                        char["Atk"] = Math.round(char["Atk"] * multiplier);
                        break;
                    case "DEF":
                        char["Def"] = Math.round(char["Def"] * multiplier);
                        break;
                    case "SDEF":
                    case "SPDEF":
                        char["Sdef"] = Math.round(char["Sdef"] * multiplier);
                        break;
                    case "SATK":
                    case "SPATK":
                        char["Satk"] = Math.round(char["Satk"] * multiplier);
                        break;
                    case "SPD":
                    case "SPEED":
                        char["Spd"] = Math.round(char["Spd"] * multiplier);
                        break;
                }
            }
        });

        return char;
    },

    getEvadeBonus: function (char_id) {
        //TODO implement
        return 0;
    },

    modifyCombatStage: function (charId, stat, amnt) {
        if (DBG_MODE === 2) {
            console.log("skipping CS modify for charId " + charId);
            console.log("stat " + stat + " amnt " + amnt);
        }
        else {
            $.post("api/v1/data/character/cs", {
                "character_id": charId,
                "stat": stat,
                "value": amnt
            }, function (response) {
                if ($.isNumeric(response)) {
                    // Notify client
                    // sendMessage(battle[charId]['client_id'], JSON.stringify({ TODO
                    //     "type": "data_changed",
                    //     "field": "stage-" + stat,
                    //     "value": parseInt(response)
                    // }));
                }
            });
        }
    },

    updateCharData: function (charId, data, callback) {
        if (DBG_MODE === 2) {
            console.log("skipping save for charId " + charId);
            console.log(data);

            if (callback) callback();
        }
        else {
            $.post("api/v1/data/character/" + charId, data, function (response) {
                if (response === "1" && callback)
                    callback();
                else alert(response);
            }).fail(function (e) {
                alert(e);
            });
        }
    }
};

var CampaignHelper = $.extend(DataHelperBase, (function(){
    return {
        /**
         * Creates a new campaign
         */
        createNewCampaign: function () {
            // Create new entry in the database
            if (firebase.auth().currentUser && !firebase.auth().currentUser.isAnonymous)
                $.ajax({
                    type: "POST",
                    url: "api/v1/campaign/",
                    dataType: 'json',
                    data: {"name": "Campaign"},
                    async: false,
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader ("Authorization", "Basic " + btoa(firebase.auth().currentUser.uid+ ":" + f_token));
                    },
                    success: function (data, status, xhr){
                        if (data) {
                            campaignId = data;
                            this.onDataLoaded();
                        }
                    },
                    error: function (xhr, status, error) {
                        window.alert(status + " " + error);
                    }
                });
        },

        /**
         * Fetches campaign from database by id
         * @param id
         */
        fetchCampaign: function (id) {
            $.ajax({
                type: "GET",
                url: "api/v1/campaign/?id=" + id,
                dataType: 'json',
                async: false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa(firebase.auth().currentUser.uid+ ":" + f_token));
                },
                success: function (data, status, xhr){
                    if (data) {
                        gm_data = JSON.parse(data['campaign_data']);
                        campaignId = id;
                        this.onDataLoaded();
                    }
                },
                error: function (xhr, status, error) {
                    window.alert(status + " " + error);
                }
            });
        }
    };
})());