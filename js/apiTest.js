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
    capabilities: {
        url: "capabilities/",
        verbs: ["Marsupial", "Dream Reader"],
        requestData: {},
        urlDescription: ["capabilities", "capabilities/name", "capabilities/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
    edges: {
        url: "edges/",
        verbs: ["Breeder", "Basic Cooking"],
        requestData: {},
        urlDescription: ["edges", "edges/name", "edges/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
    features: {
        url: "features/",
        verbs: ["Press", "Guardian Orders"],
        requestData: {},
        urlDescription: ["features", "features/1", "features/name", "features/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
    natures: {
        url: "natures/",
        verbs: ["Distracted", "Adamant"],
        requestData: {},
        urlDescription: ["natures", "natures/name", "natures/?names=encodeURIComponent(JSON.stringify(arrayOfNames))"]
    },
    generate: {
        url: "generate/",
        verbs: [],
        requestData: {},
        urlDescription: []
    },
};

var ptuApi = (function(){
    var _baseUrl = "/api/v1/";
    var _type = null;
    
    return {
        getJson: function(filename) {
            $.getJSON("/api/v1/getJson/oldabilities", function(data){
                var a = data;
                console.log(data);
            });
        },
        setApiDetails: function(type) {
            _type = type;
            // Set Placeholder
            var randomVerbIndex = Math.round(Math.random() * (type.verbs.length - 1));
            $("#urlInput").attr("placeholder", type.verbs[randomVerbIndex]);
            
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
        },
        setSelectOptions: function() {
            var html = [];
            $.each(ptuApiData, function(type, data){
                html.push("<option>"+type+"</option>");
            });
            $("#apiSelect").html(html.join());
            
        },
    };
})();

// On load
(function(){
    ptuApi.setSelectOptions();
    ptuApi.onSelect();
    
    // Bind enter key
    $(document).keypress(function(e){
        if (e.which == 13){
            $("#submitBtn").click();
        }
    });
    
})();