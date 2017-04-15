<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/species_to_dex.js"></script>
    <title>PTU Tools</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400'
          rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="css/material-kit.css" rel="stylesheet">

    <style>
        body {
            background: url('img/pixel-art-pokemon-wallpaper-2.jpg') no-repeat fixed center bottom;

            background-size: cover !important;
            color: white;
            padding-top: 90px;
        }

        .nav-pokemon {
            padding: 10px 60px;
            width: 220px;
            background: white;
            z-index: 1050;
            white-space: normal;
        }

        .nav-pokemon #dex-species {
            margin-bottom: 8px;
            display: block;
        }

        .nav-status {
            position: absolute;
            top: 75px;
        }

        .nav-tabs li.active {
            background: rgb(3, 169, 244);
        }

        .nav-tabs li:not(.active) {
            background: rgba(3, 169, 244, 0.5);
        }

        .nav-tabs li:hover {
            background: rgba(3, 169, 244, 0.9);
        }

        .sidebar {
            height: 100%;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding-top: 100px;
            padding-bottom: 20px;
            padding-left: 25px;
            padding-right: 25px;
            background-color: #ffffff;
            border-radius: 0;
            z-index: 1010;
            box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.42),
            0 3px 10px 0px rgba(0, 0, 0, 0.12),
            0 4px 5px -3px rgba(0, 0, 0, 0.2);
        }

        .sidebar .btn-sidebar {
            width: 100%;
        }

        .content-init .well {
            color: #0f0f0f;
        }

        .content-main .well {
            color: #0f0f0f;
        }

        .effects {
            padding-bottom: 10px;
            min-height: 20px;
        }

        .content-header .pokemon-image {
            margin-right: 15px;
            margin-left: 15px;
        }

        .content-header .name {
            display: inline-block;
            color: #0f0f0f;
        }

        .content-header .name small {
            color: #afafaf;
        }

        #data1, #data2, #data3, #data4 {
            display: none;
        }

        .content-main .card {
            padding: 10px 15px;
        }

        .btn-move {
            text-align: left;
            width: 100%;
            background-color: #FFF;
            color: #999;
            white-space: normal;
            max-width: 570px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-move .move-name {
            display: inline-block;
        }

        .btn-move .btn-move-footer {
            border-top: 1px solid #eee;
            padding-top: 10px;
        }

        #stages input {
            width: 50px;
        }

        .togglebutton input {
            width: 10px !important;
        }

        .togglebutton label {
            color: #999;
        }

        .content-main hr {
            border-top-color: #777;
        }

        #select-target-body {
            text-align: center;
        }

        #select-target-body .btn {
            width: 100%;
        }

        input, select, button:not(.btn) {
            color: #000000;
        }

        .form-group .btn-just-icon.pull-right {
            margin: 0;
        }

        .has-btn-sm {
            width: calc(100% - 50px);
        }

        .content-generator {
            margin-top: 300px;
        }

        footer {
            padding-top: 20px;
        }

        .center-vertical {
            vertical-align: middle;
        }

        .modal-move {
            text-align: left;
            width: 100%;
            background-color: #FFF;
            color: #999;
            padding-top: 16px;
            padding-right: 24px;
            padding-bottom: 16px;
            padding-left: 24px;
            margin-bottom: 16px;
        }

        .dexdata-move-colsep {
            background-color: black;
            width: 5px;
            border: 1px solid black;
            text-align: center;
        }

        .dexdata-move-list {
            border: 1px solid black;
            width: auto;
            text-align: center;
        }

        .dexdata-move-desc {
            border: 1px solid black;
            width: 500px;
            text-align: center;
        }

        .dexdata-move-row {
            color: #000000;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-danger navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:onClickMenu()"><i class="material-icons">menu</i> PTU Player Tools</a>
        </div>
    </div>
</nav>

<!--    <div class="container">-->
<!--<!--        <ul class="nav nav-tabs">-->-->
<!--<!--            <li class="active"><a href="javascript:void(0)">Moves</a></li>-->-->
<!--<!--            <li><a href="javascript:void(0)">Info</a></li>-->-->
<!--<!--            <li class="disabled"><a href="javascript:void(0)">Pokédex</a></li>-->-->
<!--<!--            <li><a href="javascript:void(0)">Advanced</a></li>-->-->
<!--<!--        </ul>-->-->
<!---->
<!--        <p class="lead nav-status text-success">-->
<!--            <span class="fa fa-circle"></span> Connected to Battle-->
<!--        </p>-->
<!--    </div>-->

<!-- Initial View (Join & Select) -->
<div class="container content-init">
    <div class="well col-sm-4 col-sm-offset-4" id="init-connect">
        <h1>Enter GM ID</h1>
        <input type="text" class="form-control" id="gm-id" placeholder="GM ID"/>
        <button class="btn btn-danger btn-raised" onclick="onClickConnect();">Connect</button>
    </div>
    <div class="well col-sm-4 col-sm-offset-4" id="init-select" style="display: none;">
        <h1>Select Pokémon</h1>
        <select id="pokemonId"></select>
        <button class="btn btn-danger btn-raised" onclick="onClickLoadFromSelected();">Select</button>
    </div>
</div>

<header class="container">

</header>

<!-- Sidebar Menu -->
<div class="sidebar well col-lg-3 col-md-4 col-sm-6 col-xs-11 hidden-xs hidden-sm">
    <div class="content-header">
        <div class="row">
            <img src="http://www.ptu.panda-games.net/images/pokemon/133.png" class="pokemon-image"/>
            <h2 class="name"></h2>
        </div>

        <div class="row">
            <div class="progress">
                <div class="progress-bar progress-bar-danger bar-hp" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-info bar-exp" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>

        <button class="btn btn-danger btn-lg btn-sidebar active" onclick="onClickTab(1)">Moves</button>

        <button class="btn btn-danger btn-lg btn-sidebar active" onclick="onClickTab(2)">Info</button>

        <button class="btn btn-danger btn-lg btn-sidebar active" onclick="onClickTab(3)">Advanced</button>

        <button class="btn btn-danger btn-raised" id="btn-set-battle" onclick="addPokemonToBattle()">Join Battle
        </button>
    </div>
</div>

<!-- Main View (Battler) -->
<div class="container-fluid content-main" style="display: none;">
    <div class="col-md-8 col-lg-9 col-md-offset-4 col-lg-offset-3 tab" id="tab1">
        <div class="new-form">
            <h2>New Pokemon</h2>
            <textarea class="form-control" id="input_mon1"></textarea>
            <span class="btn-group-import">
                    <button onclick="onClickFromGenerator(1);">From Generated</button>
                    <button onclick="onClickFromSheet(1);">From Sheet</button>
                </span>
            <button class="btn-add-move" onclick="onClickLoadMoves(1);" style="display: none">Add Moves</button>
            <br/>
            <label for="pokemonId">From Box by Pokemon ID</label>
            <input type="text" id="pokemonId" onsubmit="onClickLoadFromBox()"/>
            <button onclick="onClickLoadFromBox();">Load</button>
        </div>
        <div class="moves">
            <a class="btn btn-raised btn-move btn-move-1">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
            <a class="btn btn-raised btn-move btn-move-2" style="display: none;">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
            <a class="btn btn-raised btn-move btn-move-3" style="display: none;">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
            <a class="btn btn-raised btn-move btn-move-4" style="display: none;">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
            <a class="btn btn-raised btn-move btn-move-5" style="display: none;">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
            <a class="btn btn-raised btn-move btn-move-6" style="display: none;">
                <div>
                    <h4 class="move-name"></h4>
                    <span class="pull-right">
                            <span class="label label-warning label-type"></span>
                        </span>
                </div>
                <div class="btn-move-footer">
                        <span class="pull-right move-desc" data-toggle="tooltip" data-placement="left">
                            <i class="material-icons">info</i>
                        </span>
                    <span class="move-freq"></span>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-8 col-lg-9 col-md-offset-4 col-lg-offset-3 tab" id="tab2" style="display: none;">
        <div class="row">
            <div class="col-md-4">
                <div class="card" id="pokemonStats">
                    <h4>Speed: <span id="speed">0</span></h4>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card" id="pokedexData_Basic">
                    <h3><b>Pokemon Information</b></h3>
                    <h4><b>Pokedex ID:</b> <span id="DexData_Basic_ID">{ID}</span></h4>
                    <h4><b>Species Name:</b> <span id="DexData_Basic_SpeciesName">{Name}</span></h4>
                    <h4><b>Pokemon Type:</b> <span id="DexData_Basic_Type1">{Type 1}</span> <span
                                id="DexData_Basic_TypeSep">&</span> <span id="DexData_Basic_Type2">{Type 2}</span>
                    </h4>
                    <h4><b>Pokemon Diets:</b> <span id="DexData_Basic_Diet">{Data}</span></h4>
                    <h4><b>Pokemon Habitats:</b> <span id="DexData_Basic_Habitats">{Data}</span></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="pokedexData_SBS">
                    <h3><b>Species Base Stats</b></h3>
                    <h4><b>HP:</b> <span id="DexData_Stats_HP">{HP}</span></h4>
                    <h4><b>Attack:</b> <span id="DexData_Stats_Attack">{Attack}</span></h4>
                    <h4><b>Defense:</b> <span id="DexData_Stats_Defense">{Defense}</span></h4>
                    <h4><b>Sp. Attack:</b> <span id="DexData_Stats_SpAttack">{Sp. Attack}</span></h4>
                    <h4><b>Sp. Defense:</b> <span id="DexData_Stats_SpDefense">{Sp. Defense}</span></h4>
                    <h4><b>Speed:</b> <span id="DexData_Stats_Speed">{Speed}</span></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="pokedexData_Breeding">
                    <h3><b>Breeding Information</b></h3>
                    <h4><b>Gender Ratio:</b> (<span style="color: #42aaf4"><span id="DexData_Breed_Male">{Value}</span>% Male</span>,
                        <span style="color: #f441e2"><span id="DexData_Breed_Female">{Value}</span>% Female</span>)</h4>
                    <h4><b>Hatching Rate:</b> <span id="DexData_Breed_HatchRate">{Value}</span></h4>
                    <h4><b>Egg Groups:</b> <span id="DexData_Breed_EggGroups">{Groups}</span></h4>
                </div>
            </div>
        </div>
        <br>
        <div class="row dexdata-move-row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <!-- Moves Learnt From Level Up Go Here-->
                <div class="panel panel-default">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                Level Up Moves
                            </h4>
                        </div>
                    </a>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <table class="table" id="DexData_Moves_LVup">
                                <tr>
                                    <th style="width: auto">Move Name</th>
                                    <th>Description</th>
                                    <th>Move Type</th>
                                    <th>Move Class</th>
                                    <th>Move DB</th>
                                    <th>Move AC</th>
                                    <th>Level Learn</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Moves Learnt From Tutor Go Here -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                Tutor Moves
                            </h4>
                        </div>
                    </a>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <table class="table" id="DexData_Moves_Tutor">
                                <tr>
                                    <th>Move Name</th>
                                    <th>Description</th>
                                    <th>Move Type</th>
                                    <th>Move Class</th>
                                    <th>Move DB</th>
                                    <th>Move AC</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Moves Learnt From Tutor Go Here -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                Egg Moves
                            </h4>
                        </div>
                    </a>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <div class="panel-body">
                            <table class="table" id="DexData_Moves_Egg">
                                <tr>
                                    <th>Move Name</th>
                                    <th>Description</th>
                                    <th>Move Type</th>
                                    <th>Move Class</th>
                                    <th>Move DB</th>
                                    <th>Move AC</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Moves Learnt From Tutor Go Here -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                TM/HM Moves
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFour">
                        <div class="panel-body">
                            <table class="table" id="DexData_Moves_TM">
                                <tr>
                                    <th>Move Name</th>
                                    <th>Description</th>
                                    <th>Move Type</th>
                                    <th>Move Class</th>
                                    <th>Move DB</th>
                                    <th>Move AC</th>
                                    <th>TM/HM ID</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pokemon Abilitys Go Here -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                Abilities
                            </h4>
                        </div>
                    </a>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFive">
                        <div class="panel-body">
                            <table class="table" id="DexData_Abilities">
                                <tr>
                                    <th>Ability Name</th>
                                    <th>Effect</th>
                                    <th>Trigger</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pokemon Evolutions and Forms Go Here -->
                <div class="panel panel-default">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                       href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        <div class="panel-heading" role="tab" id="headingSix">
                            <h4 class="panel-title">
                                Evolutions and Forms
                            </h4>
                        </div>
                    </a>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingSix">
                        <div class="panel-body">
                            <p>This Feature is in development...</p>
                            <p>Are they out of order!?!? i think they may be... Sorry for that :p</p>
                            <table class="table" id="DexData_EvoForms">
                                <tr>
                                    <th></th>
                                    <th>Pokemon Name</th>
                                    <th>Evolution Stage</th>
                                    <th>Criteria</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="col-md-8 col-lg-9 col-md-offset-4 col-lg-offset-3 tab" id="tab3" style="display: none;">
        <div class="row">
            <div class="col-md-4">
                <div class="card" id="stages">
                    <h4>Modifiers</h4>
                    <label for="stage-atk">Attack Stage</label>
                    <input type="number" id="stage-atk" value="0" data-target="stage_atk"/><br/>
                    <label for="stage-def">Defense Stage</label>
                    <input type="number" id="stage-def" value="0" data-target="stage_def"/><br/>
                    <label for="stage-spatk">Special Atk Stage</label>
                    <input type="number" id="stage-spatk" value="0" data-target="stage_spatk"/><br/>
                    <label for="stage-spdef">Special Def Stage</label>
                    <input type="number" id="stage-spdef" value="0" data-target="stage_spdef"/><br/>
                    <label for="stage-speed">Speed Stage</label>
                    <input type="number" id="stage-speed" value="0" data-target="stage_speed"/><br/>
                    <label for="stage-acc">Accuracy Bonus</label>
                    <input type="number" id="stage-acc" value="0" data-target="stage_acc"/><br/>
                    <label for="stage-eva">Evasion Bonus</label>
                    <input type="number" id="stage-eva" value="0" data-target="stage_eva"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4>Afflictions</h4>
                    <div id="afflictions"></div>
                    <div class="form-group label-floating">
                        <button class="btn btn-just-icon btn-round btn-danger pull-right" id="btn-afflict">
                            <i class="material-icons">add</i>
                        </button>
                        <label class="control-label" for="input-afflict">Add an Affliction</label>
                        <input type="text" class="form-control has-btn-sm" id="input-afflict"
                               onclick="alert('feature is work in progress')">
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <h4>Damage/Heal</h4>
                    <div>
                        <button class="btn btn-danger btn-raised pull-right" id="btn-do-dmg">GO</button>
                        <label class="text-info" for="do-dmg">Inflict Damage</label><br/>
                        <input type="number" id="do-dmg"/>
                        <select id="dmg-type" title="Type"></select>
                        <div class="togglebutton">
                            <label>
                                <input type="checkbox" title="Special" id="do-dmg-sp"/> Special
                            </label>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <button class="btn btn-danger btn-raised pull-right" id="btn-do-heal">GO</button>
                        <label class="text-info" for="do-heal">Heal</label><br/>
                        <input type="number" id="do-heal"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal dialog for picking target -->
<div class="modal fade" id="modalTarget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-move">
            <h4 class="move-name"></h4>
            <p class="move-desc"></p>
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-danger" id="impMonLabel">Select Target</h3>
            </div>

            <div class="modal-body" id="select-target-body">
                <button class="btn btn-simple btn-danger btn-lg" data-target="other">Other Target</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Imports -->
<script src="http://cdn.peerjs.com/0.3/peer.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.min.css" rel="stylesheet"
      type="text/css"/>
<script>
    //Remove JQuery UI conflicts with Bootstrap
    $.widget.bridge('uibutton', $.ui.button);
    $.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="dist/snackbar.min.js"></script>
<script src="js/material.min.js"></script>

<script src="js/script.js"></script>
<script src="js/pokemon.js"></script>
<?php if (key_exists("host", $_GET)) : ?>
    <script>
        $(function () {
            $("#gm-id").val('<?php echo $_GET['host']?>');
            onClickConnect();
        });
    </script>
<?php endif; ?>
</body>
</html>