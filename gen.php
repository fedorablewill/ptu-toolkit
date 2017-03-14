<?php
//$genType = type of generation; two-layer array with two-long subarrays
//Each step may be one of [Type, Habitat, Generation,Specific,All]
//Examples:
$genType = [["All",""]];
//$genType=[["Type","Fire"]];
//$genType=[["Habitat","Urban"]];
//$genType=[["Generation",1],["Type","Ice"]];
//$genType=[["Specific","Bulbasaur"]];

//$levelRange = two-entry array, with first entry the lower bound and second the upper bound for the level range, inclusive.
$levelRange=[1,100];
//$nature: If "Random", will generate random nature; otherwise, the nature for the mon.
//$statWeights: An array of numbers with with the six stats as keys. This is used for randomly selecting stats, BSR allowing

$fname = __DIR__ ."/data/ptu_pokedex_1_05.json";
$dex = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();
//$fname = "/data/natures.json";
//$natureList = file_exists($fname) ? json_decode(file_get_contents($fname), true) : array();

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
    $x = rand(1,10);
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
    $x = rand(1,10);
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
      $x = rand(1,10);
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
      $x = rand(1,20);
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

function statGen($level,$baseStats){
  $stats = [
    "HP" => 0,
    "ATK" => 0,
    "DEF" => 0,
    "SPATK" => 0,
    "SPDEF" => 0,
    "SPEED" => 0
  ];
  $arr = arsort($baseStats);
  $bsr = [];
  foreach($arr as $key => $value){
    if ($bsr == []){
      array_push($bsr,[$key]);
    } else {
      if ($value == end($bsr)[0]){
        array_push(end($bsr),$key);
      } else {
        array_push($bsr,[$key]);
      }
    }
  }
  return $bsr;
}
//Iterates over $genType for multi-step generation



foreach ($genType as &$value){
  $dex = genStep($dex,$value[0],$value[1]);
}

if ($legend == FALSE){
  $dex = noLegend($dex);
}


//Selects single entry from limited dex.
if ($dex != []){
  $dex = $dex[array_rand($dex)];
}
echo nl2br(json_encode($dex)."\n\n");

//Picking level for the 'mon
if ($levelRange[0]==$levelRange[1]){
  $level = $levelRange[0];
} else {
  $level = rand($levelRange[0],$levelRange[1]);
}
echo $level;

//Picking abilities
$abilities = abilitySelect($dex,$level);

//Picking Nature
if ($nature=="Random"){
  $nature = array_rand($natureList);
}

$baseStats = $dex["BaseStats"];
if ($natureList[$nature]["Raise"]=="HP"){
  $baseStats["HP"] = $baseStats["HP"] + 1;
} else {
  $baseStats[$natureList[$nature]["Raise"]] = $baseStats[$natureList[$nature]["Raise"]] + 2;
}
if ($natureList[$nature]["Lower"]=="HP"){
  $baseStats["HP"] = $baseStats["HP"] - 1;
} else {
  $baseStats[$natureList[$nature]["Lower"]] = $baseStats[$natureList[$nature]["Lower"]] - 2;
}

$stats = statGen($level,$baseStats);

// Save JSON (from array) to file
//$handle = fopen($fname, 'w') or die('Cannot open file:  '.$fname);
//$data = json_encode($json);
//fwrite($handle, $data);
//fclose($handle);
?>
