<!doctype html>
<html>
<head>

    <title>PTU Battle Viewer</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="css/bootstrap-material-design.min.css" rel="stylesheet">
    <link href="css/ripples.min.css" rel="stylesheet">
    <link href="dist/snackbar.min.css" rel="stylesheet">

    <style>
        /* TODO: move to single css file */

        body {
            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.45),
                    rgba(50, 50, 50, 0.88)
                ),
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
            color: #FFFFFF;
        }

        input, select, button:not(.btn) {
            color: #000000;
        }

        .content-generator {
            margin-top: 300px;
        }

        footer.footer-gm {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f44336;
            color: rgba(255,255,255,.84);
            text-align: center;
        }

        .footer-gm .btn-default {
            color: #FFFFFF !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-danger">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)">PTU GM's Tools</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <div class="navbar-right navbar-gmid">
                <strong>GM ID:</strong> <span id="display-gmid"></span>
            </div>
        </div>
    </div>
</nav>

<div class="container" id="view-holder">
    <div class="col-md-6 col-md-offset-3 content-init">
        <h2>Enter a desired GM ID</h2>
        <input type="text" class="form-control col-md-8" placeholder="Enter GM ID" id="battle-id"/>
        <button class="btn btn-danger btn-raised" onclick="registerNewGM();">GO</button>
    </div>
    <div class="col-md-6 col-md-offset-3 pokemon"></div>
</div>

<div class="bottom">
    <div class="container">
        <div class="row">

        </div>
    </div>
</div>

<footer class="footer-gm">
    <div class="container">
        <div class="col-xs-3">
            <button class="btn btn-default">
                Save
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default">
                Pokémon
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default">
                Settings
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default">
                Feedback
            </button>
        </div>
    </div>
</footer>

<!-- JavaScript Imports -->
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
<script src="dist/snackbar.min.js"></script>
<script src="js/ripples.js"></script>
<script src="js/material.js"></script>

<script src="js/script.js"></script>
<script src="js/host.js"></script>
</body>
</html>