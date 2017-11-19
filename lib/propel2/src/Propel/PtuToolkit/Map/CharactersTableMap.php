<?php

namespace Propel\PtuToolkit\Map;

use Propel\PtuToolkit\Characters;
use Propel\PtuToolkit\CharactersQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'characters' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CharactersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.PtuToolkit.Map.CharactersTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'characters';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\PtuToolkit\\Characters';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.PtuToolkit.Characters';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 59;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 59;

    /**
     * the column name for the character_id field
     */
    const COL_CHARACTER_ID = 'characters.character_id';

    /**
     * the column name for the campaign_id field
     */
    const COL_CAMPAIGN_ID = 'characters.campaign_id';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'characters.type';

    /**
     * the column name for the pokedex_no field
     */
    const COL_POKEDEX_NO = 'characters.pokedex_no';

    /**
     * the column name for the pokedex_id field
     */
    const COL_POKEDEX_ID = 'characters.pokedex_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'characters.name';

    /**
     * the column name for the owner field
     */
    const COL_OWNER = 'characters.owner';

    /**
     * the column name for the age field
     */
    const COL_AGE = 'characters.age';

    /**
     * the column name for the weight field
     */
    const COL_WEIGHT = 'characters.weight';

    /**
     * the column name for the height field
     */
    const COL_HEIGHT = 'characters.height';

    /**
     * the column name for the sex field
     */
    const COL_SEX = 'characters.sex';

    /**
     * the column name for the base_type1 field
     */
    const COL_BASE_TYPE1 = 'characters.base_type1';

    /**
     * the column name for the base_type2 field
     */
    const COL_BASE_TYPE2 = 'characters.base_type2';

    /**
     * the column name for the level field
     */
    const COL_LEVEL = 'characters.level';

    /**
     * the column name for the exp field
     */
    const COL_EXP = 'characters.exp';

    /**
     * the column name for the base_hp field
     */
    const COL_BASE_HP = 'characters.base_hp';

    /**
     * the column name for the base_atk field
     */
    const COL_BASE_ATK = 'characters.base_atk';

    /**
     * the column name for the base_def field
     */
    const COL_BASE_DEF = 'characters.base_def';

    /**
     * the column name for the base_satk field
     */
    const COL_BASE_SATK = 'characters.base_satk';

    /**
     * the column name for the base_sdef field
     */
    const COL_BASE_SDEF = 'characters.base_sdef';

    /**
     * the column name for the base_spd field
     */
    const COL_BASE_SPD = 'characters.base_spd';

    /**
     * the column name for the add_hp field
     */
    const COL_ADD_HP = 'characters.add_hp';

    /**
     * the column name for the add_atk field
     */
    const COL_ADD_ATK = 'characters.add_atk';

    /**
     * the column name for the add_def field
     */
    const COL_ADD_DEF = 'characters.add_def';

    /**
     * the column name for the add_satk field
     */
    const COL_ADD_SATK = 'characters.add_satk';

    /**
     * the column name for the add_sdef field
     */
    const COL_ADD_SDEF = 'characters.add_sdef';

    /**
     * the column name for the add_spd field
     */
    const COL_ADD_SPD = 'characters.add_spd';

    /**
     * the column name for the health field
     */
    const COL_HEALTH = 'characters.health';

    /**
     * the column name for the injuries field
     */
    const COL_INJURIES = 'characters.injuries';

    /**
     * the column name for the money field
     */
    const COL_MONEY = 'characters.money';

    /**
     * the column name for the skill_acrobatics field
     */
    const COL_SKILL_ACROBATICS = 'characters.skill_acrobatics';

    /**
     * the column name for the skill_athletics field
     */
    const COL_SKILL_ATHLETICS = 'characters.skill_athletics';

    /**
     * the column name for the skill_charm field
     */
    const COL_SKILL_CHARM = 'characters.skill_charm';

    /**
     * the column name for the skill_combat field
     */
    const COL_SKILL_COMBAT = 'characters.skill_combat';

    /**
     * the column name for the skill_command field
     */
    const COL_SKILL_COMMAND = 'characters.skill_command';

    /**
     * the column name for the skill_general_ed field
     */
    const COL_SKILL_GENERAL_ED = 'characters.skill_general_ed';

    /**
     * the column name for the skill_medicine_ed field
     */
    const COL_SKILL_MEDICINE_ED = 'characters.skill_medicine_ed';

    /**
     * the column name for the skill_occult_ed field
     */
    const COL_SKILL_OCCULT_ED = 'characters.skill_occult_ed';

    /**
     * the column name for the skill_pokemon_ed field
     */
    const COL_SKILL_POKEMON_ED = 'characters.skill_pokemon_ed';

    /**
     * the column name for the skill_technology_ed field
     */
    const COL_SKILL_TECHNOLOGY_ED = 'characters.skill_technology_ed';

    /**
     * the column name for the skill_focus field
     */
    const COL_SKILL_FOCUS = 'characters.skill_focus';

    /**
     * the column name for the skill_guile field
     */
    const COL_SKILL_GUILE = 'characters.skill_guile';

    /**
     * the column name for the skill_intimidate field
     */
    const COL_SKILL_INTIMIDATE = 'characters.skill_intimidate';

    /**
     * the column name for the skill_intuition field
     */
    const COL_SKILL_INTUITION = 'characters.skill_intuition';

    /**
     * the column name for the skill_perception field
     */
    const COL_SKILL_PERCEPTION = 'characters.skill_perception';

    /**
     * the column name for the skill_stealth field
     */
    const COL_SKILL_STEALTH = 'characters.skill_stealth';

    /**
     * the column name for the skill_survival field
     */
    const COL_SKILL_SURVIVAL = 'characters.skill_survival';

    /**
     * the column name for the ap_spent field
     */
    const COL_AP_SPENT = 'characters.ap_spent';

    /**
     * the column name for the ap_bound field
     */
    const COL_AP_BOUND = 'characters.ap_bound';

    /**
     * the column name for the ap_drained field
     */
    const COL_AP_DRAINED = 'characters.ap_drained';

    /**
     * the column name for the background_name field
     */
    const COL_BACKGROUND_NAME = 'characters.background_name';

    /**
     * the column name for the background_adept field
     */
    const COL_BACKGROUND_ADEPT = 'characters.background_adept';

    /**
     * the column name for the background_novice field
     */
    const COL_BACKGROUND_NOVICE = 'characters.background_novice';

    /**
     * the column name for the background_pthc1 field
     */
    const COL_BACKGROUND_PTHC1 = 'characters.background_pthc1';

    /**
     * the column name for the background_pthc2 field
     */
    const COL_BACKGROUND_PTHC2 = 'characters.background_pthc2';

    /**
     * the column name for the background_pthc3 field
     */
    const COL_BACKGROUND_PTHC3 = 'characters.background_pthc3';

    /**
     * the column name for the notes field
     */
    const COL_NOTES = 'characters.notes';

    /**
     * the column name for the nature field
     */
    const COL_NATURE = 'characters.nature';

    /**
     * the column name for the sheet_type field
     */
    const COL_SHEET_TYPE = 'characters.sheet_type';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('CharacterId', 'CampaignId', 'Type', 'PokedexNo', 'PokedexId', 'Name', 'Owner', 'Age', 'Weight', 'Height', 'Sex', 'Type1', 'Type2', 'Level', 'Exp', 'BaseHp', 'BaseAtk', 'BaseDef', 'BaseSatk', 'BaseSdef', 'BaseSpd', 'AddHp', 'AddAtk', 'AddDef', 'AddSatk', 'AddSdef', 'AddSpd', 'Health', 'Injuries', 'Money', 'SkillAcrobatics', 'SkillAthletics', 'SkillCharm', 'SkillCombat', 'SkillCommand', 'SkillGeneralEd', 'SkillMedicineEd', 'SkillOccultEd', 'SkillPokemonEd', 'SkillTechnologyEd', 'SkillFocus', 'SkillGuile', 'SkillIntimidate', 'SkillIntuition', 'SkillPerception', 'SkillStealth', 'SkillSurvival', 'ApSpent', 'ApBound', 'ApDrained', 'BackgroundName', 'BackgroundAdept', 'BackgroundNovice', 'BackgroundPthc1', 'BackgroundPthc2', 'BackgroundPthc3', 'Notes', 'Nature', 'SheetType', ),
        self::TYPE_CAMELNAME     => array('characterId', 'campaignId', 'type', 'pokedexNo', 'pokedexId', 'name', 'owner', 'age', 'weight', 'height', 'sex', 'type1', 'type2', 'level', 'exp', 'baseHp', 'baseAtk', 'baseDef', 'baseSatk', 'baseSdef', 'baseSpd', 'addHp', 'addAtk', 'addDef', 'addSatk', 'addSdef', 'addSpd', 'health', 'injuries', 'money', 'skillAcrobatics', 'skillAthletics', 'skillCharm', 'skillCombat', 'skillCommand', 'skillGeneralEd', 'skillMedicineEd', 'skillOccultEd', 'skillPokemonEd', 'skillTechnologyEd', 'skillFocus', 'skillGuile', 'skillIntimidate', 'skillIntuition', 'skillPerception', 'skillStealth', 'skillSurvival', 'apSpent', 'apBound', 'apDrained', 'backgroundName', 'backgroundAdept', 'backgroundNovice', 'backgroundPthc1', 'backgroundPthc2', 'backgroundPthc3', 'notes', 'nature', 'sheetType', ),
        self::TYPE_COLNAME       => array(CharactersTableMap::COL_CHARACTER_ID, CharactersTableMap::COL_CAMPAIGN_ID, CharactersTableMap::COL_TYPE, CharactersTableMap::COL_POKEDEX_NO, CharactersTableMap::COL_POKEDEX_ID, CharactersTableMap::COL_NAME, CharactersTableMap::COL_OWNER, CharactersTableMap::COL_AGE, CharactersTableMap::COL_WEIGHT, CharactersTableMap::COL_HEIGHT, CharactersTableMap::COL_SEX, CharactersTableMap::COL_BASE_TYPE1, CharactersTableMap::COL_BASE_TYPE2, CharactersTableMap::COL_LEVEL, CharactersTableMap::COL_EXP, CharactersTableMap::COL_BASE_HP, CharactersTableMap::COL_BASE_ATK, CharactersTableMap::COL_BASE_DEF, CharactersTableMap::COL_BASE_SATK, CharactersTableMap::COL_BASE_SDEF, CharactersTableMap::COL_BASE_SPD, CharactersTableMap::COL_ADD_HP, CharactersTableMap::COL_ADD_ATK, CharactersTableMap::COL_ADD_DEF, CharactersTableMap::COL_ADD_SATK, CharactersTableMap::COL_ADD_SDEF, CharactersTableMap::COL_ADD_SPD, CharactersTableMap::COL_HEALTH, CharactersTableMap::COL_INJURIES, CharactersTableMap::COL_MONEY, CharactersTableMap::COL_SKILL_ACROBATICS, CharactersTableMap::COL_SKILL_ATHLETICS, CharactersTableMap::COL_SKILL_CHARM, CharactersTableMap::COL_SKILL_COMBAT, CharactersTableMap::COL_SKILL_COMMAND, CharactersTableMap::COL_SKILL_GENERAL_ED, CharactersTableMap::COL_SKILL_MEDICINE_ED, CharactersTableMap::COL_SKILL_OCCULT_ED, CharactersTableMap::COL_SKILL_POKEMON_ED, CharactersTableMap::COL_SKILL_TECHNOLOGY_ED, CharactersTableMap::COL_SKILL_FOCUS, CharactersTableMap::COL_SKILL_GUILE, CharactersTableMap::COL_SKILL_INTIMIDATE, CharactersTableMap::COL_SKILL_INTUITION, CharactersTableMap::COL_SKILL_PERCEPTION, CharactersTableMap::COL_SKILL_STEALTH, CharactersTableMap::COL_SKILL_SURVIVAL, CharactersTableMap::COL_AP_SPENT, CharactersTableMap::COL_AP_BOUND, CharactersTableMap::COL_AP_DRAINED, CharactersTableMap::COL_BACKGROUND_NAME, CharactersTableMap::COL_BACKGROUND_ADEPT, CharactersTableMap::COL_BACKGROUND_NOVICE, CharactersTableMap::COL_BACKGROUND_PTHC1, CharactersTableMap::COL_BACKGROUND_PTHC2, CharactersTableMap::COL_BACKGROUND_PTHC3, CharactersTableMap::COL_NOTES, CharactersTableMap::COL_NATURE, CharactersTableMap::COL_SHEET_TYPE, ),
        self::TYPE_FIELDNAME     => array('character_id', 'campaign_id', 'type', 'pokedex_no', 'pokedex_id', 'name', 'owner', 'age', 'weight', 'height', 'sex', 'base_type1', 'base_type2', 'level', 'exp', 'base_hp', 'base_atk', 'base_def', 'base_satk', 'base_sdef', 'base_spd', 'add_hp', 'add_atk', 'add_def', 'add_satk', 'add_sdef', 'add_spd', 'health', 'injuries', 'money', 'skill_acrobatics', 'skill_athletics', 'skill_charm', 'skill_combat', 'skill_command', 'skill_general_ed', 'skill_medicine_ed', 'skill_occult_ed', 'skill_pokemon_ed', 'skill_technology_ed', 'skill_focus', 'skill_guile', 'skill_intimidate', 'skill_intuition', 'skill_perception', 'skill_stealth', 'skill_survival', 'ap_spent', 'ap_bound', 'ap_drained', 'background_name', 'background_adept', 'background_novice', 'background_pthc1', 'background_pthc2', 'background_pthc3', 'notes', 'nature', 'sheet_type', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('CharacterId' => 0, 'CampaignId' => 1, 'Type' => 2, 'PokedexNo' => 3, 'PokedexId' => 4, 'Name' => 5, 'Owner' => 6, 'Age' => 7, 'Weight' => 8, 'Height' => 9, 'Sex' => 10, 'Type1' => 11, 'Type2' => 12, 'Level' => 13, 'Exp' => 14, 'BaseHp' => 15, 'BaseAtk' => 16, 'BaseDef' => 17, 'BaseSatk' => 18, 'BaseSdef' => 19, 'BaseSpd' => 20, 'AddHp' => 21, 'AddAtk' => 22, 'AddDef' => 23, 'AddSatk' => 24, 'AddSdef' => 25, 'AddSpd' => 26, 'Health' => 27, 'Injuries' => 28, 'Money' => 29, 'SkillAcrobatics' => 30, 'SkillAthletics' => 31, 'SkillCharm' => 32, 'SkillCombat' => 33, 'SkillCommand' => 34, 'SkillGeneralEd' => 35, 'SkillMedicineEd' => 36, 'SkillOccultEd' => 37, 'SkillPokemonEd' => 38, 'SkillTechnologyEd' => 39, 'SkillFocus' => 40, 'SkillGuile' => 41, 'SkillIntimidate' => 42, 'SkillIntuition' => 43, 'SkillPerception' => 44, 'SkillStealth' => 45, 'SkillSurvival' => 46, 'ApSpent' => 47, 'ApBound' => 48, 'ApDrained' => 49, 'BackgroundName' => 50, 'BackgroundAdept' => 51, 'BackgroundNovice' => 52, 'BackgroundPthc1' => 53, 'BackgroundPthc2' => 54, 'BackgroundPthc3' => 55, 'Notes' => 56, 'Nature' => 57, 'SheetType' => 58, ),
        self::TYPE_CAMELNAME     => array('characterId' => 0, 'campaignId' => 1, 'type' => 2, 'pokedexNo' => 3, 'pokedexId' => 4, 'name' => 5, 'owner' => 6, 'age' => 7, 'weight' => 8, 'height' => 9, 'sex' => 10, 'type1' => 11, 'type2' => 12, 'level' => 13, 'exp' => 14, 'baseHp' => 15, 'baseAtk' => 16, 'baseDef' => 17, 'baseSatk' => 18, 'baseSdef' => 19, 'baseSpd' => 20, 'addHp' => 21, 'addAtk' => 22, 'addDef' => 23, 'addSatk' => 24, 'addSdef' => 25, 'addSpd' => 26, 'health' => 27, 'injuries' => 28, 'money' => 29, 'skillAcrobatics' => 30, 'skillAthletics' => 31, 'skillCharm' => 32, 'skillCombat' => 33, 'skillCommand' => 34, 'skillGeneralEd' => 35, 'skillMedicineEd' => 36, 'skillOccultEd' => 37, 'skillPokemonEd' => 38, 'skillTechnologyEd' => 39, 'skillFocus' => 40, 'skillGuile' => 41, 'skillIntimidate' => 42, 'skillIntuition' => 43, 'skillPerception' => 44, 'skillStealth' => 45, 'skillSurvival' => 46, 'apSpent' => 47, 'apBound' => 48, 'apDrained' => 49, 'backgroundName' => 50, 'backgroundAdept' => 51, 'backgroundNovice' => 52, 'backgroundPthc1' => 53, 'backgroundPthc2' => 54, 'backgroundPthc3' => 55, 'notes' => 56, 'nature' => 57, 'sheetType' => 58, ),
        self::TYPE_COLNAME       => array(CharactersTableMap::COL_CHARACTER_ID => 0, CharactersTableMap::COL_CAMPAIGN_ID => 1, CharactersTableMap::COL_TYPE => 2, CharactersTableMap::COL_POKEDEX_NO => 3, CharactersTableMap::COL_POKEDEX_ID => 4, CharactersTableMap::COL_NAME => 5, CharactersTableMap::COL_OWNER => 6, CharactersTableMap::COL_AGE => 7, CharactersTableMap::COL_WEIGHT => 8, CharactersTableMap::COL_HEIGHT => 9, CharactersTableMap::COL_SEX => 10, CharactersTableMap::COL_BASE_TYPE1 => 11, CharactersTableMap::COL_BASE_TYPE2 => 12, CharactersTableMap::COL_LEVEL => 13, CharactersTableMap::COL_EXP => 14, CharactersTableMap::COL_BASE_HP => 15, CharactersTableMap::COL_BASE_ATK => 16, CharactersTableMap::COL_BASE_DEF => 17, CharactersTableMap::COL_BASE_SATK => 18, CharactersTableMap::COL_BASE_SDEF => 19, CharactersTableMap::COL_BASE_SPD => 20, CharactersTableMap::COL_ADD_HP => 21, CharactersTableMap::COL_ADD_ATK => 22, CharactersTableMap::COL_ADD_DEF => 23, CharactersTableMap::COL_ADD_SATK => 24, CharactersTableMap::COL_ADD_SDEF => 25, CharactersTableMap::COL_ADD_SPD => 26, CharactersTableMap::COL_HEALTH => 27, CharactersTableMap::COL_INJURIES => 28, CharactersTableMap::COL_MONEY => 29, CharactersTableMap::COL_SKILL_ACROBATICS => 30, CharactersTableMap::COL_SKILL_ATHLETICS => 31, CharactersTableMap::COL_SKILL_CHARM => 32, CharactersTableMap::COL_SKILL_COMBAT => 33, CharactersTableMap::COL_SKILL_COMMAND => 34, CharactersTableMap::COL_SKILL_GENERAL_ED => 35, CharactersTableMap::COL_SKILL_MEDICINE_ED => 36, CharactersTableMap::COL_SKILL_OCCULT_ED => 37, CharactersTableMap::COL_SKILL_POKEMON_ED => 38, CharactersTableMap::COL_SKILL_TECHNOLOGY_ED => 39, CharactersTableMap::COL_SKILL_FOCUS => 40, CharactersTableMap::COL_SKILL_GUILE => 41, CharactersTableMap::COL_SKILL_INTIMIDATE => 42, CharactersTableMap::COL_SKILL_INTUITION => 43, CharactersTableMap::COL_SKILL_PERCEPTION => 44, CharactersTableMap::COL_SKILL_STEALTH => 45, CharactersTableMap::COL_SKILL_SURVIVAL => 46, CharactersTableMap::COL_AP_SPENT => 47, CharactersTableMap::COL_AP_BOUND => 48, CharactersTableMap::COL_AP_DRAINED => 49, CharactersTableMap::COL_BACKGROUND_NAME => 50, CharactersTableMap::COL_BACKGROUND_ADEPT => 51, CharactersTableMap::COL_BACKGROUND_NOVICE => 52, CharactersTableMap::COL_BACKGROUND_PTHC1 => 53, CharactersTableMap::COL_BACKGROUND_PTHC2 => 54, CharactersTableMap::COL_BACKGROUND_PTHC3 => 55, CharactersTableMap::COL_NOTES => 56, CharactersTableMap::COL_NATURE => 57, CharactersTableMap::COL_SHEET_TYPE => 58, ),
        self::TYPE_FIELDNAME     => array('character_id' => 0, 'campaign_id' => 1, 'type' => 2, 'pokedex_no' => 3, 'pokedex_id' => 4, 'name' => 5, 'owner' => 6, 'age' => 7, 'weight' => 8, 'height' => 9, 'sex' => 10, 'base_type1' => 11, 'base_type2' => 12, 'level' => 13, 'exp' => 14, 'base_hp' => 15, 'base_atk' => 16, 'base_def' => 17, 'base_satk' => 18, 'base_sdef' => 19, 'base_spd' => 20, 'add_hp' => 21, 'add_atk' => 22, 'add_def' => 23, 'add_satk' => 24, 'add_sdef' => 25, 'add_spd' => 26, 'health' => 27, 'injuries' => 28, 'money' => 29, 'skill_acrobatics' => 30, 'skill_athletics' => 31, 'skill_charm' => 32, 'skill_combat' => 33, 'skill_command' => 34, 'skill_general_ed' => 35, 'skill_medicine_ed' => 36, 'skill_occult_ed' => 37, 'skill_pokemon_ed' => 38, 'skill_technology_ed' => 39, 'skill_focus' => 40, 'skill_guile' => 41, 'skill_intimidate' => 42, 'skill_intuition' => 43, 'skill_perception' => 44, 'skill_stealth' => 45, 'skill_survival' => 46, 'ap_spent' => 47, 'ap_bound' => 48, 'ap_drained' => 49, 'background_name' => 50, 'background_adept' => 51, 'background_novice' => 52, 'background_pthc1' => 53, 'background_pthc2' => 54, 'background_pthc3' => 55, 'notes' => 56, 'nature' => 57, 'sheet_type' => 58, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('characters');
        $this->setPhpName('Characters');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\PtuToolkit\\Characters');
        $this->setPackage('Propel.PtuToolkit');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('character_id', 'CharacterId', 'INTEGER', true, null, null);
        $this->addForeignKey('campaign_id', 'CampaignId', 'INTEGER', 'campaigns', 'campaign_id', true, null, null);
        $this->addColumn('type', 'Type', 'CHAR', true, null, null);
        $this->addColumn('pokedex_no', 'PokedexNo', 'VARCHAR', false, 8, null);
        $this->addColumn('pokedex_id', 'PokedexId', 'INTEGER', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 80, null);
        $this->addColumn('owner', 'Owner', 'INTEGER', false, null, null);
        $this->addColumn('age', 'Age', 'VARCHAR', false, 12, null);
        $this->addColumn('weight', 'Weight', 'VARCHAR', false, 12, null);
        $this->addColumn('height', 'Height', 'VARCHAR', false, 12, null);
        $this->addColumn('sex', 'Sex', 'VARCHAR', false, 12, null);
        $this->addColumn('base_type1', 'Type1', 'VARCHAR', false, 16, null);
        $this->addColumn('base_type2', 'Type2', 'VARCHAR', false, 16, null);
        $this->addColumn('level', 'Level', 'INTEGER', false, null, null);
        $this->addColumn('exp', 'Exp', 'INTEGER', false, null, null);
        $this->addColumn('base_hp', 'BaseHp', 'INTEGER', true, null, null);
        $this->addColumn('base_atk', 'BaseAtk', 'INTEGER', true, null, null);
        $this->addColumn('base_def', 'BaseDef', 'INTEGER', true, null, null);
        $this->addColumn('base_satk', 'BaseSatk', 'INTEGER', true, null, null);
        $this->addColumn('base_sdef', 'BaseSdef', 'INTEGER', true, null, null);
        $this->addColumn('base_spd', 'BaseSpd', 'INTEGER', true, null, null);
        $this->addColumn('add_hp', 'AddHp', 'INTEGER', false, null, 0);
        $this->addColumn('add_atk', 'AddAtk', 'INTEGER', false, null, 0);
        $this->addColumn('add_def', 'AddDef', 'INTEGER', false, null, 0);
        $this->addColumn('add_satk', 'AddSatk', 'INTEGER', false, null, 0);
        $this->addColumn('add_sdef', 'AddSdef', 'INTEGER', false, null, 0);
        $this->addColumn('add_spd', 'AddSpd', 'INTEGER', false, null, 0);
        $this->addColumn('health', 'Health', 'INTEGER', false, null, null);
        $this->addColumn('injuries', 'Injuries', 'INTEGER', false, null, 0);
        $this->addColumn('money', 'Money', 'INTEGER', false, null, 0);
        $this->addColumn('skill_acrobatics', 'SkillAcrobatics', 'INTEGER', false, null, 2);
        $this->addColumn('skill_athletics', 'SkillAthletics', 'INTEGER', false, null, 2);
        $this->addColumn('skill_charm', 'SkillCharm', 'INTEGER', false, null, 2);
        $this->addColumn('skill_combat', 'SkillCombat', 'INTEGER', false, null, 2);
        $this->addColumn('skill_command', 'SkillCommand', 'INTEGER', false, null, 2);
        $this->addColumn('skill_general_ed', 'SkillGeneralEd', 'INTEGER', false, null, 2);
        $this->addColumn('skill_medicine_ed', 'SkillMedicineEd', 'INTEGER', false, null, 2);
        $this->addColumn('skill_occult_ed', 'SkillOccultEd', 'INTEGER', false, null, 2);
        $this->addColumn('skill_pokemon_ed', 'SkillPokemonEd', 'INTEGER', false, null, 2);
        $this->addColumn('skill_technology_ed', 'SkillTechnologyEd', 'INTEGER', false, null, 2);
        $this->addColumn('skill_focus', 'SkillFocus', 'INTEGER', false, null, 2);
        $this->addColumn('skill_guile', 'SkillGuile', 'INTEGER', false, null, 2);
        $this->addColumn('skill_intimidate', 'SkillIntimidate', 'INTEGER', false, null, 2);
        $this->addColumn('skill_intuition', 'SkillIntuition', 'INTEGER', false, null, 2);
        $this->addColumn('skill_perception', 'SkillPerception', 'INTEGER', false, null, 2);
        $this->addColumn('skill_stealth', 'SkillStealth', 'INTEGER', false, null, 2);
        $this->addColumn('skill_survival', 'SkillSurvival', 'INTEGER', false, null, 2);
        $this->addColumn('ap_spent', 'ApSpent', 'INTEGER', false, null, 0);
        $this->addColumn('ap_bound', 'ApBound', 'INTEGER', false, null, 0);
        $this->addColumn('ap_drained', 'ApDrained', 'INTEGER', false, null, 0);
        $this->addColumn('background_name', 'BackgroundName', 'VARCHAR', false, 80, null);
        $this->addColumn('background_adept', 'BackgroundAdept', 'VARCHAR', false, 80, null);
        $this->addColumn('background_novice', 'BackgroundNovice', 'VARCHAR', false, 80, null);
        $this->addColumn('background_pthc1', 'BackgroundPthc1', 'VARCHAR', false, 80, null);
        $this->addColumn('background_pthc2', 'BackgroundPthc2', 'VARCHAR', false, 80, null);
        $this->addColumn('background_pthc3', 'BackgroundPthc3', 'VARCHAR', false, 80, null);
        $this->addColumn('notes', 'Notes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('nature', 'Nature', 'VARCHAR', false, 80, null);
        $this->addColumn('sheet_type', 'SheetType', 'CHAR', false, null, 'SIMPLE');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Campaigns', '\\Propel\\PtuToolkit\\Campaigns', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':campaign_id',
    1 => ':campaign_id',
  ),
), null, null, null, false);
        $this->addRelation('BattleEntries', '\\Propel\\PtuToolkit\\BattleEntries', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':character_id',
  ),
), null, null, 'BattleEntriess', false);
        $this->addRelation('CharacterAbilities', '\\Propel\\PtuToolkit\\CharacterAbilities', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':character_id',
  ),
), null, null, 'CharacterAbilitiess', false);
        $this->addRelation('CharacterBuffs', '\\Propel\\PtuToolkit\\CharacterBuffs', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':character_id',
  ),
), null, null, 'CharacterBuffss', false);
        $this->addRelation('CharacterMoves', '\\Propel\\PtuToolkit\\CharacterMoves', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':character_id',
  ),
), null, null, 'CharacterMovess', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CharactersTableMap::CLASS_DEFAULT : CharactersTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Characters object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CharactersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CharactersTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CharactersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CharactersTableMap::OM_CLASS;
            /** @var Characters $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CharactersTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CharactersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CharactersTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Characters $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CharactersTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CharactersTableMap::COL_CHARACTER_ID);
            $criteria->addSelectColumn(CharactersTableMap::COL_CAMPAIGN_ID);
            $criteria->addSelectColumn(CharactersTableMap::COL_TYPE);
            $criteria->addSelectColumn(CharactersTableMap::COL_POKEDEX_NO);
            $criteria->addSelectColumn(CharactersTableMap::COL_POKEDEX_ID);
            $criteria->addSelectColumn(CharactersTableMap::COL_NAME);
            $criteria->addSelectColumn(CharactersTableMap::COL_OWNER);
            $criteria->addSelectColumn(CharactersTableMap::COL_AGE);
            $criteria->addSelectColumn(CharactersTableMap::COL_WEIGHT);
            $criteria->addSelectColumn(CharactersTableMap::COL_HEIGHT);
            $criteria->addSelectColumn(CharactersTableMap::COL_SEX);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_TYPE1);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_TYPE2);
            $criteria->addSelectColumn(CharactersTableMap::COL_LEVEL);
            $criteria->addSelectColumn(CharactersTableMap::COL_EXP);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_HP);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_ATK);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_DEF);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_SATK);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_SDEF);
            $criteria->addSelectColumn(CharactersTableMap::COL_BASE_SPD);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_HP);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_ATK);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_DEF);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_SATK);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_SDEF);
            $criteria->addSelectColumn(CharactersTableMap::COL_ADD_SPD);
            $criteria->addSelectColumn(CharactersTableMap::COL_HEALTH);
            $criteria->addSelectColumn(CharactersTableMap::COL_INJURIES);
            $criteria->addSelectColumn(CharactersTableMap::COL_MONEY);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_ACROBATICS);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_ATHLETICS);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_CHARM);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_COMBAT);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_COMMAND);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_GENERAL_ED);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_MEDICINE_ED);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_OCCULT_ED);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_POKEMON_ED);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_FOCUS);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_GUILE);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_INTIMIDATE);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_INTUITION);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_PERCEPTION);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_STEALTH);
            $criteria->addSelectColumn(CharactersTableMap::COL_SKILL_SURVIVAL);
            $criteria->addSelectColumn(CharactersTableMap::COL_AP_SPENT);
            $criteria->addSelectColumn(CharactersTableMap::COL_AP_BOUND);
            $criteria->addSelectColumn(CharactersTableMap::COL_AP_DRAINED);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_NAME);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_ADEPT);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_NOVICE);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_PTHC1);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_PTHC2);
            $criteria->addSelectColumn(CharactersTableMap::COL_BACKGROUND_PTHC3);
            $criteria->addSelectColumn(CharactersTableMap::COL_NOTES);
            $criteria->addSelectColumn(CharactersTableMap::COL_NATURE);
            $criteria->addSelectColumn(CharactersTableMap::COL_SHEET_TYPE);
        } else {
            $criteria->addSelectColumn($alias . '.character_id');
            $criteria->addSelectColumn($alias . '.campaign_id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.pokedex_no');
            $criteria->addSelectColumn($alias . '.pokedex_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.owner');
            $criteria->addSelectColumn($alias . '.age');
            $criteria->addSelectColumn($alias . '.weight');
            $criteria->addSelectColumn($alias . '.height');
            $criteria->addSelectColumn($alias . '.sex');
            $criteria->addSelectColumn($alias . '.base_type1');
            $criteria->addSelectColumn($alias . '.base_type2');
            $criteria->addSelectColumn($alias . '.level');
            $criteria->addSelectColumn($alias . '.exp');
            $criteria->addSelectColumn($alias . '.base_hp');
            $criteria->addSelectColumn($alias . '.base_atk');
            $criteria->addSelectColumn($alias . '.base_def');
            $criteria->addSelectColumn($alias . '.base_satk');
            $criteria->addSelectColumn($alias . '.base_sdef');
            $criteria->addSelectColumn($alias . '.base_spd');
            $criteria->addSelectColumn($alias . '.add_hp');
            $criteria->addSelectColumn($alias . '.add_atk');
            $criteria->addSelectColumn($alias . '.add_def');
            $criteria->addSelectColumn($alias . '.add_satk');
            $criteria->addSelectColumn($alias . '.add_sdef');
            $criteria->addSelectColumn($alias . '.add_spd');
            $criteria->addSelectColumn($alias . '.health');
            $criteria->addSelectColumn($alias . '.injuries');
            $criteria->addSelectColumn($alias . '.money');
            $criteria->addSelectColumn($alias . '.skill_acrobatics');
            $criteria->addSelectColumn($alias . '.skill_athletics');
            $criteria->addSelectColumn($alias . '.skill_charm');
            $criteria->addSelectColumn($alias . '.skill_combat');
            $criteria->addSelectColumn($alias . '.skill_command');
            $criteria->addSelectColumn($alias . '.skill_general_ed');
            $criteria->addSelectColumn($alias . '.skill_medicine_ed');
            $criteria->addSelectColumn($alias . '.skill_occult_ed');
            $criteria->addSelectColumn($alias . '.skill_pokemon_ed');
            $criteria->addSelectColumn($alias . '.skill_technology_ed');
            $criteria->addSelectColumn($alias . '.skill_focus');
            $criteria->addSelectColumn($alias . '.skill_guile');
            $criteria->addSelectColumn($alias . '.skill_intimidate');
            $criteria->addSelectColumn($alias . '.skill_intuition');
            $criteria->addSelectColumn($alias . '.skill_perception');
            $criteria->addSelectColumn($alias . '.skill_stealth');
            $criteria->addSelectColumn($alias . '.skill_survival');
            $criteria->addSelectColumn($alias . '.ap_spent');
            $criteria->addSelectColumn($alias . '.ap_bound');
            $criteria->addSelectColumn($alias . '.ap_drained');
            $criteria->addSelectColumn($alias . '.background_name');
            $criteria->addSelectColumn($alias . '.background_adept');
            $criteria->addSelectColumn($alias . '.background_novice');
            $criteria->addSelectColumn($alias . '.background_pthc1');
            $criteria->addSelectColumn($alias . '.background_pthc2');
            $criteria->addSelectColumn($alias . '.background_pthc3');
            $criteria->addSelectColumn($alias . '.notes');
            $criteria->addSelectColumn($alias . '.nature');
            $criteria->addSelectColumn($alias . '.sheet_type');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CharactersTableMap::DATABASE_NAME)->getTable(CharactersTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CharactersTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CharactersTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CharactersTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Characters or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Characters object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\PtuToolkit\Characters) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CharactersTableMap::DATABASE_NAME);
            $criteria->add(CharactersTableMap::COL_CHARACTER_ID, (array) $values, Criteria::IN);
        }

        $query = CharactersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CharactersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CharactersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the characters table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CharactersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Characters or Criteria object.
     *
     * @param mixed               $criteria Criteria or Characters object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Characters object
        }

        if ($criteria->containsKey(CharactersTableMap::COL_CHARACTER_ID) && $criteria->keyContainsValue(CharactersTableMap::COL_CHARACTER_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CharactersTableMap::COL_CHARACTER_ID.')');
        }


        // Set the correct dbName
        $query = CharactersQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CharactersTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CharactersTableMap::buildTableMap();
