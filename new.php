<!doctype html>
<html>
<head>

    <title>PTU Random Pokemon Battle</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,900italic,900,400italic,100,700italic,300,700,500italic,100italic,300italic,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="dist/css/bootstrap-material-design.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">

    <style>
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
        }

        #stages input {
            width: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-9" id="mon1">
            <div class="new-form">
                <h2>New Pokemon</h2>
                <textarea class="form-control" id="input_mon1"></textarea>
                <button onclick="onClickFromHTML(1);">From HTML</button>
            </div>
            <div class="pokemon-enemy" style="display: none;">
                <h2 class="name"></h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                </div>
                <div class="effects"></div>
            </div>
            <div class="moves">
                <a class="btn btn-raised btn-move btn-move-1">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq"></span></small>
                    <br/>
                    <p class="move-desc"></p>
                </a>
                <a class="btn btn-raised btn-move btn-move-2" style="display: none;">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq"></span></small>
                    <br/>
                    <span class="move-desc"></span>
                </a>
                <a class="btn btn-raised btn-move btn-move-3" style="display: none;">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq"></span></small>
                    <br/>
                    <span class="move-desc"></span>
                </a>
                <a class="btn btn-raised btn-move btn-move-4" style="display: none;">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq">Scene</span></small>
                    <br/>
                    <span class="move-desc"></span>
                </a>
                <a class="btn btn-raised btn-move btn-move-5" style="display: none;">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq">Scene</span></small>
                    <br/>
                    <span class="move-desc"></span>
                </a>
                <a class="btn btn-raised btn-move btn-move-6" style="display: none;">
                    <div>
                        <strong class="move-name pull-left"></strong>
                        <span class="pull-right"><img src="http://www.ptu.panda-games.net/images/types/11.png"/></span>
                    </div>
                    <br/>
                    <small>Frequency: <span class="move-freq">Scene</span></small>
                    <br/>
                    <span class="move-desc"></span>
                </a>
            </div>
        </div>
        <div class="col-md-3" id="stages">
            <h4>Speed: <span id="speed">0</span></h4>
            <hr/>
            <label for="do-dmg">Inflict Damage</label><br/>
            <input type="number" id="do-dmg"/>
            <select id="dmg-type" title="Type"></select>
            <input type="checkbox" title="Special" id="do-dmg-sp"/> Special
            <button class="btn btn-primary" id="btn-do-dmg">GO</button>
            <hr/>
            <label for="stage-atk">Attack Stage</label>
            <input type="number" id="stage-atk" value="0" /><br/>
            <label for="stage-def">Defense Stage</label>
            <input type="number" id="stage-def" value="0" /><br/>
            <label for="stage-spatk">Special Atk Stage</label>
            <input type="number" id="stage-spatk" value="0" /><br/>
            <label for="stage-spdef">Special Def Stage</label>
            <input type="number" id="stage-spdef" value="0" /><br/>
            <label for="stage-speed">Speed Stage</label>
            <input type="number" id="stage-speed" value="0" />
        </div>
    </div>
</div>

<div id="data1"></div>
<div id="data2"></div>
<div id="data3"></div>
<div id="data4"></div>

<!-- JavaScript Imports -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script src="dist/snackbar.min.js"></script>
<script src="dist/js/ripples.min.js"></script>
<script src="dist/js/material.min.js"></script>
<script>
    //Remove JQuery UI conflicts with Bootstrap
    $.widget.bridge('uibutton', $.ui.button);
    $.widget.bridge('uitooltip', $.ui.tooltip);
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/bootstrap-toolkit.min.js"></script>

<script src="js/pokemon.js"></script>
</body>
</html>