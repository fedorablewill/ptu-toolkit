<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\Characters as ChildCharacters;
use Propel\PtuToolkit\CharactersQuery as ChildCharactersQuery;
use Propel\PtuToolkit\Map\CharactersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'characters' table.
 *
 *
 *
 * @method     ChildCharactersQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildCharactersQuery orderByCampaignId($order = Criteria::ASC) Order by the campaign_id column
 * @method     ChildCharactersQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildCharactersQuery orderByPokedexNo($order = Criteria::ASC) Order by the pokedex_no column
 * @method     ChildCharactersQuery orderByPokedexId($order = Criteria::ASC) Order by the pokedex_id column
 * @method     ChildCharactersQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCharactersQuery orderByOwner($order = Criteria::ASC) Order by the owner column
 * @method     ChildCharactersQuery orderByAge($order = Criteria::ASC) Order by the age column
 * @method     ChildCharactersQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildCharactersQuery orderByHeight($order = Criteria::ASC) Order by the height column
 * @method     ChildCharactersQuery orderBySex($order = Criteria::ASC) Order by the sex column
 * @method     ChildCharactersQuery orderByType1($order = Criteria::ASC) Order by the base_type1 column
 * @method     ChildCharactersQuery orderByType2($order = Criteria::ASC) Order by the base_type2 column
 * @method     ChildCharactersQuery orderByLevel($order = Criteria::ASC) Order by the level column
 * @method     ChildCharactersQuery orderByExp($order = Criteria::ASC) Order by the exp column
 * @method     ChildCharactersQuery orderByBaseHp($order = Criteria::ASC) Order by the base_hp column
 * @method     ChildCharactersQuery orderByBaseAtk($order = Criteria::ASC) Order by the base_atk column
 * @method     ChildCharactersQuery orderByBaseDef($order = Criteria::ASC) Order by the base_def column
 * @method     ChildCharactersQuery orderByBaseSatk($order = Criteria::ASC) Order by the base_satk column
 * @method     ChildCharactersQuery orderByBaseSdef($order = Criteria::ASC) Order by the base_sdef column
 * @method     ChildCharactersQuery orderByBaseSpd($order = Criteria::ASC) Order by the base_spd column
 * @method     ChildCharactersQuery orderByAddHp($order = Criteria::ASC) Order by the add_hp column
 * @method     ChildCharactersQuery orderByAddAtk($order = Criteria::ASC) Order by the add_atk column
 * @method     ChildCharactersQuery orderByAddDef($order = Criteria::ASC) Order by the add_def column
 * @method     ChildCharactersQuery orderByAddSatk($order = Criteria::ASC) Order by the add_satk column
 * @method     ChildCharactersQuery orderByAddSdef($order = Criteria::ASC) Order by the add_sdef column
 * @method     ChildCharactersQuery orderByAddSpd($order = Criteria::ASC) Order by the add_spd column
 * @method     ChildCharactersQuery orderByHealth($order = Criteria::ASC) Order by the health column
 * @method     ChildCharactersQuery orderByInjuries($order = Criteria::ASC) Order by the injuries column
 * @method     ChildCharactersQuery orderByMoney($order = Criteria::ASC) Order by the money column
 * @method     ChildCharactersQuery orderBySkillAcrobatics($order = Criteria::ASC) Order by the skill_acrobatics column
 * @method     ChildCharactersQuery orderBySkillAthletics($order = Criteria::ASC) Order by the skill_athletics column
 * @method     ChildCharactersQuery orderBySkillCharm($order = Criteria::ASC) Order by the skill_charm column
 * @method     ChildCharactersQuery orderBySkillCombat($order = Criteria::ASC) Order by the skill_combat column
 * @method     ChildCharactersQuery orderBySkillCommand($order = Criteria::ASC) Order by the skill_command column
 * @method     ChildCharactersQuery orderBySkillGeneralEd($order = Criteria::ASC) Order by the skill_general_ed column
 * @method     ChildCharactersQuery orderBySkillMedicineEd($order = Criteria::ASC) Order by the skill_medicine_ed column
 * @method     ChildCharactersQuery orderBySkillOccultEd($order = Criteria::ASC) Order by the skill_occult_ed column
 * @method     ChildCharactersQuery orderBySkillPokemonEd($order = Criteria::ASC) Order by the skill_pokemon_ed column
 * @method     ChildCharactersQuery orderBySkillTechnologyEd($order = Criteria::ASC) Order by the skill_technology_ed column
 * @method     ChildCharactersQuery orderBySkillFocus($order = Criteria::ASC) Order by the skill_focus column
 * @method     ChildCharactersQuery orderBySkillGuile($order = Criteria::ASC) Order by the skill_guile column
 * @method     ChildCharactersQuery orderBySkillIntimidate($order = Criteria::ASC) Order by the skill_intimidate column
 * @method     ChildCharactersQuery orderBySkillIntuition($order = Criteria::ASC) Order by the skill_intuition column
 * @method     ChildCharactersQuery orderBySkillPerception($order = Criteria::ASC) Order by the skill_perception column
 * @method     ChildCharactersQuery orderBySkillStealth($order = Criteria::ASC) Order by the skill_stealth column
 * @method     ChildCharactersQuery orderBySkillSurvival($order = Criteria::ASC) Order by the skill_survival column
 * @method     ChildCharactersQuery orderByApSpent($order = Criteria::ASC) Order by the ap_spent column
 * @method     ChildCharactersQuery orderByApBound($order = Criteria::ASC) Order by the ap_bound column
 * @method     ChildCharactersQuery orderByApDrained($order = Criteria::ASC) Order by the ap_drained column
 * @method     ChildCharactersQuery orderByBackgroundName($order = Criteria::ASC) Order by the background_name column
 * @method     ChildCharactersQuery orderByBackgroundAdept($order = Criteria::ASC) Order by the background_adept column
 * @method     ChildCharactersQuery orderByBackgroundNovice($order = Criteria::ASC) Order by the background_novice column
 * @method     ChildCharactersQuery orderByBackgroundPthc1($order = Criteria::ASC) Order by the background_pthc1 column
 * @method     ChildCharactersQuery orderByBackgroundPthc2($order = Criteria::ASC) Order by the background_pthc2 column
 * @method     ChildCharactersQuery orderByBackgroundPthc3($order = Criteria::ASC) Order by the background_pthc3 column
 * @method     ChildCharactersQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildCharactersQuery orderByNature($order = Criteria::ASC) Order by the nature column
 * @method     ChildCharactersQuery orderBySheetType($order = Criteria::ASC) Order by the sheet_type column
 *
 * @method     ChildCharactersQuery groupByCharacterId() Group by the character_id column
 * @method     ChildCharactersQuery groupByCampaignId() Group by the campaign_id column
 * @method     ChildCharactersQuery groupByType() Group by the type column
 * @method     ChildCharactersQuery groupByPokedexNo() Group by the pokedex_no column
 * @method     ChildCharactersQuery groupByPokedexId() Group by the pokedex_id column
 * @method     ChildCharactersQuery groupByName() Group by the name column
 * @method     ChildCharactersQuery groupByOwner() Group by the owner column
 * @method     ChildCharactersQuery groupByAge() Group by the age column
 * @method     ChildCharactersQuery groupByWeight() Group by the weight column
 * @method     ChildCharactersQuery groupByHeight() Group by the height column
 * @method     ChildCharactersQuery groupBySex() Group by the sex column
 * @method     ChildCharactersQuery groupByType1() Group by the base_type1 column
 * @method     ChildCharactersQuery groupByType2() Group by the base_type2 column
 * @method     ChildCharactersQuery groupByLevel() Group by the level column
 * @method     ChildCharactersQuery groupByExp() Group by the exp column
 * @method     ChildCharactersQuery groupByBaseHp() Group by the base_hp column
 * @method     ChildCharactersQuery groupByBaseAtk() Group by the base_atk column
 * @method     ChildCharactersQuery groupByBaseDef() Group by the base_def column
 * @method     ChildCharactersQuery groupByBaseSatk() Group by the base_satk column
 * @method     ChildCharactersQuery groupByBaseSdef() Group by the base_sdef column
 * @method     ChildCharactersQuery groupByBaseSpd() Group by the base_spd column
 * @method     ChildCharactersQuery groupByAddHp() Group by the add_hp column
 * @method     ChildCharactersQuery groupByAddAtk() Group by the add_atk column
 * @method     ChildCharactersQuery groupByAddDef() Group by the add_def column
 * @method     ChildCharactersQuery groupByAddSatk() Group by the add_satk column
 * @method     ChildCharactersQuery groupByAddSdef() Group by the add_sdef column
 * @method     ChildCharactersQuery groupByAddSpd() Group by the add_spd column
 * @method     ChildCharactersQuery groupByHealth() Group by the health column
 * @method     ChildCharactersQuery groupByInjuries() Group by the injuries column
 * @method     ChildCharactersQuery groupByMoney() Group by the money column
 * @method     ChildCharactersQuery groupBySkillAcrobatics() Group by the skill_acrobatics column
 * @method     ChildCharactersQuery groupBySkillAthletics() Group by the skill_athletics column
 * @method     ChildCharactersQuery groupBySkillCharm() Group by the skill_charm column
 * @method     ChildCharactersQuery groupBySkillCombat() Group by the skill_combat column
 * @method     ChildCharactersQuery groupBySkillCommand() Group by the skill_command column
 * @method     ChildCharactersQuery groupBySkillGeneralEd() Group by the skill_general_ed column
 * @method     ChildCharactersQuery groupBySkillMedicineEd() Group by the skill_medicine_ed column
 * @method     ChildCharactersQuery groupBySkillOccultEd() Group by the skill_occult_ed column
 * @method     ChildCharactersQuery groupBySkillPokemonEd() Group by the skill_pokemon_ed column
 * @method     ChildCharactersQuery groupBySkillTechnologyEd() Group by the skill_technology_ed column
 * @method     ChildCharactersQuery groupBySkillFocus() Group by the skill_focus column
 * @method     ChildCharactersQuery groupBySkillGuile() Group by the skill_guile column
 * @method     ChildCharactersQuery groupBySkillIntimidate() Group by the skill_intimidate column
 * @method     ChildCharactersQuery groupBySkillIntuition() Group by the skill_intuition column
 * @method     ChildCharactersQuery groupBySkillPerception() Group by the skill_perception column
 * @method     ChildCharactersQuery groupBySkillStealth() Group by the skill_stealth column
 * @method     ChildCharactersQuery groupBySkillSurvival() Group by the skill_survival column
 * @method     ChildCharactersQuery groupByApSpent() Group by the ap_spent column
 * @method     ChildCharactersQuery groupByApBound() Group by the ap_bound column
 * @method     ChildCharactersQuery groupByApDrained() Group by the ap_drained column
 * @method     ChildCharactersQuery groupByBackgroundName() Group by the background_name column
 * @method     ChildCharactersQuery groupByBackgroundAdept() Group by the background_adept column
 * @method     ChildCharactersQuery groupByBackgroundNovice() Group by the background_novice column
 * @method     ChildCharactersQuery groupByBackgroundPthc1() Group by the background_pthc1 column
 * @method     ChildCharactersQuery groupByBackgroundPthc2() Group by the background_pthc2 column
 * @method     ChildCharactersQuery groupByBackgroundPthc3() Group by the background_pthc3 column
 * @method     ChildCharactersQuery groupByNotes() Group by the notes column
 * @method     ChildCharactersQuery groupByNature() Group by the nature column
 * @method     ChildCharactersQuery groupBySheetType() Group by the sheet_type column
 *
 * @method     ChildCharactersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCharactersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCharactersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCharactersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCharactersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCharactersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCharactersQuery leftJoinCampaigns($relationAlias = null) Adds a LEFT JOIN clause to the query using the Campaigns relation
 * @method     ChildCharactersQuery rightJoinCampaigns($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Campaigns relation
 * @method     ChildCharactersQuery innerJoinCampaigns($relationAlias = null) Adds a INNER JOIN clause to the query using the Campaigns relation
 *
 * @method     ChildCharactersQuery joinWithCampaigns($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Campaigns relation
 *
 * @method     ChildCharactersQuery leftJoinWithCampaigns() Adds a LEFT JOIN clause and with to the query using the Campaigns relation
 * @method     ChildCharactersQuery rightJoinWithCampaigns() Adds a RIGHT JOIN clause and with to the query using the Campaigns relation
 * @method     ChildCharactersQuery innerJoinWithCampaigns() Adds a INNER JOIN clause and with to the query using the Campaigns relation
 *
 * @method     ChildCharactersQuery leftJoinBattleEntries($relationAlias = null) Adds a LEFT JOIN clause to the query using the BattleEntries relation
 * @method     ChildCharactersQuery rightJoinBattleEntries($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BattleEntries relation
 * @method     ChildCharactersQuery innerJoinBattleEntries($relationAlias = null) Adds a INNER JOIN clause to the query using the BattleEntries relation
 *
 * @method     ChildCharactersQuery joinWithBattleEntries($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the BattleEntries relation
 *
 * @method     ChildCharactersQuery leftJoinWithBattleEntries() Adds a LEFT JOIN clause and with to the query using the BattleEntries relation
 * @method     ChildCharactersQuery rightJoinWithBattleEntries() Adds a RIGHT JOIN clause and with to the query using the BattleEntries relation
 * @method     ChildCharactersQuery innerJoinWithBattleEntries() Adds a INNER JOIN clause and with to the query using the BattleEntries relation
 *
 * @method     ChildCharactersQuery leftJoinCharacterAbilities($relationAlias = null) Adds a LEFT JOIN clause to the query using the CharacterAbilities relation
 * @method     ChildCharactersQuery rightJoinCharacterAbilities($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CharacterAbilities relation
 * @method     ChildCharactersQuery innerJoinCharacterAbilities($relationAlias = null) Adds a INNER JOIN clause to the query using the CharacterAbilities relation
 *
 * @method     ChildCharactersQuery joinWithCharacterAbilities($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CharacterAbilities relation
 *
 * @method     ChildCharactersQuery leftJoinWithCharacterAbilities() Adds a LEFT JOIN clause and with to the query using the CharacterAbilities relation
 * @method     ChildCharactersQuery rightJoinWithCharacterAbilities() Adds a RIGHT JOIN clause and with to the query using the CharacterAbilities relation
 * @method     ChildCharactersQuery innerJoinWithCharacterAbilities() Adds a INNER JOIN clause and with to the query using the CharacterAbilities relation
 *
 * @method     ChildCharactersQuery leftJoinCharacterBuffs($relationAlias = null) Adds a LEFT JOIN clause to the query using the CharacterBuffs relation
 * @method     ChildCharactersQuery rightJoinCharacterBuffs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CharacterBuffs relation
 * @method     ChildCharactersQuery innerJoinCharacterBuffs($relationAlias = null) Adds a INNER JOIN clause to the query using the CharacterBuffs relation
 *
 * @method     ChildCharactersQuery joinWithCharacterBuffs($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CharacterBuffs relation
 *
 * @method     ChildCharactersQuery leftJoinWithCharacterBuffs() Adds a LEFT JOIN clause and with to the query using the CharacterBuffs relation
 * @method     ChildCharactersQuery rightJoinWithCharacterBuffs() Adds a RIGHT JOIN clause and with to the query using the CharacterBuffs relation
 * @method     ChildCharactersQuery innerJoinWithCharacterBuffs() Adds a INNER JOIN clause and with to the query using the CharacterBuffs relation
 *
 * @method     ChildCharactersQuery leftJoinCharacterMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the CharacterMoves relation
 * @method     ChildCharactersQuery rightJoinCharacterMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CharacterMoves relation
 * @method     ChildCharactersQuery innerJoinCharacterMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the CharacterMoves relation
 *
 * @method     ChildCharactersQuery joinWithCharacterMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CharacterMoves relation
 *
 * @method     ChildCharactersQuery leftJoinWithCharacterMoves() Adds a LEFT JOIN clause and with to the query using the CharacterMoves relation
 * @method     ChildCharactersQuery rightJoinWithCharacterMoves() Adds a RIGHT JOIN clause and with to the query using the CharacterMoves relation
 * @method     ChildCharactersQuery innerJoinWithCharacterMoves() Adds a INNER JOIN clause and with to the query using the CharacterMoves relation
 *
 * @method     \Propel\PtuToolkit\CampaignsQuery|\Propel\PtuToolkit\BattleEntriesQuery|\Propel\PtuToolkit\CharacterAbilitiesQuery|\Propel\PtuToolkit\CharacterBuffsQuery|\Propel\PtuToolkit\CharacterMovesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCharacters findOne(ConnectionInterface $con = null) Return the first ChildCharacters matching the query
 * @method     ChildCharacters findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCharacters matching the query, or a new ChildCharacters object populated from the query conditions when no match is found
 *
 * @method     ChildCharacters findOneByCharacterId(int $character_id) Return the first ChildCharacters filtered by the character_id column
 * @method     ChildCharacters findOneByCampaignId(int $campaign_id) Return the first ChildCharacters filtered by the campaign_id column
 * @method     ChildCharacters findOneByType(string $type) Return the first ChildCharacters filtered by the type column
 * @method     ChildCharacters findOneByPokedexNo(string $pokedex_no) Return the first ChildCharacters filtered by the pokedex_no column
 * @method     ChildCharacters findOneByPokedexId(int $pokedex_id) Return the first ChildCharacters filtered by the pokedex_id column
 * @method     ChildCharacters findOneByName(string $name) Return the first ChildCharacters filtered by the name column
 * @method     ChildCharacters findOneByOwner(int $owner) Return the first ChildCharacters filtered by the owner column
 * @method     ChildCharacters findOneByAge(string $age) Return the first ChildCharacters filtered by the age column
 * @method     ChildCharacters findOneByWeight(string $weight) Return the first ChildCharacters filtered by the weight column
 * @method     ChildCharacters findOneByHeight(string $height) Return the first ChildCharacters filtered by the height column
 * @method     ChildCharacters findOneBySex(string $sex) Return the first ChildCharacters filtered by the sex column
 * @method     ChildCharacters findOneByType1(string $base_type1) Return the first ChildCharacters filtered by the base_type1 column
 * @method     ChildCharacters findOneByType2(string $base_type2) Return the first ChildCharacters filtered by the base_type2 column
 * @method     ChildCharacters findOneByLevel(int $level) Return the first ChildCharacters filtered by the level column
 * @method     ChildCharacters findOneByExp(int $exp) Return the first ChildCharacters filtered by the exp column
 * @method     ChildCharacters findOneByBaseHp(int $base_hp) Return the first ChildCharacters filtered by the base_hp column
 * @method     ChildCharacters findOneByBaseAtk(int $base_atk) Return the first ChildCharacters filtered by the base_atk column
 * @method     ChildCharacters findOneByBaseDef(int $base_def) Return the first ChildCharacters filtered by the base_def column
 * @method     ChildCharacters findOneByBaseSatk(int $base_satk) Return the first ChildCharacters filtered by the base_satk column
 * @method     ChildCharacters findOneByBaseSdef(int $base_sdef) Return the first ChildCharacters filtered by the base_sdef column
 * @method     ChildCharacters findOneByBaseSpd(int $base_spd) Return the first ChildCharacters filtered by the base_spd column
 * @method     ChildCharacters findOneByAddHp(int $add_hp) Return the first ChildCharacters filtered by the add_hp column
 * @method     ChildCharacters findOneByAddAtk(int $add_atk) Return the first ChildCharacters filtered by the add_atk column
 * @method     ChildCharacters findOneByAddDef(int $add_def) Return the first ChildCharacters filtered by the add_def column
 * @method     ChildCharacters findOneByAddSatk(int $add_satk) Return the first ChildCharacters filtered by the add_satk column
 * @method     ChildCharacters findOneByAddSdef(int $add_sdef) Return the first ChildCharacters filtered by the add_sdef column
 * @method     ChildCharacters findOneByAddSpd(int $add_spd) Return the first ChildCharacters filtered by the add_spd column
 * @method     ChildCharacters findOneByHealth(int $health) Return the first ChildCharacters filtered by the health column
 * @method     ChildCharacters findOneByInjuries(int $injuries) Return the first ChildCharacters filtered by the injuries column
 * @method     ChildCharacters findOneByMoney(int $money) Return the first ChildCharacters filtered by the money column
 * @method     ChildCharacters findOneBySkillAcrobatics(int $skill_acrobatics) Return the first ChildCharacters filtered by the skill_acrobatics column
 * @method     ChildCharacters findOneBySkillAthletics(int $skill_athletics) Return the first ChildCharacters filtered by the skill_athletics column
 * @method     ChildCharacters findOneBySkillCharm(int $skill_charm) Return the first ChildCharacters filtered by the skill_charm column
 * @method     ChildCharacters findOneBySkillCombat(int $skill_combat) Return the first ChildCharacters filtered by the skill_combat column
 * @method     ChildCharacters findOneBySkillCommand(int $skill_command) Return the first ChildCharacters filtered by the skill_command column
 * @method     ChildCharacters findOneBySkillGeneralEd(int $skill_general_ed) Return the first ChildCharacters filtered by the skill_general_ed column
 * @method     ChildCharacters findOneBySkillMedicineEd(int $skill_medicine_ed) Return the first ChildCharacters filtered by the skill_medicine_ed column
 * @method     ChildCharacters findOneBySkillOccultEd(int $skill_occult_ed) Return the first ChildCharacters filtered by the skill_occult_ed column
 * @method     ChildCharacters findOneBySkillPokemonEd(int $skill_pokemon_ed) Return the first ChildCharacters filtered by the skill_pokemon_ed column
 * @method     ChildCharacters findOneBySkillTechnologyEd(int $skill_technology_ed) Return the first ChildCharacters filtered by the skill_technology_ed column
 * @method     ChildCharacters findOneBySkillFocus(int $skill_focus) Return the first ChildCharacters filtered by the skill_focus column
 * @method     ChildCharacters findOneBySkillGuile(int $skill_guile) Return the first ChildCharacters filtered by the skill_guile column
 * @method     ChildCharacters findOneBySkillIntimidate(int $skill_intimidate) Return the first ChildCharacters filtered by the skill_intimidate column
 * @method     ChildCharacters findOneBySkillIntuition(int $skill_intuition) Return the first ChildCharacters filtered by the skill_intuition column
 * @method     ChildCharacters findOneBySkillPerception(int $skill_perception) Return the first ChildCharacters filtered by the skill_perception column
 * @method     ChildCharacters findOneBySkillStealth(int $skill_stealth) Return the first ChildCharacters filtered by the skill_stealth column
 * @method     ChildCharacters findOneBySkillSurvival(int $skill_survival) Return the first ChildCharacters filtered by the skill_survival column
 * @method     ChildCharacters findOneByApSpent(int $ap_spent) Return the first ChildCharacters filtered by the ap_spent column
 * @method     ChildCharacters findOneByApBound(int $ap_bound) Return the first ChildCharacters filtered by the ap_bound column
 * @method     ChildCharacters findOneByApDrained(int $ap_drained) Return the first ChildCharacters filtered by the ap_drained column
 * @method     ChildCharacters findOneByBackgroundName(string $background_name) Return the first ChildCharacters filtered by the background_name column
 * @method     ChildCharacters findOneByBackgroundAdept(string $background_adept) Return the first ChildCharacters filtered by the background_adept column
 * @method     ChildCharacters findOneByBackgroundNovice(string $background_novice) Return the first ChildCharacters filtered by the background_novice column
 * @method     ChildCharacters findOneByBackgroundPthc1(string $background_pthc1) Return the first ChildCharacters filtered by the background_pthc1 column
 * @method     ChildCharacters findOneByBackgroundPthc2(string $background_pthc2) Return the first ChildCharacters filtered by the background_pthc2 column
 * @method     ChildCharacters findOneByBackgroundPthc3(string $background_pthc3) Return the first ChildCharacters filtered by the background_pthc3 column
 * @method     ChildCharacters findOneByNotes(string $notes) Return the first ChildCharacters filtered by the notes column
 * @method     ChildCharacters findOneByNature(string $nature) Return the first ChildCharacters filtered by the nature column
 * @method     ChildCharacters findOneBySheetType(string $sheet_type) Return the first ChildCharacters filtered by the sheet_type column *

 * @method     ChildCharacters requirePk($key, ConnectionInterface $con = null) Return the ChildCharacters by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOne(ConnectionInterface $con = null) Return the first ChildCharacters matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacters requireOneByCharacterId(int $character_id) Return the first ChildCharacters filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByCampaignId(int $campaign_id) Return the first ChildCharacters filtered by the campaign_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByType(string $type) Return the first ChildCharacters filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByPokedexNo(string $pokedex_no) Return the first ChildCharacters filtered by the pokedex_no column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByPokedexId(int $pokedex_id) Return the first ChildCharacters filtered by the pokedex_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByName(string $name) Return the first ChildCharacters filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByOwner(int $owner) Return the first ChildCharacters filtered by the owner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAge(string $age) Return the first ChildCharacters filtered by the age column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByWeight(string $weight) Return the first ChildCharacters filtered by the weight column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByHeight(string $height) Return the first ChildCharacters filtered by the height column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySex(string $sex) Return the first ChildCharacters filtered by the sex column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByType1(string $base_type1) Return the first ChildCharacters filtered by the base_type1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByType2(string $base_type2) Return the first ChildCharacters filtered by the base_type2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByLevel(int $level) Return the first ChildCharacters filtered by the level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByExp(int $exp) Return the first ChildCharacters filtered by the exp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseHp(int $base_hp) Return the first ChildCharacters filtered by the base_hp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseAtk(int $base_atk) Return the first ChildCharacters filtered by the base_atk column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseDef(int $base_def) Return the first ChildCharacters filtered by the base_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseSatk(int $base_satk) Return the first ChildCharacters filtered by the base_satk column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseSdef(int $base_sdef) Return the first ChildCharacters filtered by the base_sdef column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBaseSpd(int $base_spd) Return the first ChildCharacters filtered by the base_spd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddHp(int $add_hp) Return the first ChildCharacters filtered by the add_hp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddAtk(int $add_atk) Return the first ChildCharacters filtered by the add_atk column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddDef(int $add_def) Return the first ChildCharacters filtered by the add_def column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddSatk(int $add_satk) Return the first ChildCharacters filtered by the add_satk column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddSdef(int $add_sdef) Return the first ChildCharacters filtered by the add_sdef column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByAddSpd(int $add_spd) Return the first ChildCharacters filtered by the add_spd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByHealth(int $health) Return the first ChildCharacters filtered by the health column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByInjuries(int $injuries) Return the first ChildCharacters filtered by the injuries column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByMoney(int $money) Return the first ChildCharacters filtered by the money column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillAcrobatics(int $skill_acrobatics) Return the first ChildCharacters filtered by the skill_acrobatics column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillAthletics(int $skill_athletics) Return the first ChildCharacters filtered by the skill_athletics column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillCharm(int $skill_charm) Return the first ChildCharacters filtered by the skill_charm column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillCombat(int $skill_combat) Return the first ChildCharacters filtered by the skill_combat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillCommand(int $skill_command) Return the first ChildCharacters filtered by the skill_command column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillGeneralEd(int $skill_general_ed) Return the first ChildCharacters filtered by the skill_general_ed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillMedicineEd(int $skill_medicine_ed) Return the first ChildCharacters filtered by the skill_medicine_ed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillOccultEd(int $skill_occult_ed) Return the first ChildCharacters filtered by the skill_occult_ed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillPokemonEd(int $skill_pokemon_ed) Return the first ChildCharacters filtered by the skill_pokemon_ed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillTechnologyEd(int $skill_technology_ed) Return the first ChildCharacters filtered by the skill_technology_ed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillFocus(int $skill_focus) Return the first ChildCharacters filtered by the skill_focus column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillGuile(int $skill_guile) Return the first ChildCharacters filtered by the skill_guile column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillIntimidate(int $skill_intimidate) Return the first ChildCharacters filtered by the skill_intimidate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillIntuition(int $skill_intuition) Return the first ChildCharacters filtered by the skill_intuition column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillPerception(int $skill_perception) Return the first ChildCharacters filtered by the skill_perception column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillStealth(int $skill_stealth) Return the first ChildCharacters filtered by the skill_stealth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySkillSurvival(int $skill_survival) Return the first ChildCharacters filtered by the skill_survival column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByApSpent(int $ap_spent) Return the first ChildCharacters filtered by the ap_spent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByApBound(int $ap_bound) Return the first ChildCharacters filtered by the ap_bound column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByApDrained(int $ap_drained) Return the first ChildCharacters filtered by the ap_drained column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundName(string $background_name) Return the first ChildCharacters filtered by the background_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundAdept(string $background_adept) Return the first ChildCharacters filtered by the background_adept column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundNovice(string $background_novice) Return the first ChildCharacters filtered by the background_novice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundPthc1(string $background_pthc1) Return the first ChildCharacters filtered by the background_pthc1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundPthc2(string $background_pthc2) Return the first ChildCharacters filtered by the background_pthc2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByBackgroundPthc3(string $background_pthc3) Return the first ChildCharacters filtered by the background_pthc3 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByNotes(string $notes) Return the first ChildCharacters filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneByNature(string $nature) Return the first ChildCharacters filtered by the nature column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacters requireOneBySheetType(string $sheet_type) Return the first ChildCharacters filtered by the sheet_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacters[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCharacters objects based on current ModelCriteria
 * @method     ChildCharacters[]|ObjectCollection findByCharacterId(int $character_id) Return ChildCharacters objects filtered by the character_id column
 * @method     ChildCharacters[]|ObjectCollection findByCampaignId(int $campaign_id) Return ChildCharacters objects filtered by the campaign_id column
 * @method     ChildCharacters[]|ObjectCollection findByType(string $type) Return ChildCharacters objects filtered by the type column
 * @method     ChildCharacters[]|ObjectCollection findByPokedexNo(string $pokedex_no) Return ChildCharacters objects filtered by the pokedex_no column
 * @method     ChildCharacters[]|ObjectCollection findByPokedexId(int $pokedex_id) Return ChildCharacters objects filtered by the pokedex_id column
 * @method     ChildCharacters[]|ObjectCollection findByName(string $name) Return ChildCharacters objects filtered by the name column
 * @method     ChildCharacters[]|ObjectCollection findByOwner(int $owner) Return ChildCharacters objects filtered by the owner column
 * @method     ChildCharacters[]|ObjectCollection findByAge(string $age) Return ChildCharacters objects filtered by the age column
 * @method     ChildCharacters[]|ObjectCollection findByWeight(string $weight) Return ChildCharacters objects filtered by the weight column
 * @method     ChildCharacters[]|ObjectCollection findByHeight(string $height) Return ChildCharacters objects filtered by the height column
 * @method     ChildCharacters[]|ObjectCollection findBySex(string $sex) Return ChildCharacters objects filtered by the sex column
 * @method     ChildCharacters[]|ObjectCollection findByType1(string $base_type1) Return ChildCharacters objects filtered by the base_type1 column
 * @method     ChildCharacters[]|ObjectCollection findByType2(string $base_type2) Return ChildCharacters objects filtered by the base_type2 column
 * @method     ChildCharacters[]|ObjectCollection findByLevel(int $level) Return ChildCharacters objects filtered by the level column
 * @method     ChildCharacters[]|ObjectCollection findByExp(int $exp) Return ChildCharacters objects filtered by the exp column
 * @method     ChildCharacters[]|ObjectCollection findByBaseHp(int $base_hp) Return ChildCharacters objects filtered by the base_hp column
 * @method     ChildCharacters[]|ObjectCollection findByBaseAtk(int $base_atk) Return ChildCharacters objects filtered by the base_atk column
 * @method     ChildCharacters[]|ObjectCollection findByBaseDef(int $base_def) Return ChildCharacters objects filtered by the base_def column
 * @method     ChildCharacters[]|ObjectCollection findByBaseSatk(int $base_satk) Return ChildCharacters objects filtered by the base_satk column
 * @method     ChildCharacters[]|ObjectCollection findByBaseSdef(int $base_sdef) Return ChildCharacters objects filtered by the base_sdef column
 * @method     ChildCharacters[]|ObjectCollection findByBaseSpd(int $base_spd) Return ChildCharacters objects filtered by the base_spd column
 * @method     ChildCharacters[]|ObjectCollection findByAddHp(int $add_hp) Return ChildCharacters objects filtered by the add_hp column
 * @method     ChildCharacters[]|ObjectCollection findByAddAtk(int $add_atk) Return ChildCharacters objects filtered by the add_atk column
 * @method     ChildCharacters[]|ObjectCollection findByAddDef(int $add_def) Return ChildCharacters objects filtered by the add_def column
 * @method     ChildCharacters[]|ObjectCollection findByAddSatk(int $add_satk) Return ChildCharacters objects filtered by the add_satk column
 * @method     ChildCharacters[]|ObjectCollection findByAddSdef(int $add_sdef) Return ChildCharacters objects filtered by the add_sdef column
 * @method     ChildCharacters[]|ObjectCollection findByAddSpd(int $add_spd) Return ChildCharacters objects filtered by the add_spd column
 * @method     ChildCharacters[]|ObjectCollection findByHealth(int $health) Return ChildCharacters objects filtered by the health column
 * @method     ChildCharacters[]|ObjectCollection findByInjuries(int $injuries) Return ChildCharacters objects filtered by the injuries column
 * @method     ChildCharacters[]|ObjectCollection findByMoney(int $money) Return ChildCharacters objects filtered by the money column
 * @method     ChildCharacters[]|ObjectCollection findBySkillAcrobatics(int $skill_acrobatics) Return ChildCharacters objects filtered by the skill_acrobatics column
 * @method     ChildCharacters[]|ObjectCollection findBySkillAthletics(int $skill_athletics) Return ChildCharacters objects filtered by the skill_athletics column
 * @method     ChildCharacters[]|ObjectCollection findBySkillCharm(int $skill_charm) Return ChildCharacters objects filtered by the skill_charm column
 * @method     ChildCharacters[]|ObjectCollection findBySkillCombat(int $skill_combat) Return ChildCharacters objects filtered by the skill_combat column
 * @method     ChildCharacters[]|ObjectCollection findBySkillCommand(int $skill_command) Return ChildCharacters objects filtered by the skill_command column
 * @method     ChildCharacters[]|ObjectCollection findBySkillGeneralEd(int $skill_general_ed) Return ChildCharacters objects filtered by the skill_general_ed column
 * @method     ChildCharacters[]|ObjectCollection findBySkillMedicineEd(int $skill_medicine_ed) Return ChildCharacters objects filtered by the skill_medicine_ed column
 * @method     ChildCharacters[]|ObjectCollection findBySkillOccultEd(int $skill_occult_ed) Return ChildCharacters objects filtered by the skill_occult_ed column
 * @method     ChildCharacters[]|ObjectCollection findBySkillPokemonEd(int $skill_pokemon_ed) Return ChildCharacters objects filtered by the skill_pokemon_ed column
 * @method     ChildCharacters[]|ObjectCollection findBySkillTechnologyEd(int $skill_technology_ed) Return ChildCharacters objects filtered by the skill_technology_ed column
 * @method     ChildCharacters[]|ObjectCollection findBySkillFocus(int $skill_focus) Return ChildCharacters objects filtered by the skill_focus column
 * @method     ChildCharacters[]|ObjectCollection findBySkillGuile(int $skill_guile) Return ChildCharacters objects filtered by the skill_guile column
 * @method     ChildCharacters[]|ObjectCollection findBySkillIntimidate(int $skill_intimidate) Return ChildCharacters objects filtered by the skill_intimidate column
 * @method     ChildCharacters[]|ObjectCollection findBySkillIntuition(int $skill_intuition) Return ChildCharacters objects filtered by the skill_intuition column
 * @method     ChildCharacters[]|ObjectCollection findBySkillPerception(int $skill_perception) Return ChildCharacters objects filtered by the skill_perception column
 * @method     ChildCharacters[]|ObjectCollection findBySkillStealth(int $skill_stealth) Return ChildCharacters objects filtered by the skill_stealth column
 * @method     ChildCharacters[]|ObjectCollection findBySkillSurvival(int $skill_survival) Return ChildCharacters objects filtered by the skill_survival column
 * @method     ChildCharacters[]|ObjectCollection findByApSpent(int $ap_spent) Return ChildCharacters objects filtered by the ap_spent column
 * @method     ChildCharacters[]|ObjectCollection findByApBound(int $ap_bound) Return ChildCharacters objects filtered by the ap_bound column
 * @method     ChildCharacters[]|ObjectCollection findByApDrained(int $ap_drained) Return ChildCharacters objects filtered by the ap_drained column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundName(string $background_name) Return ChildCharacters objects filtered by the background_name column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundAdept(string $background_adept) Return ChildCharacters objects filtered by the background_adept column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundNovice(string $background_novice) Return ChildCharacters objects filtered by the background_novice column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundPthc1(string $background_pthc1) Return ChildCharacters objects filtered by the background_pthc1 column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundPthc2(string $background_pthc2) Return ChildCharacters objects filtered by the background_pthc2 column
 * @method     ChildCharacters[]|ObjectCollection findByBackgroundPthc3(string $background_pthc3) Return ChildCharacters objects filtered by the background_pthc3 column
 * @method     ChildCharacters[]|ObjectCollection findByNotes(string $notes) Return ChildCharacters objects filtered by the notes column
 * @method     ChildCharacters[]|ObjectCollection findByNature(string $nature) Return ChildCharacters objects filtered by the nature column
 * @method     ChildCharacters[]|ObjectCollection findBySheetType(string $sheet_type) Return ChildCharacters objects filtered by the sheet_type column
 * @method     ChildCharacters[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CharactersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\CharactersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\Characters', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCharactersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCharactersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCharactersQuery) {
            return $criteria;
        }
        $query = new ChildCharactersQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCharacters|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CharactersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CharactersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCharacters A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT character_id, campaign_id, type, pokedex_no, pokedex_id, name, owner, age, weight, height, sex, base_type1, base_type2, level, exp, base_hp, base_atk, base_def, base_satk, base_sdef, base_spd, add_hp, add_atk, add_def, add_satk, add_sdef, add_spd, health, injuries, money, skill_acrobatics, skill_athletics, skill_charm, skill_combat, skill_command, skill_general_ed, skill_medicine_ed, skill_occult_ed, skill_pokemon_ed, skill_technology_ed, skill_focus, skill_guile, skill_intimidate, skill_intuition, skill_perception, skill_stealth, skill_survival, ap_spent, ap_bound, ap_drained, background_name, background_adept, background_novice, background_pthc1, background_pthc2, background_pthc3, notes, nature, sheet_type FROM characters WHERE character_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCharacters $obj */
            $obj = new ChildCharacters();
            $obj->hydrate($row);
            CharactersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCharacters|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the character_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterId(1234); // WHERE character_id = 1234
     * $query->filterByCharacterId(array(12, 34)); // WHERE character_id IN (12, 34)
     * $query->filterByCharacterId(array('min' => 12)); // WHERE character_id > 12
     * </code>
     *
     * @param     mixed $characterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the campaign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCampaignId(1234); // WHERE campaign_id = 1234
     * $query->filterByCampaignId(array(12, 34)); // WHERE campaign_id IN (12, 34)
     * $query->filterByCampaignId(array('min' => 12)); // WHERE campaign_id > 12
     * </code>
     *
     * @see       filterByCampaigns()
     *
     * @param     mixed $campaignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCampaignId($campaignId = null, $comparison = null)
    {
        if (is_array($campaignId)) {
            $useMinMax = false;
            if (isset($campaignId['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_CAMPAIGN_ID, $campaignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($campaignId['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_CAMPAIGN_ID, $campaignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_CAMPAIGN_ID, $campaignId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the pokedex_no column
     *
     * Example usage:
     * <code>
     * $query->filterByPokedexNo('fooValue');   // WHERE pokedex_no = 'fooValue'
     * $query->filterByPokedexNo('%fooValue%', Criteria::LIKE); // WHERE pokedex_no LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pokedexNo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByPokedexNo($pokedexNo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pokedexNo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_POKEDEX_NO, $pokedexNo, $comparison);
    }

    /**
     * Filter the query on the pokedex_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPokedexId(1234); // WHERE pokedex_id = 1234
     * $query->filterByPokedexId(array(12, 34)); // WHERE pokedex_id IN (12, 34)
     * $query->filterByPokedexId(array('min' => 12)); // WHERE pokedex_id > 12
     * </code>
     *
     * @param     mixed $pokedexId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByPokedexId($pokedexId = null, $comparison = null)
    {
        if (is_array($pokedexId)) {
            $useMinMax = false;
            if (isset($pokedexId['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_POKEDEX_ID, $pokedexId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexId['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_POKEDEX_ID, $pokedexId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_POKEDEX_ID, $pokedexId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the owner column
     *
     * Example usage:
     * <code>
     * $query->filterByOwner(1234); // WHERE owner = 1234
     * $query->filterByOwner(array(12, 34)); // WHERE owner IN (12, 34)
     * $query->filterByOwner(array('min' => 12)); // WHERE owner > 12
     * </code>
     *
     * @param     mixed $owner The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByOwner($owner = null, $comparison = null)
    {
        if (is_array($owner)) {
            $useMinMax = false;
            if (isset($owner['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_OWNER, $owner['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($owner['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_OWNER, $owner['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_OWNER, $owner, $comparison);
    }

    /**
     * Filter the query on the age column
     *
     * Example usage:
     * <code>
     * $query->filterByAge('fooValue');   // WHERE age = 'fooValue'
     * $query->filterByAge('%fooValue%', Criteria::LIKE); // WHERE age LIKE '%fooValue%'
     * </code>
     *
     * @param     string $age The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAge($age = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($age)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_AGE, $age, $comparison);
    }

    /**
     * Filter the query on the weight column
     *
     * Example usage:
     * <code>
     * $query->filterByWeight('fooValue');   // WHERE weight = 'fooValue'
     * $query->filterByWeight('%fooValue%', Criteria::LIKE); // WHERE weight LIKE '%fooValue%'
     * </code>
     *
     * @param     string $weight The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($weight)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_WEIGHT, $weight, $comparison);
    }

    /**
     * Filter the query on the height column
     *
     * Example usage:
     * <code>
     * $query->filterByHeight('fooValue');   // WHERE height = 'fooValue'
     * $query->filterByHeight('%fooValue%', Criteria::LIKE); // WHERE height LIKE '%fooValue%'
     * </code>
     *
     * @param     string $height The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByHeight($height = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($height)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_HEIGHT, $height, $comparison);
    }

    /**
     * Filter the query on the sex column
     *
     * Example usage:
     * <code>
     * $query->filterBySex('fooValue');   // WHERE sex = 'fooValue'
     * $query->filterBySex('%fooValue%', Criteria::LIKE); // WHERE sex LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sex The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySex($sex = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sex)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SEX, $sex, $comparison);
    }

    /**
     * Filter the query on the base_type1 column
     *
     * Example usage:
     * <code>
     * $query->filterByType1('fooValue');   // WHERE base_type1 = 'fooValue'
     * $query->filterByType1('%fooValue%', Criteria::LIKE); // WHERE base_type1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type1 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByType1($type1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type1)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_TYPE1, $type1, $comparison);
    }

    /**
     * Filter the query on the base_type2 column
     *
     * Example usage:
     * <code>
     * $query->filterByType2('fooValue');   // WHERE base_type2 = 'fooValue'
     * $query->filterByType2('%fooValue%', Criteria::LIKE); // WHERE base_type2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type2 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByType2($type2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type2)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_TYPE2, $type2, $comparison);
    }

    /**
     * Filter the query on the level column
     *
     * Example usage:
     * <code>
     * $query->filterByLevel(1234); // WHERE level = 1234
     * $query->filterByLevel(array(12, 34)); // WHERE level IN (12, 34)
     * $query->filterByLevel(array('min' => 12)); // WHERE level > 12
     * </code>
     *
     * @param     mixed $level The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByLevel($level = null, $comparison = null)
    {
        if (is_array($level)) {
            $useMinMax = false;
            if (isset($level['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_LEVEL, $level['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($level['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_LEVEL, $level['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_LEVEL, $level, $comparison);
    }

    /**
     * Filter the query on the exp column
     *
     * Example usage:
     * <code>
     * $query->filterByExp(1234); // WHERE exp = 1234
     * $query->filterByExp(array(12, 34)); // WHERE exp IN (12, 34)
     * $query->filterByExp(array('min' => 12)); // WHERE exp > 12
     * </code>
     *
     * @param     mixed $exp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByExp($exp = null, $comparison = null)
    {
        if (is_array($exp)) {
            $useMinMax = false;
            if (isset($exp['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_EXP, $exp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exp['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_EXP, $exp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_EXP, $exp, $comparison);
    }

    /**
     * Filter the query on the base_hp column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseHp(1234); // WHERE base_hp = 1234
     * $query->filterByBaseHp(array(12, 34)); // WHERE base_hp IN (12, 34)
     * $query->filterByBaseHp(array('min' => 12)); // WHERE base_hp > 12
     * </code>
     *
     * @param     mixed $baseHp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseHp($baseHp = null, $comparison = null)
    {
        if (is_array($baseHp)) {
            $useMinMax = false;
            if (isset($baseHp['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_HP, $baseHp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseHp['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_HP, $baseHp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_HP, $baseHp, $comparison);
    }

    /**
     * Filter the query on the base_atk column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseAtk(1234); // WHERE base_atk = 1234
     * $query->filterByBaseAtk(array(12, 34)); // WHERE base_atk IN (12, 34)
     * $query->filterByBaseAtk(array('min' => 12)); // WHERE base_atk > 12
     * </code>
     *
     * @param     mixed $baseAtk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseAtk($baseAtk = null, $comparison = null)
    {
        if (is_array($baseAtk)) {
            $useMinMax = false;
            if (isset($baseAtk['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_ATK, $baseAtk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseAtk['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_ATK, $baseAtk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_ATK, $baseAtk, $comparison);
    }

    /**
     * Filter the query on the base_def column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseDef(1234); // WHERE base_def = 1234
     * $query->filterByBaseDef(array(12, 34)); // WHERE base_def IN (12, 34)
     * $query->filterByBaseDef(array('min' => 12)); // WHERE base_def > 12
     * </code>
     *
     * @param     mixed $baseDef The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseDef($baseDef = null, $comparison = null)
    {
        if (is_array($baseDef)) {
            $useMinMax = false;
            if (isset($baseDef['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_DEF, $baseDef['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseDef['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_DEF, $baseDef['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_DEF, $baseDef, $comparison);
    }

    /**
     * Filter the query on the base_satk column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseSatk(1234); // WHERE base_satk = 1234
     * $query->filterByBaseSatk(array(12, 34)); // WHERE base_satk IN (12, 34)
     * $query->filterByBaseSatk(array('min' => 12)); // WHERE base_satk > 12
     * </code>
     *
     * @param     mixed $baseSatk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseSatk($baseSatk = null, $comparison = null)
    {
        if (is_array($baseSatk)) {
            $useMinMax = false;
            if (isset($baseSatk['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SATK, $baseSatk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseSatk['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SATK, $baseSatk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_SATK, $baseSatk, $comparison);
    }

    /**
     * Filter the query on the base_sdef column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseSdef(1234); // WHERE base_sdef = 1234
     * $query->filterByBaseSdef(array(12, 34)); // WHERE base_sdef IN (12, 34)
     * $query->filterByBaseSdef(array('min' => 12)); // WHERE base_sdef > 12
     * </code>
     *
     * @param     mixed $baseSdef The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseSdef($baseSdef = null, $comparison = null)
    {
        if (is_array($baseSdef)) {
            $useMinMax = false;
            if (isset($baseSdef['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SDEF, $baseSdef['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseSdef['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SDEF, $baseSdef['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_SDEF, $baseSdef, $comparison);
    }

    /**
     * Filter the query on the base_spd column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseSpd(1234); // WHERE base_spd = 1234
     * $query->filterByBaseSpd(array(12, 34)); // WHERE base_spd IN (12, 34)
     * $query->filterByBaseSpd(array('min' => 12)); // WHERE base_spd > 12
     * </code>
     *
     * @param     mixed $baseSpd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBaseSpd($baseSpd = null, $comparison = null)
    {
        if (is_array($baseSpd)) {
            $useMinMax = false;
            if (isset($baseSpd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SPD, $baseSpd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseSpd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_BASE_SPD, $baseSpd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BASE_SPD, $baseSpd, $comparison);
    }

    /**
     * Filter the query on the add_hp column
     *
     * Example usage:
     * <code>
     * $query->filterByAddHp(1234); // WHERE add_hp = 1234
     * $query->filterByAddHp(array(12, 34)); // WHERE add_hp IN (12, 34)
     * $query->filterByAddHp(array('min' => 12)); // WHERE add_hp > 12
     * </code>
     *
     * @param     mixed $addHp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddHp($addHp = null, $comparison = null)
    {
        if (is_array($addHp)) {
            $useMinMax = false;
            if (isset($addHp['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_HP, $addHp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addHp['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_HP, $addHp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_HP, $addHp, $comparison);
    }

    /**
     * Filter the query on the add_atk column
     *
     * Example usage:
     * <code>
     * $query->filterByAddAtk(1234); // WHERE add_atk = 1234
     * $query->filterByAddAtk(array(12, 34)); // WHERE add_atk IN (12, 34)
     * $query->filterByAddAtk(array('min' => 12)); // WHERE add_atk > 12
     * </code>
     *
     * @param     mixed $addAtk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddAtk($addAtk = null, $comparison = null)
    {
        if (is_array($addAtk)) {
            $useMinMax = false;
            if (isset($addAtk['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_ATK, $addAtk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addAtk['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_ATK, $addAtk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_ATK, $addAtk, $comparison);
    }

    /**
     * Filter the query on the add_def column
     *
     * Example usage:
     * <code>
     * $query->filterByAddDef(1234); // WHERE add_def = 1234
     * $query->filterByAddDef(array(12, 34)); // WHERE add_def IN (12, 34)
     * $query->filterByAddDef(array('min' => 12)); // WHERE add_def > 12
     * </code>
     *
     * @param     mixed $addDef The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddDef($addDef = null, $comparison = null)
    {
        if (is_array($addDef)) {
            $useMinMax = false;
            if (isset($addDef['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_DEF, $addDef['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addDef['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_DEF, $addDef['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_DEF, $addDef, $comparison);
    }

    /**
     * Filter the query on the add_satk column
     *
     * Example usage:
     * <code>
     * $query->filterByAddSatk(1234); // WHERE add_satk = 1234
     * $query->filterByAddSatk(array(12, 34)); // WHERE add_satk IN (12, 34)
     * $query->filterByAddSatk(array('min' => 12)); // WHERE add_satk > 12
     * </code>
     *
     * @param     mixed $addSatk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddSatk($addSatk = null, $comparison = null)
    {
        if (is_array($addSatk)) {
            $useMinMax = false;
            if (isset($addSatk['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SATK, $addSatk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addSatk['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SATK, $addSatk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_SATK, $addSatk, $comparison);
    }

    /**
     * Filter the query on the add_sdef column
     *
     * Example usage:
     * <code>
     * $query->filterByAddSdef(1234); // WHERE add_sdef = 1234
     * $query->filterByAddSdef(array(12, 34)); // WHERE add_sdef IN (12, 34)
     * $query->filterByAddSdef(array('min' => 12)); // WHERE add_sdef > 12
     * </code>
     *
     * @param     mixed $addSdef The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddSdef($addSdef = null, $comparison = null)
    {
        if (is_array($addSdef)) {
            $useMinMax = false;
            if (isset($addSdef['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SDEF, $addSdef['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addSdef['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SDEF, $addSdef['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_SDEF, $addSdef, $comparison);
    }

    /**
     * Filter the query on the add_spd column
     *
     * Example usage:
     * <code>
     * $query->filterByAddSpd(1234); // WHERE add_spd = 1234
     * $query->filterByAddSpd(array(12, 34)); // WHERE add_spd IN (12, 34)
     * $query->filterByAddSpd(array('min' => 12)); // WHERE add_spd > 12
     * </code>
     *
     * @param     mixed $addSpd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByAddSpd($addSpd = null, $comparison = null)
    {
        if (is_array($addSpd)) {
            $useMinMax = false;
            if (isset($addSpd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SPD, $addSpd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addSpd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_ADD_SPD, $addSpd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_ADD_SPD, $addSpd, $comparison);
    }

    /**
     * Filter the query on the health column
     *
     * Example usage:
     * <code>
     * $query->filterByHealth(1234); // WHERE health = 1234
     * $query->filterByHealth(array(12, 34)); // WHERE health IN (12, 34)
     * $query->filterByHealth(array('min' => 12)); // WHERE health > 12
     * </code>
     *
     * @param     mixed $health The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByHealth($health = null, $comparison = null)
    {
        if (is_array($health)) {
            $useMinMax = false;
            if (isset($health['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_HEALTH, $health['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($health['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_HEALTH, $health['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_HEALTH, $health, $comparison);
    }

    /**
     * Filter the query on the injuries column
     *
     * Example usage:
     * <code>
     * $query->filterByInjuries(1234); // WHERE injuries = 1234
     * $query->filterByInjuries(array(12, 34)); // WHERE injuries IN (12, 34)
     * $query->filterByInjuries(array('min' => 12)); // WHERE injuries > 12
     * </code>
     *
     * @param     mixed $injuries The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByInjuries($injuries = null, $comparison = null)
    {
        if (is_array($injuries)) {
            $useMinMax = false;
            if (isset($injuries['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_INJURIES, $injuries['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($injuries['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_INJURIES, $injuries['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_INJURIES, $injuries, $comparison);
    }

    /**
     * Filter the query on the money column
     *
     * Example usage:
     * <code>
     * $query->filterByMoney(1234); // WHERE money = 1234
     * $query->filterByMoney(array(12, 34)); // WHERE money IN (12, 34)
     * $query->filterByMoney(array('min' => 12)); // WHERE money > 12
     * </code>
     *
     * @param     mixed $money The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByMoney($money = null, $comparison = null)
    {
        if (is_array($money)) {
            $useMinMax = false;
            if (isset($money['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_MONEY, $money['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($money['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_MONEY, $money['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_MONEY, $money, $comparison);
    }

    /**
     * Filter the query on the skill_acrobatics column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillAcrobatics(1234); // WHERE skill_acrobatics = 1234
     * $query->filterBySkillAcrobatics(array(12, 34)); // WHERE skill_acrobatics IN (12, 34)
     * $query->filterBySkillAcrobatics(array('min' => 12)); // WHERE skill_acrobatics > 12
     * </code>
     *
     * @param     mixed $skillAcrobatics The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillAcrobatics($skillAcrobatics = null, $comparison = null)
    {
        if (is_array($skillAcrobatics)) {
            $useMinMax = false;
            if (isset($skillAcrobatics['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_ACROBATICS, $skillAcrobatics['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillAcrobatics['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_ACROBATICS, $skillAcrobatics['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_ACROBATICS, $skillAcrobatics, $comparison);
    }

    /**
     * Filter the query on the skill_athletics column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillAthletics(1234); // WHERE skill_athletics = 1234
     * $query->filterBySkillAthletics(array(12, 34)); // WHERE skill_athletics IN (12, 34)
     * $query->filterBySkillAthletics(array('min' => 12)); // WHERE skill_athletics > 12
     * </code>
     *
     * @param     mixed $skillAthletics The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillAthletics($skillAthletics = null, $comparison = null)
    {
        if (is_array($skillAthletics)) {
            $useMinMax = false;
            if (isset($skillAthletics['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_ATHLETICS, $skillAthletics['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillAthletics['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_ATHLETICS, $skillAthletics['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_ATHLETICS, $skillAthletics, $comparison);
    }

    /**
     * Filter the query on the skill_charm column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillCharm(1234); // WHERE skill_charm = 1234
     * $query->filterBySkillCharm(array(12, 34)); // WHERE skill_charm IN (12, 34)
     * $query->filterBySkillCharm(array('min' => 12)); // WHERE skill_charm > 12
     * </code>
     *
     * @param     mixed $skillCharm The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillCharm($skillCharm = null, $comparison = null)
    {
        if (is_array($skillCharm)) {
            $useMinMax = false;
            if (isset($skillCharm['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_CHARM, $skillCharm['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillCharm['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_CHARM, $skillCharm['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_CHARM, $skillCharm, $comparison);
    }

    /**
     * Filter the query on the skill_combat column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillCombat(1234); // WHERE skill_combat = 1234
     * $query->filterBySkillCombat(array(12, 34)); // WHERE skill_combat IN (12, 34)
     * $query->filterBySkillCombat(array('min' => 12)); // WHERE skill_combat > 12
     * </code>
     *
     * @param     mixed $skillCombat The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillCombat($skillCombat = null, $comparison = null)
    {
        if (is_array($skillCombat)) {
            $useMinMax = false;
            if (isset($skillCombat['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMBAT, $skillCombat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillCombat['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMBAT, $skillCombat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMBAT, $skillCombat, $comparison);
    }

    /**
     * Filter the query on the skill_command column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillCommand(1234); // WHERE skill_command = 1234
     * $query->filterBySkillCommand(array(12, 34)); // WHERE skill_command IN (12, 34)
     * $query->filterBySkillCommand(array('min' => 12)); // WHERE skill_command > 12
     * </code>
     *
     * @param     mixed $skillCommand The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillCommand($skillCommand = null, $comparison = null)
    {
        if (is_array($skillCommand)) {
            $useMinMax = false;
            if (isset($skillCommand['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMMAND, $skillCommand['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillCommand['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMMAND, $skillCommand['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_COMMAND, $skillCommand, $comparison);
    }

    /**
     * Filter the query on the skill_general_ed column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillGeneralEd(1234); // WHERE skill_general_ed = 1234
     * $query->filterBySkillGeneralEd(array(12, 34)); // WHERE skill_general_ed IN (12, 34)
     * $query->filterBySkillGeneralEd(array('min' => 12)); // WHERE skill_general_ed > 12
     * </code>
     *
     * @param     mixed $skillGeneralEd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillGeneralEd($skillGeneralEd = null, $comparison = null)
    {
        if (is_array($skillGeneralEd)) {
            $useMinMax = false;
            if (isset($skillGeneralEd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_GENERAL_ED, $skillGeneralEd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillGeneralEd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_GENERAL_ED, $skillGeneralEd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_GENERAL_ED, $skillGeneralEd, $comparison);
    }

    /**
     * Filter the query on the skill_medicine_ed column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillMedicineEd(1234); // WHERE skill_medicine_ed = 1234
     * $query->filterBySkillMedicineEd(array(12, 34)); // WHERE skill_medicine_ed IN (12, 34)
     * $query->filterBySkillMedicineEd(array('min' => 12)); // WHERE skill_medicine_ed > 12
     * </code>
     *
     * @param     mixed $skillMedicineEd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillMedicineEd($skillMedicineEd = null, $comparison = null)
    {
        if (is_array($skillMedicineEd)) {
            $useMinMax = false;
            if (isset($skillMedicineEd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_MEDICINE_ED, $skillMedicineEd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillMedicineEd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_MEDICINE_ED, $skillMedicineEd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_MEDICINE_ED, $skillMedicineEd, $comparison);
    }

    /**
     * Filter the query on the skill_occult_ed column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillOccultEd(1234); // WHERE skill_occult_ed = 1234
     * $query->filterBySkillOccultEd(array(12, 34)); // WHERE skill_occult_ed IN (12, 34)
     * $query->filterBySkillOccultEd(array('min' => 12)); // WHERE skill_occult_ed > 12
     * </code>
     *
     * @param     mixed $skillOccultEd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillOccultEd($skillOccultEd = null, $comparison = null)
    {
        if (is_array($skillOccultEd)) {
            $useMinMax = false;
            if (isset($skillOccultEd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_OCCULT_ED, $skillOccultEd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillOccultEd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_OCCULT_ED, $skillOccultEd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_OCCULT_ED, $skillOccultEd, $comparison);
    }

    /**
     * Filter the query on the skill_pokemon_ed column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillPokemonEd(1234); // WHERE skill_pokemon_ed = 1234
     * $query->filterBySkillPokemonEd(array(12, 34)); // WHERE skill_pokemon_ed IN (12, 34)
     * $query->filterBySkillPokemonEd(array('min' => 12)); // WHERE skill_pokemon_ed > 12
     * </code>
     *
     * @param     mixed $skillPokemonEd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillPokemonEd($skillPokemonEd = null, $comparison = null)
    {
        if (is_array($skillPokemonEd)) {
            $useMinMax = false;
            if (isset($skillPokemonEd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_POKEMON_ED, $skillPokemonEd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillPokemonEd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_POKEMON_ED, $skillPokemonEd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_POKEMON_ED, $skillPokemonEd, $comparison);
    }

    /**
     * Filter the query on the skill_technology_ed column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillTechnologyEd(1234); // WHERE skill_technology_ed = 1234
     * $query->filterBySkillTechnologyEd(array(12, 34)); // WHERE skill_technology_ed IN (12, 34)
     * $query->filterBySkillTechnologyEd(array('min' => 12)); // WHERE skill_technology_ed > 12
     * </code>
     *
     * @param     mixed $skillTechnologyEd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillTechnologyEd($skillTechnologyEd = null, $comparison = null)
    {
        if (is_array($skillTechnologyEd)) {
            $useMinMax = false;
            if (isset($skillTechnologyEd['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED, $skillTechnologyEd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillTechnologyEd['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED, $skillTechnologyEd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED, $skillTechnologyEd, $comparison);
    }

    /**
     * Filter the query on the skill_focus column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillFocus(1234); // WHERE skill_focus = 1234
     * $query->filterBySkillFocus(array(12, 34)); // WHERE skill_focus IN (12, 34)
     * $query->filterBySkillFocus(array('min' => 12)); // WHERE skill_focus > 12
     * </code>
     *
     * @param     mixed $skillFocus The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillFocus($skillFocus = null, $comparison = null)
    {
        if (is_array($skillFocus)) {
            $useMinMax = false;
            if (isset($skillFocus['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_FOCUS, $skillFocus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillFocus['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_FOCUS, $skillFocus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_FOCUS, $skillFocus, $comparison);
    }

    /**
     * Filter the query on the skill_guile column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillGuile(1234); // WHERE skill_guile = 1234
     * $query->filterBySkillGuile(array(12, 34)); // WHERE skill_guile IN (12, 34)
     * $query->filterBySkillGuile(array('min' => 12)); // WHERE skill_guile > 12
     * </code>
     *
     * @param     mixed $skillGuile The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillGuile($skillGuile = null, $comparison = null)
    {
        if (is_array($skillGuile)) {
            $useMinMax = false;
            if (isset($skillGuile['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_GUILE, $skillGuile['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillGuile['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_GUILE, $skillGuile['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_GUILE, $skillGuile, $comparison);
    }

    /**
     * Filter the query on the skill_intimidate column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillIntimidate(1234); // WHERE skill_intimidate = 1234
     * $query->filterBySkillIntimidate(array(12, 34)); // WHERE skill_intimidate IN (12, 34)
     * $query->filterBySkillIntimidate(array('min' => 12)); // WHERE skill_intimidate > 12
     * </code>
     *
     * @param     mixed $skillIntimidate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillIntimidate($skillIntimidate = null, $comparison = null)
    {
        if (is_array($skillIntimidate)) {
            $useMinMax = false;
            if (isset($skillIntimidate['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTIMIDATE, $skillIntimidate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillIntimidate['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTIMIDATE, $skillIntimidate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTIMIDATE, $skillIntimidate, $comparison);
    }

    /**
     * Filter the query on the skill_intuition column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillIntuition(1234); // WHERE skill_intuition = 1234
     * $query->filterBySkillIntuition(array(12, 34)); // WHERE skill_intuition IN (12, 34)
     * $query->filterBySkillIntuition(array('min' => 12)); // WHERE skill_intuition > 12
     * </code>
     *
     * @param     mixed $skillIntuition The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillIntuition($skillIntuition = null, $comparison = null)
    {
        if (is_array($skillIntuition)) {
            $useMinMax = false;
            if (isset($skillIntuition['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTUITION, $skillIntuition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillIntuition['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTUITION, $skillIntuition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_INTUITION, $skillIntuition, $comparison);
    }

    /**
     * Filter the query on the skill_perception column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillPerception(1234); // WHERE skill_perception = 1234
     * $query->filterBySkillPerception(array(12, 34)); // WHERE skill_perception IN (12, 34)
     * $query->filterBySkillPerception(array('min' => 12)); // WHERE skill_perception > 12
     * </code>
     *
     * @param     mixed $skillPerception The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillPerception($skillPerception = null, $comparison = null)
    {
        if (is_array($skillPerception)) {
            $useMinMax = false;
            if (isset($skillPerception['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_PERCEPTION, $skillPerception['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillPerception['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_PERCEPTION, $skillPerception['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_PERCEPTION, $skillPerception, $comparison);
    }

    /**
     * Filter the query on the skill_stealth column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillStealth(1234); // WHERE skill_stealth = 1234
     * $query->filterBySkillStealth(array(12, 34)); // WHERE skill_stealth IN (12, 34)
     * $query->filterBySkillStealth(array('min' => 12)); // WHERE skill_stealth > 12
     * </code>
     *
     * @param     mixed $skillStealth The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillStealth($skillStealth = null, $comparison = null)
    {
        if (is_array($skillStealth)) {
            $useMinMax = false;
            if (isset($skillStealth['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_STEALTH, $skillStealth['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillStealth['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_STEALTH, $skillStealth['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_STEALTH, $skillStealth, $comparison);
    }

    /**
     * Filter the query on the skill_survival column
     *
     * Example usage:
     * <code>
     * $query->filterBySkillSurvival(1234); // WHERE skill_survival = 1234
     * $query->filterBySkillSurvival(array(12, 34)); // WHERE skill_survival IN (12, 34)
     * $query->filterBySkillSurvival(array('min' => 12)); // WHERE skill_survival > 12
     * </code>
     *
     * @param     mixed $skillSurvival The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySkillSurvival($skillSurvival = null, $comparison = null)
    {
        if (is_array($skillSurvival)) {
            $useMinMax = false;
            if (isset($skillSurvival['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_SURVIVAL, $skillSurvival['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($skillSurvival['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_SKILL_SURVIVAL, $skillSurvival['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SKILL_SURVIVAL, $skillSurvival, $comparison);
    }

    /**
     * Filter the query on the ap_spent column
     *
     * Example usage:
     * <code>
     * $query->filterByApSpent(1234); // WHERE ap_spent = 1234
     * $query->filterByApSpent(array(12, 34)); // WHERE ap_spent IN (12, 34)
     * $query->filterByApSpent(array('min' => 12)); // WHERE ap_spent > 12
     * </code>
     *
     * @param     mixed $apSpent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByApSpent($apSpent = null, $comparison = null)
    {
        if (is_array($apSpent)) {
            $useMinMax = false;
            if (isset($apSpent['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_SPENT, $apSpent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($apSpent['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_SPENT, $apSpent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_AP_SPENT, $apSpent, $comparison);
    }

    /**
     * Filter the query on the ap_bound column
     *
     * Example usage:
     * <code>
     * $query->filterByApBound(1234); // WHERE ap_bound = 1234
     * $query->filterByApBound(array(12, 34)); // WHERE ap_bound IN (12, 34)
     * $query->filterByApBound(array('min' => 12)); // WHERE ap_bound > 12
     * </code>
     *
     * @param     mixed $apBound The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByApBound($apBound = null, $comparison = null)
    {
        if (is_array($apBound)) {
            $useMinMax = false;
            if (isset($apBound['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_BOUND, $apBound['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($apBound['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_BOUND, $apBound['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_AP_BOUND, $apBound, $comparison);
    }

    /**
     * Filter the query on the ap_drained column
     *
     * Example usage:
     * <code>
     * $query->filterByApDrained(1234); // WHERE ap_drained = 1234
     * $query->filterByApDrained(array(12, 34)); // WHERE ap_drained IN (12, 34)
     * $query->filterByApDrained(array('min' => 12)); // WHERE ap_drained > 12
     * </code>
     *
     * @param     mixed $apDrained The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByApDrained($apDrained = null, $comparison = null)
    {
        if (is_array($apDrained)) {
            $useMinMax = false;
            if (isset($apDrained['min'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_DRAINED, $apDrained['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($apDrained['max'])) {
                $this->addUsingAlias(CharactersTableMap::COL_AP_DRAINED, $apDrained['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_AP_DRAINED, $apDrained, $comparison);
    }

    /**
     * Filter the query on the background_name column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundName('fooValue');   // WHERE background_name = 'fooValue'
     * $query->filterByBackgroundName('%fooValue%', Criteria::LIKE); // WHERE background_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundName($backgroundName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_NAME, $backgroundName, $comparison);
    }

    /**
     * Filter the query on the background_adept column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundAdept('fooValue');   // WHERE background_adept = 'fooValue'
     * $query->filterByBackgroundAdept('%fooValue%', Criteria::LIKE); // WHERE background_adept LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundAdept The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundAdept($backgroundAdept = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundAdept)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_ADEPT, $backgroundAdept, $comparison);
    }

    /**
     * Filter the query on the background_novice column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundNovice('fooValue');   // WHERE background_novice = 'fooValue'
     * $query->filterByBackgroundNovice('%fooValue%', Criteria::LIKE); // WHERE background_novice LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundNovice The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundNovice($backgroundNovice = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundNovice)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_NOVICE, $backgroundNovice, $comparison);
    }

    /**
     * Filter the query on the background_pthc1 column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundPthc1('fooValue');   // WHERE background_pthc1 = 'fooValue'
     * $query->filterByBackgroundPthc1('%fooValue%', Criteria::LIKE); // WHERE background_pthc1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundPthc1 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundPthc1($backgroundPthc1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundPthc1)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_PTHC1, $backgroundPthc1, $comparison);
    }

    /**
     * Filter the query on the background_pthc2 column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundPthc2('fooValue');   // WHERE background_pthc2 = 'fooValue'
     * $query->filterByBackgroundPthc2('%fooValue%', Criteria::LIKE); // WHERE background_pthc2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundPthc2 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundPthc2($backgroundPthc2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundPthc2)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_PTHC2, $backgroundPthc2, $comparison);
    }

    /**
     * Filter the query on the background_pthc3 column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundPthc3('fooValue');   // WHERE background_pthc3 = 'fooValue'
     * $query->filterByBackgroundPthc3('%fooValue%', Criteria::LIKE); // WHERE background_pthc3 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $backgroundPthc3 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBackgroundPthc3($backgroundPthc3 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($backgroundPthc3)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_BACKGROUND_PTHC3, $backgroundPthc3, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%', Criteria::LIKE); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_NOTES, $notes, $comparison);
    }

    /**
     * Filter the query on the nature column
     *
     * Example usage:
     * <code>
     * $query->filterByNature('fooValue');   // WHERE nature = 'fooValue'
     * $query->filterByNature('%fooValue%', Criteria::LIKE); // WHERE nature LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nature The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByNature($nature = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nature)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_NATURE, $nature, $comparison);
    }

    /**
     * Filter the query on the sheet_type column
     *
     * Example usage:
     * <code>
     * $query->filterBySheetType('fooValue');   // WHERE sheet_type = 'fooValue'
     * $query->filterBySheetType('%fooValue%', Criteria::LIKE); // WHERE sheet_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sheetType The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function filterBySheetType($sheetType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sheetType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharactersTableMap::COL_SHEET_TYPE, $sheetType, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Campaigns object
     *
     * @param \Propel\PtuToolkit\Campaigns|ObjectCollection $campaigns The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCampaigns($campaigns, $comparison = null)
    {
        if ($campaigns instanceof \Propel\PtuToolkit\Campaigns) {
            return $this
                ->addUsingAlias(CharactersTableMap::COL_CAMPAIGN_ID, $campaigns->getCampaignId(), $comparison);
        } elseif ($campaigns instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CharactersTableMap::COL_CAMPAIGN_ID, $campaigns->toKeyValue('PrimaryKey', 'CampaignId'), $comparison);
        } else {
            throw new PropelException('filterByCampaigns() only accepts arguments of type \Propel\PtuToolkit\Campaigns or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Campaigns relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function joinCampaigns($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Campaigns');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Campaigns');
        }

        return $this;
    }

    /**
     * Use the Campaigns relation Campaigns object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CampaignsQuery A secondary query class using the current class as primary query
     */
    public function useCampaignsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCampaigns($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Campaigns', '\Propel\PtuToolkit\CampaignsQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\BattleEntries object
     *
     * @param \Propel\PtuToolkit\BattleEntries|ObjectCollection $battleEntries the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByBattleEntries($battleEntries, $comparison = null)
    {
        if ($battleEntries instanceof \Propel\PtuToolkit\BattleEntries) {
            return $this
                ->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $battleEntries->getCharacterId(), $comparison);
        } elseif ($battleEntries instanceof ObjectCollection) {
            return $this
                ->useBattleEntriesQuery()
                ->filterByPrimaryKeys($battleEntries->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBattleEntries() only accepts arguments of type \Propel\PtuToolkit\BattleEntries or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BattleEntries relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function joinBattleEntries($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BattleEntries');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BattleEntries');
        }

        return $this;
    }

    /**
     * Use the BattleEntries relation BattleEntries object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\BattleEntriesQuery A secondary query class using the current class as primary query
     */
    public function useBattleEntriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBattleEntries($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BattleEntries', '\Propel\PtuToolkit\BattleEntriesQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\CharacterAbilities object
     *
     * @param \Propel\PtuToolkit\CharacterAbilities|ObjectCollection $characterAbilities the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCharacterAbilities($characterAbilities, $comparison = null)
    {
        if ($characterAbilities instanceof \Propel\PtuToolkit\CharacterAbilities) {
            return $this
                ->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterAbilities->getCharacterId(), $comparison);
        } elseif ($characterAbilities instanceof ObjectCollection) {
            return $this
                ->useCharacterAbilitiesQuery()
                ->filterByPrimaryKeys($characterAbilities->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCharacterAbilities() only accepts arguments of type \Propel\PtuToolkit\CharacterAbilities or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CharacterAbilities relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function joinCharacterAbilities($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CharacterAbilities');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CharacterAbilities');
        }

        return $this;
    }

    /**
     * Use the CharacterAbilities relation CharacterAbilities object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CharacterAbilitiesQuery A secondary query class using the current class as primary query
     */
    public function useCharacterAbilitiesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacterAbilities($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CharacterAbilities', '\Propel\PtuToolkit\CharacterAbilitiesQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\CharacterBuffs object
     *
     * @param \Propel\PtuToolkit\CharacterBuffs|ObjectCollection $characterBuffs the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCharacterBuffs($characterBuffs, $comparison = null)
    {
        if ($characterBuffs instanceof \Propel\PtuToolkit\CharacterBuffs) {
            return $this
                ->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterBuffs->getCharacterId(), $comparison);
        } elseif ($characterBuffs instanceof ObjectCollection) {
            return $this
                ->useCharacterBuffsQuery()
                ->filterByPrimaryKeys($characterBuffs->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCharacterBuffs() only accepts arguments of type \Propel\PtuToolkit\CharacterBuffs or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CharacterBuffs relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function joinCharacterBuffs($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CharacterBuffs');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CharacterBuffs');
        }

        return $this;
    }

    /**
     * Use the CharacterBuffs relation CharacterBuffs object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CharacterBuffsQuery A secondary query class using the current class as primary query
     */
    public function useCharacterBuffsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacterBuffs($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CharacterBuffs', '\Propel\PtuToolkit\CharacterBuffsQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\CharacterMoves object
     *
     * @param \Propel\PtuToolkit\CharacterMoves|ObjectCollection $characterMoves the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCharactersQuery The current query, for fluid interface
     */
    public function filterByCharacterMoves($characterMoves, $comparison = null)
    {
        if ($characterMoves instanceof \Propel\PtuToolkit\CharacterMoves) {
            return $this
                ->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characterMoves->getCharacterId(), $comparison);
        } elseif ($characterMoves instanceof ObjectCollection) {
            return $this
                ->useCharacterMovesQuery()
                ->filterByPrimaryKeys($characterMoves->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCharacterMoves() only accepts arguments of type \Propel\PtuToolkit\CharacterMoves or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CharacterMoves relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function joinCharacterMoves($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CharacterMoves');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CharacterMoves');
        }

        return $this;
    }

    /**
     * Use the CharacterMoves relation CharacterMoves object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CharacterMovesQuery A secondary query class using the current class as primary query
     */
    public function useCharacterMovesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacterMoves($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CharacterMoves', '\Propel\PtuToolkit\CharacterMovesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCharacters $characters Object to remove from the list of results
     *
     * @return $this|ChildCharactersQuery The current query, for fluid interface
     */
    public function prune($characters = null)
    {
        if ($characters) {
            $this->addUsingAlias(CharactersTableMap::COL_CHARACTER_ID, $characters->getCharacterId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the characters table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CharactersTableMap::clearInstancePool();
            CharactersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CharactersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CharactersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CharactersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CharactersQuery
