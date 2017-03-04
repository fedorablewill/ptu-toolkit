var ptuApiData = {
    pokemon: {
        url: "pokemon/",
        verbs: ["1", "bulbasaur"],
        requestData: {},
        urlDescription: ["pokemon/pokedexId", "pokemon/pokemonName", "pokemon/?offset=20&size=5"]
    },
    types: {
        url: "types/",
        verbs: ["electric/water", "fire"],
        requestData: {},
        urlDescription: ["types", "types/attackType", "types/attackType/defendType"]
    },
    moves: {
        url: "moves/",
        verbs: ["pound", "horn drill"],
        requestData: {},
        urlDescription: ["moves", "moves/name", "moves/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
    abilities: {
        url: "abilities/",
        verbs: ["Sequence", "Bad Dreams"],
        requestData: {},
        urlDescription: ["abilities", "abilities/name", "abilities/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
};
var ptuApi = (function(){
    var _baseUrl = "/api/v1/";
    var _type = null;
    
    return {
        setApiDetails: function(type) {
            _type = type;
            // Set Placeholder
            $("#urlInput").attr("placeholder", type.verbs[0]);
            
            // Set url descriptions
            $("#callExplanation").html("");
            for (var i = 0; i < type.urlDescription.length; ++i) {
                var html = $("#callExplanation").html();
                $("#callExplanation").html(html + _baseUrl + type.urlDescription[i] + "<br/>");
            }
        },
        makeCall: function() {
            var url = encodeURI(_type.url + $("#urlInput").val());
            this.showLoader();
            $.ajax({
                url: _baseUrl + url,
                type: "GET",
                dataType: "json",
                context: this,
                success: function(data) {
                    $("#callData").text(JSON.stringify(data));
                },
                error: function(data) {
                    
                },
                complete: function() {
                    this.hideLoader();
                }
            });
        },
        onSelect: function() {
            $("#urlInput").val("");
            var type = $("#apiSelect").find(":selected").val();
            this.setApiDetails(ptuApiData[type]);
        },
        showLoader: function() {
            $("#loader").show();
            $("#callData").hide();
        },
        hideLoader: function() {
            $("#loader").hide();
            $("#callData").show();
        }
    };
})();

// On load
(function(){
    ptuApi.onSelect();
    
    // Bind enter key
    $(document).keypress(function(e){
        if (e.which == 13){
            $("#submitBtn").click();
        }
    });
})();