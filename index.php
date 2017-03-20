<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PTU Tools</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="css/material-kit.css" rel="stylesheet">

    <style>
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
        }

        .content-header .name small {
            color: #afafaf;
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

        .content-main hr {
            border-top-color: #777;
        }

        input, select, button:not(.btn) {
            color: #000000;
        }

        .content-generator {
            margin-top: 300px;
        }

        footer {
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-danger navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0)">PTU Pokémon Tools</a>
            </div>
        </div>
    </nav>

    <div class="container">
<!--        <ul class="nav nav-tabs">-->
<!--            <li class="active"><a href="javascript:void(0)">Moves</a></li>-->
<!--            <li><a href="javascript:void(0)">Info</a></li>-->
<!--            <li class="disabled"><a href="javascript:void(0)">Pokédex</a></li>-->
<!--            <li><a href="javascript:void(0)">Advanced</a></li>-->
<!--        </ul>-->

        <p class="lead nav-status text-success">
            <span class="fa fa-circle"></span> Connected to Battle
        </p>

        <a class="btn btn-raised pull-right nav-pokemon">
            <div class="row">
                <span id="dex-species">#DEX - Species</span>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger bar-hp" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-info bar-exp" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
            </div>
        </a>
    </div>

    <!-- Initial View (Join & Select) -->
    <div class="container content-init">
        <div class="well col-sm-4 col-sm-offset-4" id="init-connect">
            <h1>Enter GM ID</h1>
            <input type="text" class="form-control" id="gm-id" placeholder="GM ID" />
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

    <!-- Main View (Battler) -->
    <div class="container content-main" style="display: none;">
        <div class="row content-header">
            <img src="http://www.ptu.panda-games.net/images/pokemon/133.png" class="pokemon-image" />
            <h2 class="name"></h2>
        </div>
        <div class="row well">
            <!-- Toolbar -->
            <div class="col-md-3 toolbar">
                <h4>Speed: <span id="speed">0</span></h4>
                <hr/>
                <div>
                    <button class="btn btn-danger btn-raised" id="btn-set-battle" onclick="addPokemonToBattle()">Join Battle</button>
                </div>
                <hr style="margin-bottom: 0;"/>
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseAdv" aria-expanded="false" aria-controls="collapseExample">
                    ADVANCED <i class="material-icons">arrow_drop_down</i>
                </button>
                <div class="collapse" id="collapseAdv">
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
                    <hr/>
                    <div id="stages">
                        <label for="stage-atk">Attack Stage</label>
                        <input type="number" id="stage-atk" value="0" data-target="stage_atk" /><br/>
                        <label for="stage-def">Defense Stage</label>
                        <input type="number" id="stage-def" value="0" data-target="stage_def" /><br/>
                        <label for="stage-spatk">Special Atk Stage</label>
                        <input type="number" id="stage-spatk" value="0" data-target="stage_spatk" /><br/>
                        <label for="stage-spdef">Special Def Stage</label>
                        <input type="number" id="stage-spdef" value="0" data-target="stage_spdef" /><br/>
                        <label for="stage-speed">Speed Stage</label>
                        <input type="number" id="stage-speed" value="0" data-target="stage_speed" /><br/>
                        <label for="stage-acc">Accuracy Bonus</label>
                        <input type="number" id="stage-acc" value="0" data-target="stage_acc" /><br/>
                        <label for="stage-eva">Evasion Bonus</label>
                        <input type="number" id="stage-eva" value="0" data-target="stage_eva" />
                    </div>
                </div>
            </div>
            <!-- Importing & Moves -->
            <div class="col-md-9" id="mon1">
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
                    <input type="text" id="pokemonId" onsubmit="onClickLoadFromBox()" />
                    <button onclick="onClickLoadFromBox();">Load</button>
                </div>
                <div class="pokemon-enemy" style="display: none;">
                    <div class="effects"></div>
                    <label for="target">Select Target</label>
                    <select id="target"><option value="other">Other Target</option></select>
                </div>
                <div class="moves">
                    <a class="btn btn-raised btn-move btn-move-1">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq"></span></small>
                        <br/>
                        <p class="move-desc"></p>
                    </a>
                    <a class="btn btn-raised btn-move btn-move-2" style="display: none;">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq"></span></small>
                        <br/>
                        <span class="move-desc"></span>
                    </a>
                    <a class="btn btn-raised btn-move btn-move-3" style="display: none;">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq"></span></small>
                        <br/>
                        <span class="move-desc"></span>
                    </a>
                    <a class="btn btn-raised btn-move btn-move-4" style="display: none;">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq">Scene</span></small>
                        <br/>
                        <span class="move-desc"></span>
                    </a>
                    <a class="btn btn-raised btn-move btn-move-5" style="display: none;">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq">Scene</span></small>
                        <br/>
                        <span class="move-desc"></span>
                    </a>
                    <a class="btn btn-raised btn-move btn-move-6" style="display: none;">
                        <div>
                            <strong class="move-name pull-left"></strong>
                            <span class="pull-right">
                                <img class="img-class" src="http://www.ptu.panda-games.net/images/types/Status.png"/>
                                <img class="img-type" src="http://www.ptu.panda-games.net/images/types/11.png"/>
                            </span>
                        </div>
                        <br/>
                        <small>Frequency: <span class="move-freq">Scene</span></small>
                        <br/>
                        <span class="move-desc"></span>
                    </a>
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

    <script src="js/script.js"></script>
    <script src="js/pokemon.js"></script>
</body>
</html>