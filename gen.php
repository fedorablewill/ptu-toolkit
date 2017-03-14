<?php
//$genType = type of generation; two-layer array with two-long subarrays
//Each step may be one of [Type, Habitat, Generation,Specific,All]
//Examples:
$genType = [["All",""]];
//$genType=[["Type","Fire"]];
//$genType=[["Habitat","Urban"]];
//$genType=[["Generation",1],["Type","Ice"]];
//$genType=[["Specific","Bulbasaur"]];

//$legend = Boolean; if FALSE, no legndaries are allowed to generate
$legend = TRUE; 

//$levelRange = two-entry array, with first entry the lower bound and second the upper bound for the level range, inclusive.
$levelRange=[1,100];

//$nature: If "Random", will generate random nature; otherwise, the nature for the mon.
$nature = "Random";

//$statWeights: An array of numbers with with the six stats as keys. This is used for randomly selecting stats, BSR allowing.
//The default, unweighted version is as shown below:
$statWeights = ["HP"=>1,"Attack"=>1,"Defense"=>1,"SpecialAttack"=>1,"SpecialDefense"=>1,"Speed"=>1];

//$tutorRange: Array of lower and upper bounds on the amount of TM, HM, and Tutor moves allowed to generate per 'mon 
$tutorRange = [0,3];

//$eggRange: Array of lower and upper bounds on the amount of Egg moves allowed to generate per 'mon
$eggRange = [0,3];

//Getting data from the JSONs
$fname = __DIR__ ."/data/ptu_pokedex_1_05.json";
$bigdex = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
$dex = $bigdex;
$fname = __DIR__ ."/data/natures.json";
$natureList = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
$fname = __DIR__ ."/data/experience.json";
$exp = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();

//This function removes mon from an array that do not meet specific criteria. For multi-step generation, feed the results back into the function with further stipulations.
function genstep($dex,$genType,$genData){
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
  //Selects by a game Generation (I, II, III, IV, V, VI)
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

function abilitySelect($dex,$level){
  $abilityList = [[],[],[]];
  $abilities = [];
  foreach($dex["Abilities"] as &$value){
    if ($value["Type"]=="Basic"){
      array_push($abilityList[0],$value["Name"]);
    } elseif ($value["Type"]=="Advanced"){
      array_push($abilityList[1],$value["Name"]);
    } elseif ($value["Type"]=="High"){
      array_push($abilityList[2],$value["Name"]);
    }
  }
  $a = array_rand($abilityList[0]);
  array_push($abilities,$abilityList[0][$a]);
  array_splice($abilityList[0],$a,1);
  if ($abilityList[0]==[]){
    $a = array_rand($abilityList[1]);
    array_push($abilities,$abilityList[1][$a]);
    array_splice($abilityList[1],$a,1);
    $x = mt_rand(1,10);
    if ($x<2){
      $a = array_rand($abilityList[1]);
      array_push($abilities,$abilityList[1][$a]);
      array_splice($abilityList[1],$a,1);
    } else {
      $a = array_rand($abilityList[2]);
      array_push($abilities,$abilityList[2][$a]);
      array_splice($abilityList[2],$a,1);
    }
  } else {
    $x = mt_rand(1,10);
    if ($x<4){
      $a = array_rand($abilityList[0]);
      array_push($abilities,$abilityList[0][$a]);
      array_splice($abilityList[0],$a,1);
    } else {
      $a = array_rand($abilityList[1]);
      array_push($abilities,$abilityList[1][$a]);
      array_splice($abilityList[1],$a,1);
    }
    if ($abilityList[0]==[]){
      $x = mt_rand(1,10);
      if ($x<2){
        $a = array_rand($abilityList[1]);
        array_push($abilities,$abilityList[1][$a]);
        array_splice($abilityList[1],$a,1);
      } else {
        $a = array_rand($abilityList[2]);
        array_push($abilities,$abilityList[2][$a]);
        array_splice($abilityList[2],$a,1);
      }
    } else {
      $x = mt_rand(1,20);
      if ($x<2){
        $a = array_rand($abilityList[0]);
        array_push($abilities,$abilityList[0][$a]);
        array_splice($abilityList[0],$a,1);
      } elseif ($x<4) {
        $a = array_rand($abilityList[1]);
        array_push($abilities,$abilityList[1][$a]);
        array_splice($abilityList[1],$a,1);
      } else{
        $a = array_rand($abilityList[2]);
        array_push($abilities,$abilityList[2][$a]);
        array_splice($abilityList[2],$a,1);
      }
    }
  }
  return $abilities;
}

function statGen($level,$baseStats,$statWeights){
  $stats = [
    "HP" => 0,
    "Attack" => 0,
    "Defense" => 0,
    "SpecialAttack" => 0,
    "SpecialDefense" => 0,
    "Speed" => 0
  ];
  $arr = $baseStats;
  arsort($arr);
  $bsr = [];
  foreach($arr as $key => $value){
    if ($bsr == []){
      array_push($bsr,[$key]);
    } else {
      if ($value == $baseStats[end($bsr)[0]]){
      	$x = key( array_slice( $bsr, -1, 1, TRUE ) );
      	$a = $bsr[$x];
        array_push($a,$key);
        $bsr[$x]=$a;
      } else {
        array_push($bsr,[$key]);
      }
    }
  }
  //echo nl2br("bsr:".json_encode($bsr)."\n\n");
  $ordera = [];
  foreach($stats as $key => $value){
  	foreach($bsr as $k => $v){
  		if (in_array($key,$v)){
  			$ordera[$key]=$k;
  		}
  	}
  }
  for($i=0;$i<$level;$i++){
  	$a = [];
  	foreach($ordera as $key => $value){
  		if($value==0){
  			array_push($a,$key);
  		} else {
  			if (($baseStats[$key]+$stats[$key])+1<($baseStats[$bsr[$value-1][0]]+$stats[$bsr[$value-1][0]])){
  				array_push($a,$key);
  			}
  		}
  	}
  	$lWeight=[];
  	foreach($a as &$value){
  		$lWeight[$value]=$statWeights[$value];
  	}
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
  	$stats[$up]++;
  }
  return $stats;
}
//Iterates over $genType for multi-step generation

function moveGen($bigdex,$dex,$level,$tutorRange,$eggRange,$moveLimit){
	$TP = 1 + floor($level/5);
	settype($TP,"integer");
	$tutor = mt_rand($tutorRange[0],$tutorRange[1]);
	$egg = mt_rand($eggRange[0],$eggRange[1]);
	$list = array_merge($dex["TmHmMoves"],$dex["TutorMoves"]);
	$monMoves=[];
	while ($TP>2&&$tutor>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
		$move = array_rand($list);
		if (strpos($list[$move]["Name"],"(N)")) {
			array_push($monMoves,trim(substr($list[$move]["Name"],0,strpos($list[$move]["Name"],"(N)"))));
			$TP = $TP-1;
			$tutor = $tutor-1;
			unset($list[$move]);
		} elseif (in_Array($list[$move],$dex["TmHmMoves"])) {
			array_push($monMoves,$list[$move]["Name"]);
			$TP = $TP-1;
			$tutor = $tutor-1;
			unset($list[$move]);
		} else {
			array_push($monMoves,$list[$move]["Name"]);
			$TP = $TP-2;
			$tutor = $tutor-1;
			unset($list[$move]);
		}
	}
	if ($TP==1&&$tutor>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
		$move = array_rand($dex["TmHmMoves"]);
		array_push($monMoves,$dex["TmHmMoves"][$move]["Name"]);
		$TP = $TP-1;
		$tutor = $tutor-1;
	}
	$list = $bigdex[$dex["EvolutionStages"][0]["Species"]]["EggMoves"];
	while($egg>0&&sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
		$move = array_rand($list);
		array_push($monMoves,$list[$move]["Name"]);
		$egg=$egg-1;
		unset($list[$move]);
	}
	$list = $dex["LevelUpMoves"];
	$keys = [];
	foreach($list as $key => $value){
		if ($value["LevelLearned"]>$level){
			$keys[$key]=1;
		}
	}
	$list = array_values(array_diff_key($list,$keys));
	while (sizeOf($monMoves)<$moveLimit&&sizeOf($list)!=0){
		$move = array_rand($list);
		array_push($monMoves,$list[$move]["Name"]);
		unset($list[$move]);
	}
	return $monMoves;
}

$export = ["name" => ""];

foreach ($genType as &$value){
  $dex = genStep($dex,$value[0],$value[1]);
}

if ($legend == FALSE){
  $dex = noLegend($dex);
}


//Selects single entry from limited dex.
if ($dex != []){
	$num = array_rand($dex);
	$export["dex"]=(int)$num;
  	$dex = $dex[$num];
  	if (sizeOf($dex["Types"])==1){
		$export["type"]=$dex["Types"][0];
  	} else {
  		$s = "";
  		foreach($dex["Types"] as &$value){
  			$s = $s.$value." / ";
  		}
  		$export["type"] = substr($s,0,-3);
  	}
}
echo nl2br(json_encode($dex)."\n\n");

$export["held-item"] = "";

//Picking level for the 'mon
$level = mt_rand($levelRange[0],$levelRange[1]);

$export["level"] = (int)$level;
$export["EXP"] = $exp[$level];

//Picking abilities
$abilities = abilitySelect($dex,$level);

//Picking Nature
if ($nature=="Random"){
  $nature = array_rand($natureList);
}
//echo nl2br($nature."\n\n");
$export["nature"] = $nature;

if (!$dex["BreedingData"]["HasGender"]){
	$export["gender"]="No Gender";
} else {
	$num = mt_rand() / mt_getrandmax();
	if ($num < $dex["BreedingData"]["MaleChance"]){
		$export["gender"]="Male";
	} else {
		$export["gender"]="Female";
	}
}

$export["discovery"]="";

$baseStats = $dex["BaseStats"];
if ($natureList[$nature]["Raise"]=="HP"){
  $baseStats["HP"] = $baseStats["HP"] + 1;
} else {
  $baseStats[$natureList[$nature]["Raise"]] = $baseStats[$natureList[$nature]["Raise"]] + 2;
}
if ($natureList[$nature]["Lower"]=="HP"){
  $baseStats["HP"] = max($baseStats["HP"] - 1,1);
} else {
  $baseStats[$natureList[$nature]["Lower"]] = max($baseStats[$natureList[$nature]["Lower"]] - 2,1);
}
//echo nl2br(json_encode($baseStats)."\n\n");

$stats = statGen($level,$baseStats,$statWeights);
//echo json_encode($stats);

$export["health"]=$level+3*($baseStats["HP"]+$stats["HP"])+10;
$export["injuries"]=0;
$export["hp"]=$baseStats["HP"]+$stats["HP"];
$export["atk"]=$baseStats["Attack"]+$stats["Attack"];
$export["def"]=$baseStats["Defense"]+$stats["Defense"];
$export["spatk"]=$baseStats["SpecialAttack"]+$stats["SpecialAttack"];
$export["spdef"]=$baseStats["SpecialDefense"]+$stats["SpecialDefense"];
$export["speed"]=$baseStats["Speed"]+$stats["Speed"];

if (in_Array("Cluster Mind",$abilities)){
	$moves = moveGen($bigdex,$dex,$level,$tutorRange,$eggRange,8);
} else {
	$moves = moveGen($bigdex,$dex,$level,$tutorRange,$eggRange,6);
}
$export["moves"]=$moves;
$export["abilities"]=$abilities;

echo json_encode($export, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

// Save JSON (from array) to file
//$handle = fopen($fname, 'w') or die('Cannot open file:  '.$fname);
//$data = json_encode($json);
//fwrite($handle, $data);
//fclose($handle);
?>
