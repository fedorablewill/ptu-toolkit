/*
monIn: JSON from box.json
*/
function JSONExport(monIn,dex,moves,abilities,experience){
//monOut: Fancy Sheet-style JSON to export; setting the easy stuff first

//If playtest rules are an option in the future, we can add those in as parameters later, for certain abilities and such
var monOut = {
  CharType: monIn.nickname,
  nickname: monIn.name,
  species: dex.Species,
  Level: monIn.level,
  EXP: monIn.EXP,
  EXP_max: experience.level,
  HeldItem: monIn["held-item"],
  Gender: monIn.gender,
  Nature: monIn.nature,
  Height: dex.Height.Category.Minimum,
  WeightClass: dex.Weight.WeightClass.Minimum,
  HP: monIn.hp-dex.BaseStats.HP,
  ATK: monIn.atk-dex.BaseStats.Attack,
  DEF: monIn.def-dex.BaseStats.Defense,
  SPATK: monIn.spatk-dex.BaseStats.SpecialAttack,
  SPDEF: monIn.spdef-dex.BaseStats.SpecialDefense,
  SPEED: monIn.speed-dex.BaseStats.Speed,
  TutorPoints: Math.floor(monIn.level/5)+1,
  TutorPoints_max: Math.floor(monIn.level/5)+1
};

//Adding in properties with underscores in their names.
monOut["base_HP"]=dex.BaseStats.HP;
monOut["base_ATK"]=dex.BaseStats.Attack;
monOut["base_DEF"]=dex.BaseStats.Defense;
monOut["base_SPATK"]=dex.BaseStats.SpecialAttack;
monOut["base_SPDEF"]=dex.BaseStats.SpecialDefense;
monOut["base_SPEED"]=dex.BaseStats.Speed;

//Checking for single or dual type, and acting accordingly
if (monIn.type.indexOf(" / ")===-1){
  monOut.type1 = monIn.type;
  monOut.type2 = "";
} else {
  monOut.type1 = monIn.type.substring(0,monIn.type.indexOf(" / "));
  monOut.type2 = monIn.type.substring(monIn.type.indexOf(" / ")+3);
}

//Building monOut.Capabilities
monOut.Capabilities={};
$.each(dex.Capabilities,function(index,value){
    if(value.CapabilityName=="Naturewalk"){
      monOut.Capabilities["Naturewalk("+value.Value+")"]=true;
    } else if (value.CapabilityName=="Jump") {
      monOut.Capabilities.LJ = parseInt(value.Value.substring(0,value.Value.indexOf("/")),10);
      monOut.Capabilities.HJ = parseInt(value.Value.substring(value.Value.indexOf("/")+1),10);
    } else if (value.Value === "") {
      monOut.Capabilities[value.CapabilityName]=true;
    } else {
      monOut.Capabilities[value.CapabilityName]=value.Value;
    }
});

//Handling Skills
var skills =["Acrobatics","Athletics","Combat","Intimidate","Stealth","Survival","GeneralEducation","MedicineEducation","OccultEducation","PokemonEducation","TechnologyEducation","Guile","Perception","Charm","Command","Focus","Intuition"];
$.each(skills,function(index,value){
  var skill = "2d6";
  if (value.indexOf("Education")===-1){
    skill = "1d6";
  }
  var i; for (i=0;i<dex.Skills.length;i++){
    if (dex.Skills[i].SkillName=="Edu: Tech"&&value=="TechnologyEducation" || value.indexOf(dex.Skills[i].SkillName)){
      skill = dex.Skills[i].DiceRank;
      break;
    }
  }
  monOut[value]=parseInt(skill.substring(0,skill.indexOf("d")));
  if (skill.indexOf("+")===-1){
    monOut[value+"_bonus"]=0;
  } else {
    monOut[value+"_bonus"]=parseInt(skill.substring(skill.indexOf("+")+1),10);
  }
});

//Handling Moves
$.each(monIn.moves,function(index,value){
  var info = moves[value];
  monOut["Move"+(index+1)]={
    Name:value,
    Type:info.Type,
    DType:info.Class,
    Freq:info.Freq,
    Range: info.Range
  };
  if (info.hasOwnProperty("AC")){
    monOut["Move"+(index+1)].AC=parseInt(info.AC,10);
  }
  if (info.hasOwnProperty("DB")){
    monOut["Move"+(index+1)].DB=parseInt(info.DB,10);
  }
  if (info.hasOwnProperty("Effect")){
    monOut["Move"+(index+1)].Effects=info.Effect;
  }
});
//Handling  Abilities
//Switches and such: Help the sheet know certain abilities are in effect
monOut.sniper = 0;monOut.snipern = 0;monOut.twist = 0;monOut.flashfire = 0;monOut.weird = 0;monOut.damp = 0;monOut.aurastn = 0;monOut.defeat = 0;monOut.hustle = 0;monOut.courage = 0;monOut.lastctrue = 0;monOut.lastctype = "";

$.each(monIn.abilities,function(index,value){
  var info = abilities[value];
  monOut["Ability"+(index+1)]={
    Name:value,
    Freq:info.Freq
  };
  if (value.hasOwnProperty("Trigger")){
    monOut["Ability"+(index+1)].Info="Trigger–"+info.Trigger+"\n"+info.Effect;
  } else {
    monOut["Ability"+(index+1)].Info=info.Effect;
  }
  if (value.hasOwnProperty("Target")){
    monOut["Ability"+(index+1)].Target=info.Target;
  } else {
    monOut["Ability"+(index+1)].Target=info.Self;
  }
  /*Non-Playtest sniper: add with a conditional if playtest check in effect:
  if (value=="Sniper"){
    monOut.sniper=1;
  }
  */
  if (value=="Sniper"){
    monOut.snipern=1;
  }
  if (value=="Twisted Power"){
    monOut.Twist=1;
  }
  if (value=="Flash Fire"){
    monOut.flashfire=1;
  }
  if (value=="Weird Power"){
    monOut.weird=1;
  }
  if (value=="Damp"){
    monOut.damp=1;
  }
  if (value=="Aura Storm"){
    monOut.aurastn=1;
  }
  if (value=="Defeatist"){
    monOut.defeat=1;
  }
  if (value=="Hustle"){
    monOut.hustle=1;
  }
  if (value=="Courage"){
    monOut.courage=1;
  }
  if (value=="Blaze"){
    monOut.lastctrue=1;
    monOut.lastctype+="Fire";
  }
  if (value=="Dark Art"){
    monOut.lastctrue=1;
    monOut.lastctype+="Dark";
  }
  if (value=="Focus"){
    monOut.lastctrue=1;
    monOut.lastctype+="Fighting";
  }
  if (value=="Freezing Point"){
    monOut.lastctrue=1;
    monOut.lastctype+="Ice";
  }
  if (value=="Haunt"){
    monOut.lastctrue=1;
    monOut.lastctype+="Ghost";
  }
  if (value=="Last Chance"){
    monOut.lastctrue=1;
    monOut.lastctype+="Normal";
  }
  if (value=="Landslide"){
    monOut.lastctrue=1;
    monOut.lastctype+="Ground";
  }
  if (value=="Mach Speed"){
    monOut.lastctrue=1;
    monOut.lastctype+="Flying";
  }
  if (value=="Mind Mold"){
    monOut.lastctrue=1;
    monOut.lastctype+="Psychic";
  }
  if (value=="Miracle Mile"){
    monOut.lastctrue=1;
    monOut.lastctype+="Fairy";
  }
  if (value=="Mountain Peak"){
    monOut.lastctrue=1;
    monOut.lastctype+="Rock";
  }
  if (value=="Overcharge"){
    monOut.lastctrue=1;
    monOut.lastctype+="Electric";
  }
  if (value=="Overgrow"){
    monOut.lastctrue=1;
    monOut.lastctype+="Grass";
  }
  if (value=="Pure Blooded"){
    monOut.lastctrue=1;
    monOut.lastctype+="Dragon";
  }
  if (value=="Swarm"){
    monOut.lastctrue=1;
    monOut.lastctype+="Bug";
  }
  if (value=="Torrent"){
    monOut.lastctrue=1;
    monOut.lastctype+="Water";
  }
  if (value=="Unbreakable"){
    monOut.lastctrue=1;
    monOut.lastctype+="Steel";
  }
  if (value=="Venom"){
    monOut.lastctrue=1;
    monOut.lastctype+="Poison";
  }
});

return JSON.stringify(monOut);

}
