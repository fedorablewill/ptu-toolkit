<?php

/**
 * Pokemon Generator
 */
class PtuGenerator
{
    const JSON_DATA_PATH = "../../data/";

    private $genType = array();
    //$genType=[["Type","Fire"]];
    //$genType=[["Habitat","Urban"]];
    //$genType=[["Generation",1],["Type","Ice"]];
    //$genType=[["Specific","Bulbasaur"]];

    //$legend = Boolean; if FALSE, no legndaries are allowed to generate
    private $legend = TRUE;

    //$levelRange = two-entry array, with first entry the lower bound and second the upper bound for the level range, inclusive.
    private $levelRange=[1,100];

    //$nature: If "Random", will generate random nature; otherwise, the nature for the mon.
    private $nature = "Random";

    //$location: This string indicates the location of the battle, and will be the value of the 'discovery' field on the Pokémon
    private $location = "";

    //$gender: If a particular gender (presumably "Male" or "Female") is desired, set this string to that value. Otherwise, let it be the empty string.
    private $gender = "";

    //$statWeights: An array of numbers with with the six stats as keys. This is used for randomly selecting stats, BSR allowing. A 0 for a stat should completely remove it from being selected to be added to.
    //The default, unweighted version is as shown below:
    private $statWeights = ["HP"=>1,"Attack"=>1,"Defense"=>1,"SpecialAttack"=>1,"SpecialDefense"=>1,"Speed"=>1];

    //$tutorRange: Array of lower and upper bounds on the amount of TM, HM, and Tutor moves allowed to generate per 'mon. Upper limit should be at most 3, but some features, namely Lifelong Learning, boost this limit;
    private $tutorRange = [0,3];

    //$eggRange: Array of lower and upper bounds on the amount of Egg moves allowed to generate per 'mon
    private $eggRange = [0,3];

    //$topPercentage: If a Pokémon's Trainer has top percentage, i.e. $topPercentage[0]==TRUE, they gain extra TP and boosted Base Stats on Levels divisible by 5. The second entry indicates the level at which it was caught, and thus how many instances of Top Percentage it has been affected by.
    private $topPercentage = [FALSE, 0];

    //$expandHorizons: If TRUE, the trainer has the Mentor feature Expand Horizons, giving an extra 3 TP to the 'mon.
    private $expandHorizons = FALSE;

    //$guidance: If TRUE, the trainer has the Mentor feature Guidance, giving an extra +1 to the Move List Limit;
    private $guidance = FALSE;

    //$saveTP: The number of TP the 'mon should have left unspent at the end of generation. Default is 0, allowing as much TP to be spent as can be.
    private $saveTP = 0;

    //$enduringSoul: If TRUE, the trainer is an Enduring Soul, allowing HP to break BSR:
    private $enduringSoul = FALSE;

    //$statAce: A list of non-HP stats which the trainer has the corresponding Stat Ace base feature for. Empty means the trainer is not a Stat Ace.
    private $statAce = [];

    //september: If TRUE, September Playtest rules are in effect, in this case limiting tutor and egg moves.
    private $september = TRUE;

    public function __construct($type, $habitat, $generation, $specific, $doLegendary, $minLevel, $maxLevel, $nature,
                                $location, $gender, $statWeights, $minTM, $maxTM, $minEM, $maxEM, $isTopPercent,
                                $levelCaught, $doExpandHorizons, $hasGuidance, $saveTP, $enduringSoul, $statAce, $september) {

        if (!is_null($specific))
            $this->genType[0] = ["Specific", $specific];
        elseif (is_null($type) && is_null($habitat) && is_null($generation))
            $this->genType[0] = ["All", ""];
        else {
            if (!is_null($type))
                array_push($this->genType, ["Type", $type]);
            if (!is_null($habitat))
                array_push($this->genType, ["Habitat", $habitat]);
            if (!is_null($generation))
                array_push($this->genType, ["Generation", $generation]);
        }

        $this->legend = $doLegendary;
        $this->levelRange = [$minLevel, $maxLevel];
        $this->nature = $nature;
        $this->location = $location;
        $this->gender = $gender;
        $this->statWeights = $statWeights;
        $this->tutorRange = [$minTM, $maxTM];
        $this->eggRange = [$minEM, $maxEM];
        $this->topPercentage = [$isTopPercent, $levelCaught];
        $this->expandHorizons = $doExpandHorizons;
        $this->guidance = $hasGuidance;
        $this->saveTP = $saveTP;
        $this->enduringSoul = $enduringSoul;
        $this->statAce = $statAce;
        $this->september = $september;
    }

    public function start() {
        //Get JSON data
        $fname = self::JSON_DATA_PATH ."/ptu_pokedex_1_05.json";
        $bigdex = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
        $dex = $bigdex;
        $fname = self::JSON_DATA_PATH ."/natures.json";
        $natureList = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
        $fname = self::JSON_DATA_PATH ."/experience.json";
        $exp = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
        $fname = self::JSON_DATA_PATH ."/moves.json";
        $moveData = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();

//Get rid of mon that are illegal for the given level range
        $dex = $this->levelCheck($dex,$this->levelRange[1]);

//Iterates over $genType for multi-step generation
        foreach ($this->genType as &$value){
            $dex = $this->genstep($dex,$value[0],$value[1],$this->levelRange[1]);
        }

//Remove legendaries if not allowed
        if (!$this->legend){
            $dex = $this->noLegend($dex);
        }

//Throw exception if $dex is an empty array
        if ($dex === []){
            throw new Exception("Critera too limited; no such 'mon exist.");
        }
//Selects single entry from limited dex.
        $num = array_rand($dex);
        $dex = $dex[$num];
//Making $export, with "name" = species name, and "dex" the dex number;
        $export = ["name" => $dex["Species"],"dex"=>(int)$num];

//Setting $export["type"]
        if (sizeof($dex["Types"])==1){
            $export["type"]=$dex["Types"][0];
        } else {
            $s = "";
            foreach($dex["Types"] as &$value){
                $s = $s.$value." / ";
            }
            $export["type"] = substr($s,0,-3);
        }

//No random Held Item generation atm, so setting $export["held-item"] to an empty string.
        $export["held-item"] = "";

//Setting lower bound on level to minimum value for the 'mon
        $stip = $dex["EvolutionStages"];
        foreach($stip as $key => $value){
            if ($value["Species"]==$dex["Species"]){
                $num = $key;
                break;
            }
        }
        $stip = $stip[$num]["Criteria"];
        if (strpos($stip,"Minimum")!==FALSE){
            $stip = (int)substr($stip,strpos($stip,"Minimum")+1);
            if ($stip<$this->levelRange[0]){
                $this->levelRange[0]=$stip;
            }
        }

//Picking level for the 'mon
        $level = mt_rand($this->levelRange[0],$this->levelRange[1]);

//Putting level and minimum EXP in $export
        $export["level"] = (int)$level;
        $export["EXP"] = $exp[$level];

//Picking abilities
        $abilities = $this->abilitySelect($dex,$level);

//Picking Nature
        if ($this->nature=="Random"){
            $this->nature = array_rand($natureList);
        }
//echo nl2br($nature."\n\n");
        $export["nature"] = $this->nature;

//Checking if species has gender
        if (!$dex["BreedingData"]["HasGender"]){
            $export["gender"]="Genderless";
        } else {
            //Checking if gender is pre-set
            if ($this->gender != ""){
                $export["gender"]=$this->gender;
            } else {
                //Selecting gender based on species MaleChance
                $num = mt_rand() / mt_getrandmax();
                if ($num < $dex["BreedingData"]["MaleChance"]){
                    $export["gender"]="Male";
                } else {
                    $export["gender"]="Female";
                }
            }
        }

//Setting discovery location
        $export["discovery"]=$this->location;

//Setting base stats based on species baseline and nature
        $baseStats = $dex["BaseStats"];
        if ($natureList[$this->nature]["Raise"]=="HP"){
            $baseStats["HP"] = $baseStats["HP"] + 1;
        } else {
            $baseStats[$natureList[$this->nature]["Raise"]] = $baseStats[$natureList[$this->nature]["Raise"]] + 2;
        }
        if ($natureList[$this->nature]["Lower"]=="HP"){
            $baseStats["HP"] = max($baseStats["HP"] - 1,1);
        } else {
            $baseStats[$natureList[$this->nature]["Lower"]] = max($baseStats[$natureList[$this->nature]["Lower"]] - 2,1);
        }

//Calculating $TP
        $TP = 1 + floor($level/5);

//Checking if Top Percentage is active
        if ($this->topPercentage[0]){
            //Calculating number of levels divisible by 5 the user has encountered while in the care of the Trainer with Top Percentage:
            $num = [floor($this->topPercentage[1]/5),floor($level/5)];
            $num = $num[1]-$num[0];
            settype($num,"integer");
            //Limiting $num to the range 0<=$num<=4
            $num = min(max($num,0),4);
            //Adding $num to $TP
            $TP = $TP + $num;
            //Checking if the 'mon qualifies for boosted Base Stats, and boosting if they do.
            if ($num==4){
                foreach($baseStats as &$value){
                    $value = $value + 1;
                }
            }
        }
//Checking if Expand Horizons is active
        if ($this->expandHorizons){
            $TP = $TP + 3;
        }

//Adding Stat Ace Base Stats
        $num = 1+floor($level/10);
        settype($num,"integer");
        foreach($this->statAce as $key=>$value){
            $baseStats[$key]=$baseStats[$key]+$num;
        }

        settype($TP,"integer");

//echo nl2br(json_encode($baseStats)."\n\n");

        $stats = $this->statGen($level,$baseStats,$this->statWeights,$this->enduringSoul,$this->statAce);
//echo json_encode($stats);

        $export["health"]=$level+3*($baseStats["HP"]+$stats["HP"])+10;
        $export["injuries"]=0;
        $export["hp"]=$baseStats["HP"]+$stats["HP"];
        $export["atk"]=$baseStats["Attack"]+$stats["Attack"];
        $export["def"]=$baseStats["Defense"]+$stats["Defense"];
        $export["spatk"]=$baseStats["SpecialAttack"]+$stats["SpecialAttack"];
        $export["spdef"]=$baseStats["SpecialDefense"]+$stats["SpecialDefense"];
        $export["speed"]=$baseStats["Speed"]+$stats["Speed"];

        $moveLimit = 6;
        if (in_array("Cluster Mind",$abilities)){
            $moveLimit = $moveLimit + 2;
        }
        if ($this->guidance){
            $moveLimit = $moveLimit + 1;
        }

        $moves = $this->moveGen($bigdex,$dex,$level,$this->tutorRange,$this->eggRange,$moveLimit,$TP-$this->saveTP,$this->september,$moveData);

        $export["moves"]=$moves;
        $export["abilities"]=$abilities;

        return $export;
// Save JSON (from array) to file
//$handle = fopen($fname, 'w') or die('Cannot open file:  '.$fname);
//$data = json_encode($json);
//fwrite($handle, $data);
//fclose($handle);
    }

    //Eliminates Pokémon whose evolve above the maximum possible range;
    function levelCheck($dex,$maxLevel){
        $arr = [];
        foreach($dex as $key => $value){
            //Figure out which evolutionary stage matches the dex entry
            $stip = $value["EvolutionStages"];
            foreach($stip as $k => $v){
                if ($v["Species"]==$value["Species"]){
                    $x = $k;
                    break;
                }
            }
            //Set $stip to the Criteria of the according entry
            $stip = $stip[$x]["Criteria"];
            //See if the word Minimum occcurs in $stip, and if so use it to find the minimum level
            if (strpos($stip,"Minimum")!==FALSE){
                $req = (int)substr($stip,strpos($stip,"Minimum")+1);
            }
            //If there either is not a minimum level, or the minimum is less than the maximum level, the 'mon is allowed
            if (strpos($stip,"Minimum")===FALSE||($req<=$maxLevel)){
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
//This function removes mon from an array that do not meet specific criteria. For multi-step generation, feed the results back into the function with further stipulations.
    function genstep($dex,$genType,$genData,$maxLevel){
        $arr = [];
        //Selects by an Elemental Type
        if ($genType == "Type"){
            foreach ($dex as $key => $value){
                if (in_array($genData,$value["Types"])){
                    $arr[$key]=$value;
                }
            }
            //Selects by a Habitat
        } elseif ($genType == "Habitat"){
            foreach ($dex as $key => $value){
                if (in_array($genData,$value["Environment"]["Habitats"])){
                    $arr[$key]=$value;
                }
            }
            //Selects by a game Generation (1,2,3,4,5,6)
        } elseif ($genType == "Generation"){
            if ($genData == 1){
                $x = 1;
                $y = 151;
            } elseif ($genData == 2){
                $x = 152;
                $y = 251;
            } elseif ($genData == 3){
                $x = 252;
                $y = 386;
            } elseif ($genData == 4){
                $x = 387;
                $y = 493;
            } elseif ($genData == 5){
                $x = 494;
                $y = 649;
            } elseif ($genData == 6){
                $x = 650;
                $y = 719;
            }
            foreach ($dex as $key => $value){
                if ($x <= (int)$key && (int)$key <= $y){
                    $arr[$key]=$value;
                }
            }
            //Selects one single species
        } elseif ($genType == "Specific"){
            foreach ($dex as $key => $value){
                if ($value["Species"]==$genData){
                    $x=$key;
                    break;
                }
            }
            $arr[$x]=$dex[$x];
            //Simply returns the original array
        } else {
            $arr = $dex;
        }
        return $arr;
    }

//This function will get rid of legendaries from the dex, by directly eleminating their dex number.
    function noLegend($dex){
        $arr = [];
        $legends = [144,145,146,150,151,243,244,245,249,250,251,377,378,379,380,381,382,383,384,385,386,"386:A","386:D","386:S",480,481,482,483,484,485,486,487,"487:O",488,489,490,491,492,"492:S",493,494,638,639,640,641,"641:T",642,"642:T",643,644,645,"645:T",646,"646:Z","646:R",647,648,"648:S",649,716,717,718,719];
        foreach ($dex as $key => $value){
            if (!in_array($key,$legends)){
                $arr[$key]=$value;
            }
        }
        return $arr;
    }

//This function selects species abilities.
    function abilitySelect($dex,$level){
        //$abilityList: Array for abilities by Basic (pos 0), Advanced (pos 1), and High (pos 2)
        $abilityList = [[],[],[]];
        //$abilities: Array for selected abilities
        $abilities = [];
        //Populating $abilityList
        foreach($dex["Abilities"] as &$value){
            if ($value["Type"]=="Basic"){
                array_push($abilityList[0],$value["Name"]);
            } elseif ($value["Type"]=="Advanced"){
                array_push($abilityList[1],$value["Name"]);
            } elseif ($value["Type"]=="High"){
                array_push($abilityList[2],$value["Name"]);
            }
        }
        //Selecting first ability
        $a = array_rand($abilityList[0]);
        array_push($abilities,$abilityList[0][$a]);
        //Removing it from $abilityList
        array_splice($abilityList[0],$a,1);
        //If the 'mon still has Basic Abilities and is at least level 20:
        if ($abilityList[0]==[]&&$level>19){
            //Selecing random Advanced Ability
            $a = array_rand($abilityList[1]);
            array_push($abilities,$abilityList[1][$a]);
            //Removing from List
            array_splice($abilityList[1],$a,1);
            //If the 'mon is at least level 40:
            if ($level>39){
                //Selecting random remaining ability, with 90% weight towards the High Ability
                $x = mt_rand(1,10);
                if ($x<2){
                    //Selecting Advanced Ability
                    $a = array_rand($abilityList[1]);
                    array_push($abilities,$abilityList[1][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[1],$a,1);
                } else {
                    //Selecting High Ability
                    $a = array_rand($abilityList[2]);
                    array_push($abilities,$abilityList[2][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[2],$a,1);
                }
            }
        } elseif ($level>19) {
            //Selecting random remaining ability, with 90% weight towards the Advanced Abilities
            $x = mt_rand(1,10);
            if ($x<2){
                //Selecting remaining Basic Ability
                $a = array_rand($abilityList[0]);
                array_push($abilities,$abilityList[0][$a]);
                array_splice($abilityList[0],$a,1);
            } else {
                //Selecting Advanced Ability
                $a = array_rand($abilityList[1]);
                array_push($abilities,$abilityList[1][$a]);
                array_splice($abilityList[1],$a,1);
            }
            //Checking if there are still Basic Abilities and if the 'mon is at least level 40
            if ($abilityList[0]==[]&&$level>39){
                //Selecting random remaining ability, with 90% weight towards the High Ability
                $x = mt_rand(1,10);
                if ($x<2){
                    //Selecting Advanced Ability
                    $a = array_rand($abilityList[1]);
                    array_push($abilities,$abilityList[1][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[1],$a,1);
                } else {
                    //Selecting High Ability
                    $a = array_rand($abilityList[2]);
                    array_push($abilities,$abilityList[2][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[2],$a,1);
                }
                //If the 'mon still has Basic Abilities, and is at least level 40:
            } elseif ($level>39) {
                //Selecting random remaining ability, with 85% weight towards the High Ability, and 10% towards the remaining Advanced Ability
                $x = mt_rand(1,20);
                if ($x<2){
                    //Selecting basic Ability
                    $a = array_rand($abilityList[0]);
                    array_push($abilities,$abilityList[0][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[0],$a,1);
                } elseif ($x<4) {
                    //Selecting Advanced Ability
                    $a = array_rand($abilityList[1]);
                    array_push($abilities,$abilityList[1][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[1],$a,1);
                } else{
                    //Selecting High Ability
                    $a = array_rand($abilityList[2]);
                    array_push($abilities,$abilityList[2][$a]);
                    //Still removing, in case we incorporate Poké Edges later
                    array_splice($abilityList[2],$a,1);
                }
            }
        }
        return $abilities;
    }

    function statGen($level,$baseStats,$statWeights,$enduringSoul,$statAce){
        //Making array for added stats
        $stats = [
            "HP" => 0,
            "Attack" => 0,
            "Defense" => 0,
            "SpecialAttack" => 0,
            "SpecialDefense" => 0,
            "Speed" => 0
        ];
        //Making sorted array of base stats
        $arr = $baseStats;
        arsort($arr);
        //Calculating BSR
        $bsr = [];
        foreach($arr as $key => $value){
            if ($bsr == []){
                //If highest stat, push single-element array to $bsr
                array_push($bsr,[$key]);
            } else {
                //If tied with last stat added, push to last array;
                if ($value == $baseStats[end($bsr)[0]]){
                    $x = key( array_slice( $bsr, -1, 1, TRUE ) );
                    $a = $bsr[$x];
                    array_push($a,$key);
                    $bsr[$x]=$a;
                } else {
                    //If lower than last stat added, push new single-element array;
                    array_push($bsr,[$key]);
                }
            }
        }
        //echo nl2br("bsr:".json_encode($bsr)."\n\n");
        //Get location of each stat in $bsr
        $ordera = [];
        foreach($stats as $key => $value){
            foreach($bsr as $k => $v){
                if (in_array($key,$v)){
                    $ordera[$key]=$k;
                }
            }
        }
        //echo nl2br("ordera:".json_encode($ordera)."\n\n");
        //Add stats for each level
        for($i=0;$i<$level;$i++){
            //Make empty array for valid choices
            $a = [];
            foreach($ordera as $key => $value){
                //If highest stat or tied for highest stat, add to $a
                if($value==0){
                    array_push($a,$key);
                } else {
                    //Empty array for value of stats higher in BSR
                    $higher=[];
                    foreach($bsr[$value-1] as &$v){
                        array_push($higher,$baseStats[$v]+$stats[$v]);
                    }
                    //Get smallest value of the stats in $higher
                    $higher = min($higher);
                    //Test to see if stat can be raised without breaking BSR
                    $test = ($baseStats[$key]+$stats[$key])+1<$higher;
                    //Add to $a if either $test is true or Trainer can break BSR for this stat
                    if ($test||($key=="HP"&&$enduringSoul)||in_array($key,$statAce)){
                        array_push($a,$key);
                    }
                }
            }
            $lWeight=[];
            //Get weights for valid stats
            foreach($a as &$value){
                $lWeight[$value]=$statWeights[$value];
            }
            //Weighted random selection.
            $x = mt_rand(0,array_sum($lWeight)-1);
            foreach($lWeight as $key => $value){
                if ($x<$value){
                    $up = $key;
                    break;
                } else {
                    $x = $x - $value;
                }
            }
            //echo nl2br($up."\n\n");
            //Raise selected stat
            $stats[$up]++;
        }
        //Return all raised stats
        return $stats;
    }

    function moveGen($bigdex,$dex,$level,$tutorRange,$eggRange,$moveLimit,$TP,$september,$moveData){
        //Get number of allowed tutor moves:
        $tutor = mt_rand($tutorRange[0],$tutorRange[1]);
        //Get total list of possible TM/HM/Tutor moves
        if ($dex["Species"]==="Mew"){
            $list = [];
            foreach($moveData as $key => $value){
                $x = ["Name"=>$key,"LevelLearned"=>null,"TechnicalMachineId"=>null,"Natural"=>false];
                array_push($list,$x);
            }
        } else {
            $list = array_merge($dex["TmHmMoves"],$dex["TutorMoves"]);
        }
        //Checking if we need to get rid of moves based on current 'mon level
        if ($september){
            //Checking if the mon is low enough level to have stipulations
            if ($level<29){
                //List of keys to be removed;
                $keys = [];
                //Checking particular stipulations
                if ($level>19){
                    $maxDB = 9;
                    $frequencies = ["At-Will","EOT","Scene"];
                } else {
                    $maxDB = 7;
                    $frequencies = ["At-Will","EOT"];
                }
                //Iterate over moves in $list
                foreach($list as $key=>$value){
                    //checking if the move name includes the (N) symbol and getting rid of it for lookup.
                    if (strpos($value["Name"],"(N)")!==FALSE){
                        $move = trim(substr($value["Name"],0,strpos($value["Name"],"(N)")));
                    } else {
                        $move = $value["Name"];
                    }
                    //Looking up move info;
                    if ($moveData[$move]===null){
                        echo nl2br("move:".$move."\n\n");
                    }
                    $move = $moveData[$move];
                    //If the move doesn't meet the stipulations, add its key to the key list
                    if ((array_key_exists("DB",$move)&&$move["DB"]>$maxDB)||(array_key_exists("Freq",$move)&&!in_array($move["Freq"],$frequencies))){
                        $keys[$key]=1;
                    }
                }
                $list = array_values(array_diff_key($list,$keys));
            }
        }
        $monMoves=[];
        //Fill as many moves in $list as possible into $monMoves
        while ($TP>2&&$tutor>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
            //Get random move
            $move = array_rand($list);
            if (strpos($list[$move]["Name"],"(N)")!==FALSE) {
                //If a (N) move, it costs less to learn, the name needs to be trimmed, and it doesn't count as a tutor move.
                array_push($monMoves,trim(substr($list[$move]["Name"],0,strpos($list[$move]["Name"],"(N)"))));
                $TP = $TP-1;
                //Getting rid of the move from $list
                unset($list[$move]);
                $list = array_values($list);
            } elseif (in_Array($list[$move],$dex["TmHmMoves"])) {
                //TMs cost one TP, and count as a tutor move;
                array_push($monMoves,$list[$move]["Name"]);
                $TP = $TP-1;
                $tutor = $tutor-1;
                //Getting rid of the move from $list
                unset($list[$move]);
                $list = array_values($list);
            } else {
                //Other tutor moves cost two TP, and count as a tutor move;
                array_push($monMoves,$list[$move]["Name"]);
                $TP = $TP-2;
                $tutor = $tutor-1;
                //Getting rid of the move from $list
                unset($list[$move]);
                $list = array_values($list);
            }
        }
        //Add an extra $TM move if one leftover $TP
        if ($TP==1&&$tutor>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
            $list = array_intersect($list,$dex["TmHmMoves"]);
            if ($list!=[]){
                $move = array_rand($list);
                array_push($monMoves,$list[$move]["Name"]);
                $TP = $TP-1;
                $tutor = $tutor-1;
            }
        }
        //Get number of allowed Egg moves
        $egg = mt_rand($eggRange[0],$eggRange[1]);
        //Calculating maximum possible Egg moves
        $max = max(0,(int)floor(($level/10))-1);
        //Setting egg to maximum possible if greater than maximum;
        $egg = min($egg,$max);
        //Getting possible egg moves
        $list = [];
        foreach ($bigdex as $key => $value){
            if ($value["Species"]==$dex["EvolutionStages"][0]["Species"]){
                $x=$key;
                break;
            }
        }
        $list = $bigdex[$x]["EggMoves"];
        //Checking legal Egg Moves
        if ($september){
            //Checking if the mon needs stipulations
            if ($egg>0&&$level<20+10*$egg){
                //Making copy of list
                $littlelist = $list;
                //Array of keys to be removed;
                $keys = [];
                //Setting particular stipulations
                $maxDB = 9;
                $frequencies = ["At-Will","EOT"];
                //Iterate over moves in $littlelist
                foreach($littlelist as $key=>$value){
                    //Looking up move info;
                    $move = $moveData[$value["Name"]];
                    //If the move doesn't meet the stipulations, add its key to the key list
                    if ((array_key_exists("DB",$move)&&$move["DB"]>$maxDB)||(array_key_exists("Freq",$move)&&!in_array($move["Freq"],$frequencies))){
                        $keys[$key]=1;
                    }
                }
                $littlelist = array_diff_key($littlelist,$keys);
                //Since there's only ever one move that needs to follow these stipulations, picking it now
                $move = array_rand($littlelist);
                array_push($monMoves,$littlelist[$move]["Name"]);
                $egg=$egg-1;
                //Removing $move from the big list
                unset($list[$move]);
                $list = array_values($list);
            }
        }
        //Getting remaining egg moves
        while($egg>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
            $move = array_rand($list);
            array_push($monMoves,$list[$move]["Name"]);
            $egg=$egg-1;
            unset($list[$move]);
            $list = array_values($list);
        }
        //Getting Level Up Moves
        $list = $dex["LevelUpMoves"];
        //Getting rid of LUMs that are too high a level
        $keys = [];
        foreach($list as $key => $value){
            if ($value["LevelLearned"]>$level){
                $keys[$key]=1;
            }
        }
        $list = array_values(array_diff_key($list,$keys));
        //Picking remaining moves
        while (sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
            $move = array_rand($list);
            array_push($monMoves,$list[$move]["Name"]);
            unset($list[$move]);
        }
        return $monMoves;
    }

}
