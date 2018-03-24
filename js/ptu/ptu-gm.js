/**
 *  Game Master (GM) Client Functionality
 */


function changeView(index, suppressRender) {
    currentView = index;

    if (index === 0) {
        $("#body-battle").removeClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").addClass("hidden");

        if (!suppressRender)
            BattlerView.render();
    }
    else if (index === 1) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").removeClass("hidden");
        $("#body-settings").addClass("hidden");

        if (!suppressRender)
            renderPokemonList();
    }
    else if (index === 2) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").removeClass("hidden");
    }
}

// Initialize Firebase
var config = {
    apiKey: "AIzaSyBGYQmctNWkQWpII2cfqs9yBJOEwgKvKAM",
    authDomain: "ptu-toolkit.firebaseapp.com",
    databaseURL: "https://ptu-toolkit.firebaseio.com",
    projectId: "ptu-toolkit",
    storageBucket: "ptu-toolkit.appspot.com",
    messagingSenderId: "412564537560"
};
firebase.initializeApp(config);

// Store token
var f_token;

// Firebase Logic
firebase.auth().onAuthStateChanged(function(user) {
    if (user) {
        // User is signed in, get token.

        firebase.auth().currentUser.getToken(true).then(function(idToken) {
            f_token = idToken;
            // Send token to backend
            $.ajax({
                type: "GET",
                url: "api/v1/campaign",
                dataType: 'json',
                async: false,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa(user.uid+ ":" + idToken));
                },
                success: function (data, status, xhr){
                    // Campaigns found
                    if (data.length >= 1) {

                    }
                },
                error: function (xhr, status, error) {
                    window.alert(status + " " + error);
                }
            });
        }).catch(function(error) {
            window.alert(error);
        });
    } else {
        // User is signed out.
        // TODO: something?
    }
}, function(error) {
    console.log(error);
});

function changeGMView(view) {
    currentView = view;

    if (view === 0) {
        $("#body-battle").removeClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").addClass("hidden");
        BattlerView.render();
    }
    else if (view === 1) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").removeClass("hidden");
        $("#body-settings").addClass("hidden");
        renderPokemonList();
    }
    else if (view === 2) {
        $("#body-battle").addClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").removeClass("hidden");
    }
}

var DataHelperBase = (function () {
    return {
        /**
         * Executes when a campaign is loaded (i.e. after either being created or fetched
         */
        onDataLoaded : function () {
            $("#display-gmid").html(client_id);
            $(".content-select").css("display", "none");
            $(".footer-gm").removeClass("hidden");

            $("#link-sharable").val('http://ptu.will-step.com/?host=' + client_id);
            new Clipboard('.btn');

            $("#zoom-slider").noUiSlider({
                start: [10] ,
                step: 1,
                connect: false,
                range: {
                    min: 1,
                    max: 20
                }
            }).on("change", function () {
                BattlerView.render();
            });

            $("#view-holder").addClass("hidden");
            changeGMView(0);
        }
    }
})();