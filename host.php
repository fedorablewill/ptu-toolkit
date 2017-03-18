<!doctype html>
<html>
<head>
    <!--
    $.getJSON("/api/v1/generate", {"habitat": "Grassland", "min_level": 12, "max_level": 14}, function (data){gm_data["pokemon"][generatePmonId()] = data});
    -->

    <title>PTU Battle Viewer</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

<input id = "uploadAnchor" type="file" style="display: none"/>
<a id="downloadAnchor" style="display:none"></a>

<div class="container" id="view-holder">
    <div class="col-md-6 col-md-offset-3 content-init">
        <h2>Enter a desired GM ID</h2>
        <div class="form-group label-floating">
            <label class="control-label" for="battle-id">GM ID</label>
            <input type="text" class="form-control col-md-8" id="battle-id"/>
        </div>
        <button class="btn btn-danger btn-raised" onclick="GMID();">GO</button>
    </div>
    <div class="col-md-6 col-md-offset-3 content-select" hidden>
        <h2>Create or Import a GM File</h2>
        <button class="btn btn-danger btn-raised" onclick="newGM();">Create Blank GM File</button>
        <br>
        <button class="btn btn-danger btn-raised" onclick="selectGM();">Upload Existing GM File</button>
    </div>
    <div class="col-md-6 col-md-offset-3 pokemon"></div>
</div>

<div class="bottom">
    <div class="container">
        <div class="row">

        </div>
    </div>
</div>

<footer class="footer-gm hidden">
    <div class="container">
        <div class="col-xs-3">
            <button class="btn btn-default" onclick="changeGMView(0)">
                Battler
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default" onclick="changeGMView(1)">
                Pokémon
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default" onclick="changeGMView(2)">
                Settings
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-default" onclick="saveGM();">
                Save
            </button>
        </div>
    </div>
</footer>

<div class="hidden" id="body-pokemon">
    <h2>Editing Pokemon work in progress..</h2>
    <div class="list-pokemon"></div>
    <br/>
    <button class="btn btn-lg btn-danger btn-raised" data-toggle="modal" data-target="#modalAddPokemon">Add Pokemon</button>
    <button class="btn btn-lg btn-danger btn-raised" data-toggle="modal" data-target="#modalGenPokemon">Generate Pokemon</button>
</div>

<div class="hidden" id="body-settings">
    <h1>Nothin' to see yet..</h1>
</div>

<!-- Modal dialog for generating Pokemon -->
<div class="modal fade" id="modalGenPokemon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger" id="myModalLabel">Generate Pokemon</h4>
            </div>

            <div class="modal-body form-genmon">

                <div class="form-group label-floating">
                    <label class="control-label" for="genmon-type">Species</label>
                    <select class="form-control" id="genmon-type" required><option></option></select>
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="genmon-type">Type</label>
                    <select class="form-control" id="genmon-type" required><option></option></select>
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="genmon-habitat">Habitat</label>
                    <select class="form-control" id="genmon-habitat" required><option></option></select>
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="genmon-gen">Generation</label>
                    <select class="form-control" id="genmon-gen" required><option></option></select>
                </div>

                <div class="togglebutton">
                    <label>
                        <input type="checkbox" id="genmon-legend" checked> Include Legendaries
                    </label>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="genmon-lvlmin">Min Level</label>
                            <input class="form-control" type="number" id="genmon-lvlmin" required />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group label-floating">
                            <label class="control-label" for="genmon-lvlmax">Max Level</label>
                            <input class="form-control" type="number" id="genmon-lvlmax" required />
                        </div>
                    </div>
                    she's a work in progress y'all
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">done</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal dialog for adding/editing Pokemon -->
<div class="modal fade" id="modalAddPokemon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="myModalLabel">Add a Pokemon</h3>
            </div>

            <input type="hidden" id="addmon-id" value="" />

            <div class="modal-body form-addmon">
                <small><i>Feature is work in progress</i></small>

                <h4>Basic Info</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-name">Pokémon Name</label>
                    <input class="form-control" type="text" id="addmon-name" data-field="name" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-dex">Pokédex ID</label>
                    <input class="form-control" type="text" id="addmon-dex" data-field="dex" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-type1">Type 1</label>
                    <select class="form-control" id="addmon-type1" required><option></option></select>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-type2">Type 2</label>
                    <select class="form-control" id="addmon-type2"><option></option></select>
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-level">Level</label>
                    <input class="form-control" type="number" id="addmon-level" data-field="level" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-exp">EXP</label>
                    <input class="form-control" type="number" id="addmon-exp" data-field="EXP" value="0" />
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-nature">Nature</label>
                    <select class="form-control" id="addmon-nature" data-field="nature" required><option></option></select>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-gender">Gender</label>
                    <select class="form-control" id="addmon-gender" data-field="gender" required>
                        <option>Genderless</option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-discover">Discovered at</label>
                    <input class="form-control" type="text" id="addmon-discover" data-field="discovery" />
                    <p class="help-block">Where was the Pokemon found</p>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-item">Held Item</label>
                    <input class="form-control" type="text" id="addmon-item" data-field="held-item" />
                </div>

                <hr/>

                <h4>Health</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-health">Current Health</label>
                    <input class="form-control" type="number" id="addmon-health" data-field="health" />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-injure">Injuries</label>
                    <input class="form-control" type="number" id="addmon-injure" data-field="injuries" value="0" />
                </div>

                <hr/>

                <h4>Stats</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-hp">HP (Stat)</label>
                    <input class="form-control" type="number" id="addmon-hp" data-field="hp" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-atk">Attack</label>
                    <input class="form-control" type="number" id="addmon-atk" data-field="atk" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-def">Defense</label>
                    <input class="form-control" type="number" id="addmon-def" data-field="def" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-spatk">Special Attack</label>
                    <input class="form-control" type="number" id="addmon-spatk" data-field="spatk" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-spdef">Special Defense</label>
                    <input class="form-control" type="number" id="addmon-spdef" data-field="spdef" required />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-speed">Speed</label>
                    <input class="form-control" type="number" id="addmon-speed" data-field="speed" required />
                </div>

                <hr/>

                <h4>Moves & Abilities</h4>

                <!-- TODO: make moves add/remove -->
                <label for="addmon-moves">Moves</label>
                <div id="addmon-moves">
                    <select class="form-control" title="Move 1" required></select>
                    <select class="form-control" title="Move 2"></select>
                    <select class="form-control" title="Move 3"></select>
                    <select class="form-control" title="Move 4"></select>
                    <select class="form-control" title="Move 5"></select>
                    <select class="form-control" title="Move 6"></select>
                    <select class="form-control" title="Move 7"></select>
                    <select class="form-control" title="Move 8"></select>
                    <select class="form-control" title="Move 9"></select>
                </div>
                <label for="addmon-moves">Abilities</label>
                <div id="addmon-abilities">
                    <select class="form-control" title="Ability 1" required></select>
                    <select class="form-control" title="Ability 2"></select>
                    <select class="form-control" title="Ability 3"></select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn-addmon">Save</button>
            </div>
        </div>
    </div>
</div>

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
