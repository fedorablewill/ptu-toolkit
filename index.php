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
    <link href="css/material-dashboard.css" rel="stylesheet">

    <style>
        @keyframes loading-pulse-50px {
            0%   {height: 0;}
            100% {height: 50px;}
        }

        body::before {
            content: "";
            display: block;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: -10;
            background: url('img/pixel-art-pokemon-wallpaper-2.jpg') no-repeat center bottom;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover !important;
        }

        body {
            color: white;
            padding-top: 90px;
            padding-bottom: 90px;
        }

        .navbar {
            border: 0 !important;
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

        .navbar-fixed-bottom .nav-bottom-item {
            padding: 0;
        }

        .navbar-fixed-bottom .nav-bottom-item .btn {
            width: 100%;
            padding: 13px 0;
            color: #EFEFEF;
        }

        .navbar-fixed-bottom .nav-bottom-item.active .btn {
            color: #faaca6;
        }

        .navbar-fixed-bottom .nav-bottom-item .material-icons {
            font-size: 24px;
            width: 24px;
            margin-right: 8px;
        }

        .navbar-fixed-bottom .nav-bottom-item.active::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -8px;
            height: 4px;
            background: #faaca6;
        }

        .nav-bottom-item:not(.active) .nav-bottom-label {
            display: none;
        }

        .sidebar-nav {
            height: 100%;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 0;
            background-color: #ffffff;
            border-radius: 0;
            z-index: 1010;
            box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.42),
            0 3px 10px 0px rgba(0, 0, 0, 0.12),
            0 4px 5px -3px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav .btn-sidebar {
            width: 100%;
        }

        .nav-tabs {
            background: none !important;
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

        .content-header {
            padding: 10px;
        }

        .sidebar-nav .name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow:ellipsis;
            max-width: 100%;
            color: #4f4f4f;
            margin: 0;
        }

        .sidebar-nav .progress {
            height: 8px;
        }

        .sidebar-header {
            width: 100%;
            padding-top: 100px;
            background-color: #f3f3f3;
            display: inline-block;
        }

        .content-header .name small {
            color: #afafaf;
        }

        #data1, #data2, #data3, #data4 {
            display: none;
        }

        .moves, .actions {
            display: grid;
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
            margin-bottom: 0;
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

        a, a:hover, a:focus {
            color: #03a9f4;
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

        .modal-move .move-desc {
            text-align: center;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
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
            padding: 0 15px;
        }

        .row-dex-cards .card {
            min-height: 275px;
        }

        .card-content {
            position: inherit !important;
        }

        .card-avatar {
            width: 130px;
            height: 130px;
            line-height: 130px;
            background: #ffffff;
        }

        .card-avatar img {
            vertical-align: middle;
            height: 70%;
            width: 70%;
            object-fit: contain;
        }

        .card-profile {
            background: linear-gradient(60deg, #ef5350, #e53935);
            box-shadow: 0 12px 20px -10px rgba(244, 67, 54, 0.28),
                0 4px 20px 0px rgba(0, 0, 0, 0.12),
                0 7px 8px -5px rgba(244, 67, 54, 0.2);
        }

        .card-profile h3 {
            color: #ffffff;
            margin-top: 0;
        }

        .card-profile .category {
            color: #cfcfcf !important;
            margin: 0;
        }

        .loading-holder {
            text-align: center;
            min-height: 86px;
            background-color: #efefef;
            padding: 15px;
        }

        .loading-50px {
            animation: loading-pulse-50px;
            background: url('img/ic-loading.png') center top;
            background-size: 50px 50px;
            width: 50px;
            display: inline-block;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        .grid-row {
            display: flex;
        }

        .grid-piece {
            position: relative;
        }

        .grid{
            display: none;
            background-color: #eaeaea;
            border: 1px solid rgb(142, 142, 142);
        }

        hr.sm {
            max-width: 300px;
            width: 80%;
            margin-top: 0;
        }

        .snackbar:not(.snackbar-opened) {
            z-index: -200;
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

<nav class="navbar navbar-danger navbar-fixed-bottom">
    <div class="container">
        <div class="col-xs-4 nav-bottom-item active">
            <button class="btn btn-simple" data-toggle="tab" data-target="1">
                <i class="material-icons">directions_walking</i><span class="nav-bottom-label">Actions</span>
            </button>
        </div>
        <div class="col-xs-4 nav-bottom-item">
            <button class="btn btn-simple" data-toggle="tab" data-target="3">
                <i class="material-icons">build</i><span class="nav-bottom-label">Manage</span>
            </button>
        </div>
        <div class="col-xs-4 nav-bottom-item">
            <button class="btn btn-simple" data-toggle="tab" data-target="2">
                <i class="material-icons">assessment</i><span class="nav-bottom-label">Info</span>
            </button>
        </div>
    </div>
</nav>
<div class="container content-init">
    <div class="well col-sm-4 col-sm-offset-4" id="init-connect">
        <h2>Enter GM ID</h2>
        <input type="text" class="form-control" id="gm-id" placeholder="GM ID"/>
        <button class="btn btn-danger btn-raised" onclick="onClickConnect();">Connect</button>
    </div>
    <div class="well col-sm-4 col-sm-offset-4" id="init-select" style="display: none;">
        <h2>Select Character</h2>
        <select id="pokemonId"></select>
        <button class="btn btn-danger btn-raised" onclick="onClickLoadFromSelected();">Select</button>
    </div>
</div>

<header class="container">

</header>

    <!-- Sidebar Menu -->
    <div class="sidebar-nav well col-lg-3 col-md-4 col-sm-6 col-xs-11 hidden-xs hidden-sm">
        <div class="sidebar-header">
            <div class="col-xs-12">
                <h3 class="name">Booplesnoot the Great and Long Named</h3>
                <p class="text-muted level">Level 8</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger bar-hp" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-info bar-exp" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
            </div>
        </div>
        <div class="content-header">

            <button class="btn btn-danger btn-raised" id="btn-set-battle" onclick="addPokemonToBattle()">Join Battle
            </button>

            <button class="btn btn-danger btn-raised" onclick="onClickConnect()">Reconnect</button>
        </div>
    </div>

    <!-- Main View (Battler) -->
    <div class="container-fluid content-main" style="display: none;">
        <div class="col-md-8 col-lg-9 col-md-offset-4 col-lg-offset-3 tab" id="tab1">
            <h2 class="text-center text-muted">Moves</h2>
            <hr class="sm"/>
            <div class="moves">

            </div>
            <h2 class="text-center text-muted">Other Actions</h2>
            <hr class="sm"/>
            <div class="actions">
                <a class="btn btn-raised btn-move btn-action-shift">
                    <div>
                        <h4 class="move-name">Shift Action</h4>
                    </div>
                    <div class="btn-move-footer">
                        <span class="move-freq"><strong>FEATURE COMING SOON</strong></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-8 col-lg-9 col-md-offset-4 col-lg-offset-3 tab" id="tab2" style="display: none;">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <div class="card card-profile" id="pokemonStats">
                        <div class="card-avatar">
                            <img src="img/pokemon/001.gif" class="pokemon-image" />
                        </div>
                        <div class="content">
                            <h6 class="category text-gray"><span id="DexData_Basic_ID">{ID}</span></h6>
                            <h3><span id="DexData_Basic_SpeciesName">{Name}</span></h3>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="card" id="pokedexData_Basic">
                        <div class="card-header" data-background-color="red">
                            <h4 class="title">Pokemon Information</h4>
                        </div>
                        <div class="card-content">
                            <p>
                                <b>Pokemon Type:</b> <span id="DexData_Basic_Type1">{Type 1}</span>
                                <span id="DexData_Basic_TypeSep">&amp;</span> <span id="DexData_Basic_Type2">{Type 2}</span>
                            </p>
                            <p><b>Pokemon Diets:</b> <span id="DexData_Basic_Diet">{Data}</span></p>
                            <p><b>Pokemon Habitats:</b> <span id="DexData_Basic_Habitats">{Data}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" id="pokedexData_SBS">
                        <div class="card-header card-chart" data-background-color="red">
                            <div class="ct-chart" id="graphBaseStats"></div>
                        </div>
                        <div class="card-content">
                            <h4 class="title">Species Base Stats</h4>
                            <div class="col-xs-6">
                                <p><b>HP:</b> <span id="DexData_Stats_HP">{HP}</span></p>
                                <p><b>Attack:</b> <span id="DexData_Stats_Attack">{Attack}</span></p>
                                <p><b>Defense:</b> <span id="DexData_Stats_Defense">{Defense}</span></p>
                            </div>
                            <div class="col-xs-6">
                                <p><b>Sp. Attack:</b> <span id="DexData_Stats_SpAttack">{Sp. Attack}</span></p>
                                <p><b>Sp. Defense:</b> <span id="DexData_Stats_SpDefense">{Sp. Defense}</span></p>
                                <p><b>Speed:</b> <span id="DexData_Stats_Speed">{Speed}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" id="pokedexData_Breeding">
                        <div class="card-header" data-background-color="red">
                            <h4 class="title">Breeding Information</h4>
                        </div>
                        <div class="card-content">
                            <p><b>Gender Ratio:</b> (<span style="color: #42aaf4"><span id="DexData_Breed_Male">{Value}</span>% Male</span>,
                                <span style="color: #f441e2"><span id="DexData_Breed_Female">{Value}</span>% Female</span>)</p>
                            <p><b>Hatching Rate:</b> <span id="DexData_Breed_HatchRate">{Value}</span></p>
                            <p><b>Egg Groups:</b> <span id="DexData_Breed_EggGroups">{Groups}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row dexdata-move-row">
                <div class="card" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="card-header" data-background-color="red">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="active">
                                        <a href="#dex-tab1" data-toggle="tab">
                                            <i class="material-icons">list</i>
                                            Level Up Moves
                                            <div class="ripple-container"></div></a>
                                    </li>
                                    <li class="">
                                        <a href="#dex-tab2" data-toggle="tab">
                                            <i class="material-icons">list</i>
                                            Egg Moves
                                            <div class="ripple-container"></div></a>
                                    </li>
                                    <li class="">
                                        <a href="#dex-tab3" data-toggle="tab">
                                            <i class="material-icons">list</i>
                                            TM/HM Moves
                                            <div class="ripple-container"></div></a>
                                    </li>
                                    <li class="">
                                        <a href="#dex-tab5" data-toggle="tab">
                                            <i class="material-icons">list</i>
                                            Abilities
                                            <div class="ripple-container"></div></a>
                                    </li>
                                    <li class="">
                                        <a href="#dex-tab6" data-toggle="tab">
                                            <i class="material-icons">view_list</i>
                                            Evolutions/Forms
                                            <div class="ripple-container"></div></a>
                                    </li>
                                    <li class="">
                                        <a href="#dex-tab7" data-toggle="tab">
                                            <i class="material-icons">view_list</i>
                                            Mega Evolutions
                                            <div class="ripple-container"></div></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        <div class="tab-content">
                            <div class="tab-pane active" id="dex-tab1">
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
                            <div class="tab-pane" id="dex-tab2">
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
                            <div class="tab-pane" id="dex-tab3">
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
                            <div class="tab-pane" id="dex-tab4">
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
                            <div class="tab-pane" id="dex-tab5">
                                <table class="table" id="DexData_Abilities">
                                    <tr>
                                        <th>Ability Name</th>
                                        <th>Effect</th>
                                        <th>Trigger</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="dex-tab6">
                                <table class="table" id="DexData_EvoForms">
                                    <tr>
                                        <th></th>
                                        <th>Pokemon Name</th>
                                        <th>Type</th>
                                        <th>Evolution Stage</th>
                                        <th>Criteria</th>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="dex-tab7">
                                <table class="table" id="DexData_MegaForms">
                                    <tr>
                                        <th></th>
                                        <th>Pokemon Name</th>
                                        <th>Pokemon Type</th>
                                        <th>Abilities</th>
                                        <th style="width: 15px">HP</th>
                                        <th style="width: 15px">Attack</th>
                                        <th style="width: 15px">Defence</th>
                                        <th style="width: 15px">Sp. Attack</th>
                                        <th style="width: 15px">Sp. Defence</th>
                                        <th style="width: 15px">Speed</th>
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
                        <div class="card-content">
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
                            <h4>Speed: <span id="speed">0</span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content">
                            <h4>Afflictions</h4>
                            <div id="afflictions"></div>
                            <div class="form-group label-floating">
                                <button class="btn btn-just-icon btn-round btn-danger pull-right" id="btn-afflict">
                                    <i class="material-icons">add</i>
                                </button>
                                <label class="control-label" for="input-afflict">Add an Affliction</label>
                                <input type="text" class="form-control has-btn-sm" id="input-afflict"
                                       onclick="alert('Feature is work in progress. Implemeted afflictions: Burned, ' +
                                        'Poison, Paralysis, Poisoned, Confused, Fainted.')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-content">
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
    </div>

    <!-- Modal dialog for picking target -->
    <div class="modal fade" id="modalTarget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-move">
                <h4 class="move-name" style="color: rgb(217, 178, 71);">Sand Attack</h4>
                <p class="move-desc">Status Move. The target is Blinded until the end of their next turn.</p>
                <div class="move-stats">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-type">Move Type</label>
                                <select class="form-control" id="move-type" data-populate="type" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-class">Move Class</label>
                                <select class="form-control" id="move-class" required>
                                    <option></option>
                                    <option>Physical</option><option>Special</option><option>Status</option><option>Static</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-db">Damage Base</label>
                                <input class="form-control" id="move-db" min="1" max="28" value="7" required="" type="number">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-ac">Accuracy Check</label>
                                <input class="form-control" id="move-ac" min="1" max="20" value="2" required="" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-range">Range</label>
                                <input class="form-control" id="move-range" value="Cone 2" disabled="" type="text">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-crit">Crits On</label>
                                <input class="form-control" id="move-crit" min="1" max="20" value="20" required="" type="number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="move-extras hidden">
                    <div class="togglebutton">
                        <label>
                            <input id="genmon-is-wild" checked="" type="checkbox"><span class="toggle"></span> Add Modifiers
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-content hidden" id="modalTarget-select">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-danger" id="impMonLabel">Select Target</h3>
                </div>

                <div class="modal-body" id="select-target-body">
                    <button class="btn btn-simple btn-danger btn-lg" data-target="other">Other Target</button>
                </div>

                <div class="modal-body" id="move-advanced-body">

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-dmg-bonus">Damage Bonus</label>
                                <input class="form-control" type="number" value="0" id="move-dmg-bonus" />
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="move-acc-bonus">Accuracy Bonus</label>
                                <input class="form-control" type="number" value="0" id="move-acc-bonus" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-content" id="modalTarget-join">

                <div class="modal-body" id="select-target-body">
                    <button class="btn btn-danger btn-raised btn-lg" id="btn-set-battle" onclick="addPokemonToBattle()">
                        Join Battle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- DEBUG Modal dialog for picking target -->
    <div class="modal fade" id="modalTargetDEBUG" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                    <div class="battle-grid"></div>
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
    <script src="js/chartist.min.js"></script>
    <script src="js/material.min.js"></script>
    <script src="js/material-dashboard.js"></script>

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