/*
data: JSON from the Google Drive-based Fancy Sheet
dex: object mapping Pokémon Names to Dex Numbers

*/

/*First, putting in the elements that can be directly mapped from data to t*/
t = {
  name: data.nickname,
  dex: dex[data.species],
  level: data.Level,
  EXP: data.EXP,
  nature: data.Nature,
  gender: data.Gender,
  discovery: "",
  health: 0,
  injuries: 0,
  hp: data.HP,
  atk: data.ATK,
  def: data.DEF,
  spatk: data.SPATK,
  spdef: data.SPDEF,
  speed: data.SPEED,
  moves: [
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    ""
  ],
  abilities: [
    "",
    "",
    ""
  ]
};
/*The dash in held-item seems to be an issue in the object defininition, so it's defined here*/
t["held-item"]= data.HeldItem;
/*Checking for single or dual type, and acting accordingly*/
if (data.type2===""){
  t.type = data.type1;
} else {
  t.type = data.type1 + " / " + data.type2;
}
/*Handling things of variable number, like Moves and Abilities */
$.each(data, function(key,value){
  /*Handling Moves*/
  if (key.indexOf("Move")!==-1){
    t.moves.append(value.Name);
  /*Handling Abilities*/
  } else if (key.indexOf("Ability")!==-1){
    t.abilities.append(value.name);
  }
});
/*Padding out moves; can be removed if the code does not rely on length of these arrays*/
while (t.moves.length<9) {
  t.moves.append("");
}
/*Padding out abilities; can be removed if the code does not rely on length of these arrays*/
while (t.abilities.length<3) {
  t.abilities.append("");
}
