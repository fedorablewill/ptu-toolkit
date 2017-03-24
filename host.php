<!doctype html>
<html>
<head>
    <!--
    $.getJSON("/api/v1/generate", {"habitat": "Grassland", "min_level": 12, "max_level": 14}, function (data){gm_data["Pokémon"][generatePmonId()] = data});
    -->

    <title>PTU Battle Viewer</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/material-kit.css" rel="stylesheet">
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
            color: inherit;
            font-weight: 300;
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
    </style>
</head>
<body>

<nav class="navbar navbar-danger">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0)">PTU GM's Tools</a>
        </div>
        <div>
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
            <button class="btn btn-white btn-simple" onclick="changeGMView(0)">
                Battler
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-white btn-simple" onclick="changeGMView(1)">
                Pokémon
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-white btn-simple" onclick="changeGMView(2)">
                Settings
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-white btn-simple" onclick="saveGM();">
                Save
            </button>
        </div>
    </div>
</footer>

<div class="hidden" id="body-pokemon">
    <div class="card card-nav-tabs">
        <div class="header header-danger">
            <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                    <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="active">
                            <a href="#tab-manage" data-toggle="tab">
                                <i class="material-icons">view_module</i>
                                Manage
                            </a>
                        </li>
                        <li>
                            <a href="#tab-add" data-toggle="tab" onclick="onClickAddPokemon()">
                                <i class="material-icons">add</i>
                                Create
                            </a>
                        </li>
                        <li>
                            <a href="#tab-generate" data-toggle="tab">
                                <i class="material-icons">brush</i>
                                Generate
                            </a>

                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#modalImpPokemon">
                                <i class="material-icons">file_download</i>
                                Import
                            </a>

                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#modalExpPokemon" onclick="fetchExistingPokemon();">
                                <i class="material-icons">file_upload</i>
                                Export
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="tab-content text-center">
                <div class="tab-pane active" id="tab-manage">
                    <div class="list-pokemon"></div>
                </div>
                <div class="tab-pane" id="tab-add">
                    <p>To be moved here</p>
                </div>
                <div class="tab-pane" id="tab-generate">
                    <div class="col-md-8 col-md-offset-2 form-genmon">

                        <h4>Step 1: Select Categories</h4>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group input-enable">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-control-enabler" id="enable-species">
                                        </label>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="genmon-species" style="opacity: 0.6">Species</label>
                                        <input class="form-control" type="text" id="genmon-species" disabled data-populate="dex" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-enable">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-control-enabler" id="enable-type">
                                        </label>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="genmon-type" style="opacity: 0.6">Type</label>
                                        <select class="form-control" id="genmon-type" disabled data-populate="type">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group input-enable">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-control-enabler" id="enable-habitat">
                                        </label>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="genmon-habitat" style="opacity: 0.6">Habitat</label>
                                        <select class="form-control" id="genmon-habitat" disabled>
                                            <option></option>
                                            <option>Arctic</option>
                                            <option>Beach</option>
                                            <option>Cave</option>
                                            <option>Desert</option>
                                            <option>Forest</option>
                                            <option>Freshwater</option>
                                            <option>Grassland</option>
                                            <option>Marsh</option>
                                            <option>Mountain</option>
                                            <option>Ocean</option>
                                            <option>Rainforest</option>
                                            <option>Taiga</option>
                                            <option>Tundra</option>
                                            <option>Urban</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-enable">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-control-enabler" id="enable-gen">
                                        </label>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="genmon-gen" style="opacity: 0.6">Generation</label>
                                        <select class="form-control" id="genmon-gen" disabled>
                                            <option></option>
                                            <option value="1">Gen I</option>
                                            <option value="2">Gen II</option>
                                            <option value="3">Gen III</option>
                                            <option value="4">Gen IV</option>
                                            <option value="5">Gen V</option>
                                            <option value="6">Gen VI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4>Step 2: Owner Information</h4>

                        <div class="togglebutton">
                            <label>
                                <input type="checkbox" id="genmon-is-wild" checked> Wild Pokémon
                            </label>
                        </div>

                        <div class="collapse" id="group-owner-settings">
                            Owner Specifications
                            <div class="collapse-form">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="genmon-tp"> Top Percentage Class
                                        <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                           title="Pokémon from an owner with Top Percentage gain extra Tutor Points and boosted Base Stats on Levels divisible by 5">help</i>
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-soul"> Enduring Soul Class
                                        <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                           title="Pokémon from an owner with Enduring Soul can have their HP stat raised outside of the Base Relations Rule">help</i>
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-horiz"> Expand Horizons Feature
                                        <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                           title="Pokémon from an owner with Expand Horizons gain 3 extra Tutor Points">help</i>
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-guide"> Guidance Feature
                                        <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                           title="Pokémon from an owner with Guidance have an extra move">help</i>
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-ace-atk"> Stat Ace (ATK)
                                        <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                           title="Pokémon from an owner with Stat Ace gain an extra point to the bound stat with a bonus +1 per 10 levels. The stat can also ignore the Base Relations Rule.">help</i>
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-ace-def"> Stat Ace (DEF)
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-ace-spatk"> Stat Ace (SPATK)
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-ace-spdef"> Stat Ace (SPDEF)
                                    </label>
                                    <label>
                                        <input type="checkbox" id="genmon-ace-spd"> Stat Ace (SPD)
                                    </label>
                                </div>

                                <div class="form-group label-floating">
                                    <label class="control-label" for="addmon-lvl-caught">Level Caught</label>
                                    <input class="form-control" type="number" id="genmon-lvl-caught" min="1" max="100" value="1" />
                                    <p class="help-block">Only required if they have Top Percentage</p>
                                </div>

                                <div class="form-group label-floating">
                                    <label class="control-label" for="addmon-lvl-caught">Unused Tutor Points</label>
                                    <input class="form-control" type="number" id="genmon-tutor-unused" min="0" value="0" />
                                    <p class="help-block">If you don't want all of the tutor points used, specify here</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label" for="addmon-discover">Discovered at</label>
                            <input class="form-control" type="text" id="genmon-discover" />
                            <p class="help-block">Keep track of where the Pokémon was found</p>
                        </div>

                        <h4>Step 3: Pokémon Settings</h4>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-lvlmin">Min Level</label>
                                    <input class="form-control" type="number" id="genmon-lvlmin" min="1" max="100" value="1" required />
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label" for="genmon-lvl-slider">Level Range</label>
                                <div class="slider slider-danger" id="genmon-lvl-slider"></div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-lvlmax">Max Level</label>
                                    <input class="form-control" type="number" id="genmon-lvlmax" min="1" max="100" value="100" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label" for="genmon-gender">Specific Gender</label>
                            <select class="form-control" id="genmon-gender" data-field="gender">
                                <option></option>
                                <option>Genderless</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-tmmin">Min Leanred TMs</label>
                                    <input class="form-control" type="number" id="genmon-tmmin" min="0" max="9" value="0" required />
                                    <p class="help-block">Includes TMs, HMs, and Tutor Moves</p>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-tmmax">Max Learned TMs</label>
                                    <input class="form-control" type="number" id="genmon-tmmax" min="0" max="9" value="0" required />
                                    <p class="help-block">Includes TMs, HMs, and Tutor Moves</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-emmin">Min Egg Moves</label>
                                    <input class="form-control" type="number" id="genmon-emmin" min="0" max="9" value="0" required />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-emmax">Max Egg Moves</label>
                                    <input class="form-control" type="number" id="genmon-emmax" min="0" max="9" value="0" required />
                                </div>
                            </div>
                        </div>

                        <div class="togglebutton">
                            <label>
                                <input type="checkbox" id="genmon-legend" checked> Include Legendaries
                            </label>
                        </div>

                        <div class="togglebutton">
                            <label>
                                <input type="checkbox" id="genmon-weight-stats" onclick="$('#group-stat-weights').collapse('toggle')"> Weighted Stats
                                <i class="material-icons help" data-toggle="tooltip" data-placement="top"
                                   title="Set certain stats to have priority over others by raising the number next to it. Set to all 1's to equally distribute stat points.">help</i>
                            </label>
                        </div>

                        <div class="collapse" id="group-stat-weights">
                            <div class="collapse-form">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-hp">HP (Stat)</label>
                                    <input class="form-control" type="number" id="genmon-hp" value="1" />
                                </div>
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-atk">Attack</label>
                                    <input class="form-control" type="number" id="genmon-atk" value="1" />
                                </div>
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-def">Defense</label>
                                    <input class="form-control" type="number" id="genmon-def" value="1" />
                                </div>
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-spatk">Special Attack</label>
                                    <input class="form-control" type="number" id="genmon-spatk" value="1" />
                                </div>
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-spdef">Special Defense</label>
                                    <input class="form-control" type="number" id="genmon-spdef" value="1" />
                                </div>
                                <div class="form-group label-floating">
                                    <label class="control-label" for="genmon-speed">Speed</label>
                                    <input class="form-control" type="number" id="genmon-speed" value="1" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <button class="btn btn-success pull-right" id="btn-genmon">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hidden" id="body-settings">
    <h1>Nothin' to see yet..</h1>
</div>

<!-- Modal dialog for exporting Pokémon -->
<div class="modal fade" id="modalExpPokemon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="expMonLabel">Export a Pokémon</h3>
            </div>

            <input type="hidden" id="expmon-id" value="" />

            <div class="modal-body form-expmon">
                <small><i>Feature is work in progress</i></small>

                <h4>Basic Info</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="expmon-mon">Select Pokémon</label>
                    <select class="form-control" id="expmon-mon" required><option></option></select>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="expmon-name">Click in the text field below and use ctrl-A to copy JSON:</label>
                    <textarea class="form-control" rows="5" cols="20" data-field="json" id="expmon-JSON" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
                </div>
             </div>
        </div>
    </div>
</div>

<!-- Modal dialog for importing Pokémon -->
<div class="modal fade" id="modalImpPokemon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="impMonLabel">Import a Pokémon</h3>
            </div>

            <input type="hidden" id="impmon-id" value="" />

            <div class="modal-body form-impmon">
                <small><i>Feature is work in progress</i></small>

                <h4>Basic Info</h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="impmon-name">Put Fancy Sheet JSON below:</label>
                    <textarea class="form-control" rows="5" cols="20" data-field="json" id="impmon-JSON" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-impmon">Save</button>
                </div>
             </div>
        </div>
    </div>
</div>

<!-- Modal dialog for adding/editing Pokémon -->
<div class="modal fade" id="modalAddPokemon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="myModalLabel">Add/Edit Pokémon</h3>
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
                    <input class="form-control" type="text" id="addmon-dex" data-field="dex" required data-populate="dex" />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-type1">Type 1</label>
                    <select class="form-control" id="addmon-type1" required data-populate="type"><option></option></select>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-type2">Type 2</label>
                    <select class="form-control" id="addmon-type2" data-populate="type"><option></option></select>
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
                    <select class="form-control" id="addmon-nature" data-field="nature" required data-populate="nature">
                        <option></option>
                    </select>
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
                    <p class="help-block">Where was the Pokémon found</p>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-item">Held Item</label>
                    <input class="form-control" type="text" id="addmon-item" data-field="held-item" />
                </div>

                <hr/>

                <h4>Health <small class="text-warning" id="warn-health"></small></h4>

                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-health">Current Health</label>
                    <input class="form-control" type="number" id="addmon-health" data-field="health" />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="addmon-injure">Injuries</label>
                    <input class="form-control" type="number" id="addmon-injure" data-field="injuries" value="0" />
                </div>

                <hr/>

                <h4>Stats <small class="text-warning" id="warn-stats"></small></h4>

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
                    <select class="form-control" title="Move 1" required data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 2" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 3" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 4" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 5" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 6" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 7" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 8" data-populate="move"><option></option></select>
                    <select class="form-control" title="Move 9" data-populate="move"><option></option></select>
                </div>
                <label for="addmon-moves">Abilities</label>
                <div id="addmon-abilities">
                    <select class="form-control" title="Ability 1" required data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 2" data-populate="ability"><option></option></select>
                    <select class="form-control" title="Ability 3" data-populate="ability"><option></option></select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
<script src="js/material.min.js"></script>
<script src="js/nouislider.min.js"></script>

<script src="js/script.js"></script>
<script src="js/JSONImport.js"></script>
<script src="js/JSONExport.js"></script>
<script src="js/host.js"></script>
</body>
</html>
