<!doctype html>
<html>
<head>
    <!--
    $.getJSON("/api/v1/generate", {"habitat": "Grassland", "min_level": 12, "max_level": 14}, function (data){gm_data["Pokémon"][generatePmonId()] = data});
    -->

    <title>PTU Battle Viewer</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="dist/snackbar.min.css" rel="stylesheet">
    <link href="css/material-kit.css" rel="stylesheet">

    <style>
        /* TODO: move to single css file */

        body {
            background:
                url('img/pixel-art-pokemon-wallpaper-2.jpg')
                no-repeat fixed center bottom;

            background-size: cover !important;
            color: white;
            padding-bottom: 500px;
        }

        nav .btn {
            margin: 0;
        }

        .navbar-gmid {
            margin-top: 10px;
        }

        .content-init input {
            color: white;
        }

        #battle-message {
            text-shadow: #444 0px 0px 8px;
        }

        #battle-actions h3 {
            font-family: "Roboto Mono", "Roboto", "Helvetica", "Arial", sans-serif;
            font-weight: 500;
            text-shadow: #444 1px 1px 6px;
        }

        #battle-actions .battle-dialog {
            font-family: "Roboto Mono", "Roboto", "Helvetica", "Arial", sans-serif;
            color: #333;
            margin-top: 15px;
            padding: 10px 10px 5px 10px;
            background-color: rgba(0, 0, 0, 0);
            background-image: linear-gradient(60deg, rgb(248, 248, 248), rgb(239, 239, 239));
            border-radius: 4px;
            border: #888 solid 3px;
            text-shadow: none;
        }

        #battle-actions .battle-dialog p:not(:first-child){
            text-align: left;
        }

        #battle-actions h2, #battle-actions h3, #battle-actions h4, #battle-actions h5, #battle-actions h6 {
            margin-top: 5px;
        }

        #battle-help {
            background: linear-gradient(60deg, #ef5350, #d32f2f);
            font-weight: 400;
            color: #FFF;
            padding: 10px;
        }

        .battle-slider {
            width: 300px;
            max-width: calc(100% - 45px);
        }

        .battle-slider label {
            color: #f44336;
        }

        .battle-slider .slider, .battle-slider .noUi-origin {
            background: #f0f0f0;
        }

        .card-battle .content {
            padding: 15px 45px;
        }

        .grid-row {
            display: flex;
        }

        .grid-piece {
            position: relative;
        }

        .grid{
            display: none;
            background-color: #fcfcfc;
            border: 1px solid rgb(142, 142, 142);
        }

        .pokemon {
            color: #4f4f4f;
        }

        .pokemon .progress {
            height: 8px;
            background: #bababa;
        }

        .effects {
            padding-bottom: 10px;
            min-height: 20px;
        }

        #data1, #data2, #data3, #data4 {
            display: none;
        }

        .btn-move {
            text-align: left;
            width: 100%;
            background-color: #FFFFFF;
            white-space: normal;
        }

        #stages input {
            width: 50px;
        }

        .togglebutton input {
            width: 10px !important;
        }

        .togglebutton label {
            color: inherit;
            font-weight: 300;
        }

        input, select, button:not(.btn) {
            color: #000000;
        }

        .content-generator {
            margin-top: 300px;
        }

        .edit-pokemon {
            text-align: left;
        }

        .edit-pokemon img {
            height: 50px;
        }

        footer.footer-gm {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f44336;
            color: rgba(255,255,255,.84);
            text-align: center;
            padding: 0;
        }

        .footer-gm .btn-default {
            color: #FFFFFF !important;
        }

        .modal-body {
            color: #0f0f0f;
        }

        .ui-autocomplete {
            z-index: 1500 !important;
        }

        .input-group {
            width: 100%;
        }

        .has-btn-sm {
            width: calc(100% - 50px);
        }

        .input-enable .checkbox {
            display: inline-block;
            margin-right: 15px;
        }

        .input-enable .form-group {
            display: inline-block;
            width: calc(100% - 50px);
        }

        .collapse-form {
            margin-left: 5px;
            padding-left: 10px;
            border-left: solid rgb(238, 238, 238) 1px;
        }

        .help {
            font-size: 15px;
            margin-right: 5px;
        }

        .form-genmon {
            text-align: left;
        }

        .form-genmon h3,h4 {
            text-align: center;
        }

        .togglebutton label input[type=checkbox]:checked + .toggle {
            background-color: rgba(244, 67, 54, 0.7);
        }

        .togglebutton label input[type=checkbox]:checked + .toggle:after {
            border-color: #f44336;
        }

        .checkbox input[type=checkbox]:checked + .checkbox-material .check {
            background: #f44336;
        }


        .form-group.is-focused .form-control {
            outline: none;
            background-image: linear-gradient(#f44336, #f44336), linear-gradient(#D2D2D2, #D2D2D2);
        }

        .form-group.is-focused label, .form-group.is-focused label.control-label {
            color: #f44336;
        }

        .snackbar {
            background-color: #0ab1fc;
            color: #ffffff;
            border: 0;
            border-radius: 0;
            padding: 20px 15px;
            line-height: 20px;
        }

        .snackbar-container {
            padding-bottom: 65px;
        }

        .snackbar:not(.snackbar-opened) {
            z-index: -200;
            display: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-danger">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0)">PTU GM's Tools</a>
        </div>
    </div>
</nav>

<input id = "uploadAnchor" type="file" style="display: none"/>
<a id="downloadAnchor" style="display:none"></a>

<div class="container">
    <div class="col-sm-4 col-md-offset-2">

    </div>
    <div class="col-sm-4">
        <div class="card card-nav-tabs">
            <div class="header header-danger">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <div class="nav nav-tabs text-center" data-tabs="tabs">
                            <h5 id="card-title">SIGN INTO TOOLKIT</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="tab-content">
                    <div class="tab-pane active text-center" id="tab-signin">
                        <button class="btn btn-info" id="btn-signin-player">
                            Continue as Player
                        </button>
                        <hr/>
                        <small class="text-muted">CONTINUE AS GM</small>
                        <div id="gm-auth">
                        	<div id="firebaseui-auth-container">

	                        </div>
	                        <button class="btn btn-primary firebaseui-idp-button mdl-button mdl-js-button mdl-button--raised
	                            firebaseui-id-idp-button" id="btn-signin-anon">
	                            <span class="firebaseui-idp-text firebaseui-idp-text-long">Continue Anonymously</span>
	                            <span class="firebaseui-idp-text firebaseui-idp-text-short">Anonymous</span>
	                        </button>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-player">
                        Hello, beautiful.
                    </div>
                    <div class="tab-pane" id="tab-signup">
                        <div class="form-group label-floating">
                            <label class="control-label" for="signup-uname">Enter a Username</label>
                            <input class="form-control" type="text" id="signup-uname" />
                        </div>
                        <button class="btn btn-info" id="btn-signup">Signup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Google Firebase Init -->

<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.1.3/firebase-auth.js"></script>

<script src="https://cdn.firebase.com/libs/firebaseui/2.2.1/firebaseui.js"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/2.2.1/firebaseui.css" />

<script>
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

    // FirebaseUI config.
    var uiConfig = {
        signInSuccessUrl: 'http://ptu.will-step.com/splash.php#r',
        signInOptions: [
            // Leave the lines as is for the providers you want to offer your users.
            firebase.auth.GoogleAuthProvider.PROVIDER_ID,
            firebase.auth.FacebookAuthProvider.PROVIDER_ID,
            firebase.auth.EmailAuthProvider.PROVIDER_ID
        ],
        // Terms of service url.
        tosUrl: 'http://ptu.will-step.com/terms.php'
    };

    // Initialize the FirebaseUI Widget using Firebase.
    var ui = new firebaseui.auth.AuthUI(firebase.auth());
    // The start method will wait until the DOM is loaded.
    ui.start('#firebaseui-auth-container', uiConfig);

    // Firebase Logic
    initApp = function() {
        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {
                // User is signed in, get token.
                
                firebase.auth().currentUser.getToken(/* forceRefresh */ true).then(function(idToken) {
                	// Send token to backend
                	$.ajax({
                        type: "POST",
                        url: "api/v1/user/login",
                        dataType: 'json',
                        async: false,
                        beforeSend: function (xhr) {
			                xhr.setRequestHeader ("Authorization", "Basic " + btoa(user.uid+ ":" + idToken));
			            },
			            success: function (data, status, xhr){
                            // User not set up
                            if (!user.isAnonymous && (xhr.status == 204 || data == "" || data == '""')) {
                                $("#card-title").html('NEW USER');
                                $("#tab-signin").hide();
                                $("#tab-signup").show();

                                $("#btn-signup").click(function() {
                                    $.ajax({
                                    type: "POST",
                                    url: "api/v1/user",
                                    dataType: 'json',
                                    data: {"firebase_id": firebase.auth().currentUser.uid, "username": $("#signup-uname").val()},
                                    async: false,
                                    beforeSend: function (xhr) {
                                        xhr.setRequestHeader ("Authorization", "Basic " + btoa(user.uid+ ":" + idToken));
                                    },
                                    success: function (data, status, xhr){
                                        window.location = "host.php";
                                    },
                                    error: function (xhr, status, error) {
                                        window.alert(status + " " + error);
                                    }
                                });
                                });
                            }
                            else {
                                $("#gm-auth").html('<a href="host.php" class="btn btn-info" id="btn-signin-player">' +
                                            '    Continue as GM' +
                                            '</a>' +
                                            '<button class="btn btn-danger" id="btn-signin-player" onclick="signout()">' +
                                            '    Sign out' +
                                            '</button>');
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
    };

    window.addEventListener('load', function() {
        initApp();
    
	    $('#btn-signin-anon').click(function() {
	    	firebase.auth().signInAnonymously().catch(function(error) {
                window.alert(error.code + ": " + error.message);
            });
	    });
    });
</script>


<!-- JavaScript Imports -->

<script src="http://cdn.peerjs.com/0.3/peer.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script>
    //Remove JQuery UI conflicts with Bootstrap
    $.widget.bridge('uibutton', $.ui.button);
    $.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.0/clipboard.min.js"></script>
<script src="dist/snackbar.min.js"></script>
<script src="js/material.min.js"></script>

<script src="js/script.js"></script>
</body>
</html>
