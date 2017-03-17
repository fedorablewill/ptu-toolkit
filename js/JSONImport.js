/*
monIn: JSON from the Google Drive-based Fancy Sheet
*/
function JSONImport(monIn){

$.getJSON("api/v1/pokemon/", function (dex) {
//monOut: box.json Pokémon; we'll define the easy stuff to start with:
var monOut = {
  name: monIn.nickname,
  level: monIn.Level,
  EXP: monIn.EXP,
  nature: monIn.Nature,
  gender: monIn.Gender,
  discovery: "",
  health: monIn.level+3*(monIn.base_HP+monIn.HP)+10,
  injuries: 0,
  hp: monIn.base_HP+monIn.HP,
  atk: monIn.base_ATK+monIn.ATK,
  def: monIn.base_DEF+monIn.DEF,
  spatk: monIn.base_SPATK+monIn.SPATK,
  spdef: monIn.base_SPDEF+monIn.SPDEF,
  speed: monIn.base_SPEED+monIn.SPEED
};

//The dash seems to give a spot of trouble, so we do it seperately:
monOut["held-item"]=monIn.HeldItem;

//Getting the dex entry:
var keys = dex.keys();
var i; for (i=0;i<keys.length;i++){
  if (dex[keys[i]].Species==monIn.species){
    monOut.dex = keys[i];
    break;
  }
}

//Checking for single or dual type, and acting accordingly
if (monIn.type2===""){
  monOut.type = monIn.type1;
} else {
  monOut.type = monIn.type1 + " / " + monIn.type2;
}


//Handling things of variable number, like Moves and Abilities
$.each(monIn, function(key,value){
  //Handling Moves
  if (key.indexOf("Move")!==-1){
    monOut.moves.append(value.Name);
  //Handling Abilities
  } else if (key.indexOf("Ability")!==-1){
    monOut.abilities.append(value.name);
  }
});

return monOut;
});
}
