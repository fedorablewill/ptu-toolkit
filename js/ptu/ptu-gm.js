/**
 *  Game Master (GM) Client Functionality
 */

// Imports
$.getScript('js/script.js');
$.getScript('js/ptu-io.js');
$.getScript('js/ptu-char.js');
$.getScript('js/ptu-battle.js');


function changeView(index, suppressRender) {
    currentView = index;

    if (index === 0) {
        $("#body-battle").removeClass("hidden");
        $("#body-pokemon").addClass("hidden");
        $("#body-settings").addClass("hidden");

        if (!suppressRender)
            renderBattler();
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
        renderBattler();
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