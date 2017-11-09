<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\BattleEntries as ChildBattleEntries;
use Propel\PtuToolkit\BattleEntriesQuery as ChildBattleEntriesQuery;
use Propel\PtuToolkit\Campaigns as ChildCampaigns;
use Propel\PtuToolkit\CampaignsQuery as ChildCampaignsQuery;
use Propel\PtuToolkit\CharacterAbilities as ChildCharacterAbilities;
use Propel\PtuToolkit\CharacterAbilitiesQuery as ChildCharacterAbilitiesQuery;
use Propel\PtuToolkit\CharacterBuffs as ChildCharacterBuffs;
use Propel\PtuToolkit\CharacterBuffsQuery as ChildCharacterBuffsQuery;
use Propel\PtuToolkit\CharacterMoves as ChildCharacterMoves;
use Propel\PtuToolkit\CharacterMovesQuery as ChildCharacterMovesQuery;
use Propel\PtuToolkit\Characters as ChildCharacters;
use Propel\PtuToolkit\CharactersQuery as ChildCharactersQuery;
use Propel\PtuToolkit\Map\BattleEntriesTableMap;
use Propel\PtuToolkit\Map\CharacterAbilitiesTableMap;
use Propel\PtuToolkit\Map\CharacterBuffsTableMap;
use Propel\PtuToolkit\Map\CharacterMovesTableMap;
use Propel\PtuToolkit\Map\CharactersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'characters' table.
 *
 *
 *
 * @package    propel.generator.Propel.PtuToolkit.Base
 */
abstract class Characters implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\PtuToolkit\\Map\\CharactersTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the character_id field.
     *
     * @var        int
     */
    protected $character_id;

    /**
     * The value for the campaign_id field.
     *
     * @var        int
     */
    protected $campaign_id;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the pokedex_id field.
     *
     * @var        string
     */
    protected $pokedex_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the owner field.
     *
     * @var        int
     */
    protected $owner;

    /**
     * The value for the age field.
     *
     * @var        string
     */
    protected $age;

    /**
     * The value for the weight field.
     *
     * @var        string
     */
    protected $weight;

    /**
     * The value for the height field.
     *
     * @var        string
     */
    protected $height;

    /**
     * The value for the sex field.
     *
     * @var        string
     */
    protected $sex;

    /**
     * The value for the base_type1 field.
     *
     * @var        string
     */
    protected $base_type1;

    /**
     * The value for the base_type2 field.
     *
     * @var        string
     */
    protected $base_type2;

    /**
     * The value for the level field.
     *
     * @var        int
     */
    protected $level;

    /**
     * The value for the exp field.
     *
     * @var        int
     */
    protected $exp;

    /**
     * The value for the base_hp field.
     *
     * @var        int
     */
    protected $base_hp;

    /**
     * The value for the base_atk field.
     *
     * @var        int
     */
    protected $base_atk;

    /**
     * The value for the base_def field.
     *
     * @var        int
     */
    protected $base_def;

    /**
     * The value for the base_satk field.
     *
     * @var        int
     */
    protected $base_satk;

    /**
     * The value for the base_sdef field.
     *
     * @var        int
     */
    protected $base_sdef;

    /**
     * The value for the base_spd field.
     *
     * @var        int
     */
    protected $base_spd;

    /**
     * The value for the add_hp field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_hp;

    /**
     * The value for the add_atk field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_atk;

    /**
     * The value for the add_def field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_def;

    /**
     * The value for the add_satk field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_satk;

    /**
     * The value for the add_sdef field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_sdef;

    /**
     * The value for the add_spd field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $add_spd;

    /**
     * The value for the health field.
     *
     * @var        int
     */
    protected $health;

    /**
     * The value for the injuries field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $injuries;

    /**
     * The value for the money field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $money;

    /**
     * The value for the skill_acrobatics field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_acrobatics;

    /**
     * The value for the skill_athletics field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_athletics;

    /**
     * The value for the skill_charm field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_charm;

    /**
     * The value for the skill_combat field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_combat;

    /**
     * The value for the skill_command field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_command;

    /**
     * The value for the skill_general_ed field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_general_ed;

    /**
     * The value for the skill_medicine_ed field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_medicine_ed;

    /**
     * The value for the skill_occult_ed field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_occult_ed;

    /**
     * The value for the skill_pokemon_ed field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_pokemon_ed;

    /**
     * The value for the skill_technology_ed field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_technology_ed;

    /**
     * The value for the skill_focus field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_focus;

    /**
     * The value for the skill_guile field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_guile;

    /**
     * The value for the skill_intimidate field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_intimidate;

    /**
     * The value for the skill_intuition field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_intuition;

    /**
     * The value for the skill_perception field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_perception;

    /**
     * The value for the skill_stealth field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_stealth;

    /**
     * The value for the skill_survival field.
     *
     * Note: this column has a database default value of: 2
     * @var        int
     */
    protected $skill_survival;

    /**
     * The value for the ap_spent field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $ap_spent;

    /**
     * The value for the ap_bound field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $ap_bound;

    /**
     * The value for the ap_drained field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $ap_drained;

    /**
     * The value for the background_name field.
     *
     * @var        string
     */
    protected $background_name;

    /**
     * The value for the background_adept field.
     *
     * @var        string
     */
    protected $background_adept;

    /**
     * The value for the background_novice field.
     *
     * @var        string
     */
    protected $background_novice;

    /**
     * The value for the background_pthc1 field.
     *
     * @var        string
     */
    protected $background_pthc1;

    /**
     * The value for the background_pthc2 field.
     *
     * @var        string
     */
    protected $background_pthc2;

    /**
     * The value for the background_pthc3 field.
     *
     * @var        string
     */
    protected $background_pthc3;

    /**
     * The value for the notes field.
     *
     * @var        string
     */
    protected $notes;

    /**
     * The value for the nature field.
     *
     * @var        string
     */
    protected $nature;

    /**
     * @var        ChildCampaigns
     */
    protected $aCampaigns;

    /**
     * @var        ObjectCollection|ChildBattleEntries[] Collection to store aggregation of ChildBattleEntries objects.
     */
    protected $collBattleEntriess;
    protected $collBattleEntriessPartial;

    /**
     * @var        ObjectCollection|ChildCharacterAbilities[] Collection to store aggregation of ChildCharacterAbilities objects.
     */
    protected $collCharacterAbilitiess;
    protected $collCharacterAbilitiessPartial;

    /**
     * @var        ObjectCollection|ChildCharacterBuffs[] Collection to store aggregation of ChildCharacterBuffs objects.
     */
    protected $collCharacterBuffss;
    protected $collCharacterBuffssPartial;

    /**
     * @var        ObjectCollection|ChildCharacterMoves[] Collection to store aggregation of ChildCharacterMoves objects.
     */
    protected $collCharacterMovess;
    protected $collCharacterMovessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBattleEntries[]
     */
    protected $battleEntriessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCharacterAbilities[]
     */
    protected $characterAbilitiessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCharacterBuffs[]
     */
    protected $characterBuffssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCharacterMoves[]
     */
    protected $characterMovessScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->add_hp = 0;
        $this->add_atk = 0;
        $this->add_def = 0;
        $this->add_satk = 0;
        $this->add_sdef = 0;
        $this->add_spd = 0;
        $this->injuries = 0;
        $this->money = 0;
        $this->skill_acrobatics = 2;
        $this->skill_athletics = 2;
        $this->skill_charm = 2;
        $this->skill_combat = 2;
        $this->skill_command = 2;
        $this->skill_general_ed = 2;
        $this->skill_medicine_ed = 2;
        $this->skill_occult_ed = 2;
        $this->skill_pokemon_ed = 2;
        $this->skill_technology_ed = 2;
        $this->skill_focus = 2;
        $this->skill_guile = 2;
        $this->skill_intimidate = 2;
        $this->skill_intuition = 2;
        $this->skill_perception = 2;
        $this->skill_stealth = 2;
        $this->skill_survival = 2;
        $this->ap_spent = 0;
        $this->ap_bound = 0;
        $this->ap_drained = 0;
    }

    /**
     * Initializes internal state of Propel\PtuToolkit\Base\Characters object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Characters</code> instance.  If
     * <code>obj</code> is an instance of <code>Characters</code>, delegates to
     * <code>equals(Characters)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Characters The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [character_id] column value.
     *
     * @return int
     */
    public function getCharacterId()
    {
        return $this->character_id;
    }

    /**
     * Get the [campaign_id] column value.
     *
     * @return int
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [pokedex_id] column value.
     *
     * @return string
     */
    public function getPokedexId()
    {
        return $this->pokedex_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [owner] column value.
     *
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Get the [age] column value.
     *
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Get the [weight] column value.
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get the [height] column value.
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the [sex] column value.
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Get the [base_type1] column value.
     *
     * @return string
     */
    public function getType1()
    {
        return $this->base_type1;
    }

    /**
     * Get the [base_type2] column value.
     *
     * @return string
     */
    public function getType2()
    {
        return $this->base_type2;
    }

    /**
     * Get the [level] column value.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Get the [exp] column value.
     *
     * @return int
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * Get the [base_hp] column value.
     *
     * @return int
     */
    public function getBaseHp()
    {
        return $this->base_hp;
    }

    /**
     * Get the [base_atk] column value.
     *
     * @return int
     */
    public function getBaseAtk()
    {
        return $this->base_atk;
    }

    /**
     * Get the [base_def] column value.
     *
     * @return int
     */
    public function getBaseDef()
    {
        return $this->base_def;
    }

    /**
     * Get the [base_satk] column value.
     *
     * @return int
     */
    public function getBaseSatk()
    {
        return $this->base_satk;
    }

    /**
     * Get the [base_sdef] column value.
     *
     * @return int
     */
    public function getBaseSdef()
    {
        return $this->base_sdef;
    }

    /**
     * Get the [base_spd] column value.
     *
     * @return int
     */
    public function getBaseSpd()
    {
        return $this->base_spd;
    }

    /**
     * Get the [add_hp] column value.
     *
     * @return int
     */
    public function getAddHp()
    {
        return $this->add_hp;
    }

    /**
     * Get the [add_atk] column value.
     *
     * @return int
     */
    public function getAddAtk()
    {
        return $this->add_atk;
    }

    /**
     * Get the [add_def] column value.
     *
     * @return int
     */
    public function getAddDef()
    {
        return $this->add_def;
    }

    /**
     * Get the [add_satk] column value.
     *
     * @return int
     */
    public function getAddSatk()
    {
        return $this->add_satk;
    }

    /**
     * Get the [add_sdef] column value.
     *
     * @return int
     */
    public function getAddSdef()
    {
        return $this->add_sdef;
    }

    /**
     * Get the [add_spd] column value.
     *
     * @return int
     */
    public function getAddSpd()
    {
        return $this->add_spd;
    }

    /**
     * Get the [health] column value.
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Get the [injuries] column value.
     *
     * @return int
     */
    public function getInjuries()
    {
        return $this->injuries;
    }

    /**
     * Get the [money] column value.
     *
     * @return int
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Get the [skill_acrobatics] column value.
     *
     * @return int
     */
    public function getSkillAcrobatics()
    {
        return $this->skill_acrobatics;
    }

    /**
     * Get the [skill_athletics] column value.
     *
     * @return int
     */
    public function getSkillAthletics()
    {
        return $this->skill_athletics;
    }

    /**
     * Get the [skill_charm] column value.
     *
     * @return int
     */
    public function getSkillCharm()
    {
        return $this->skill_charm;
    }

    /**
     * Get the [skill_combat] column value.
     *
     * @return int
     */
    public function getSkillCombat()
    {
        return $this->skill_combat;
    }

    /**
     * Get the [skill_command] column value.
     *
     * @return int
     */
    public function getSkillCommand()
    {
        return $this->skill_command;
    }

    /**
     * Get the [skill_general_ed] column value.
     *
     * @return int
     */
    public function getSkillGeneralEd()
    {
        return $this->skill_general_ed;
    }

    /**
     * Get the [skill_medicine_ed] column value.
     *
     * @return int
     */
    public function getSkillMedicineEd()
    {
        return $this->skill_medicine_ed;
    }

    /**
     * Get the [skill_occult_ed] column value.
     *
     * @return int
     */
    public function getSkillOccultEd()
    {
        return $this->skill_occult_ed;
    }

    /**
     * Get the [skill_pokemon_ed] column value.
     *
     * @return int
     */
    public function getSkillPokemonEd()
    {
        return $this->skill_pokemon_ed;
    }

    /**
     * Get the [skill_technology_ed] column value.
     *
     * @return int
     */
    public function getSkillTechnologyEd()
    {
        return $this->skill_technology_ed;
    }

    /**
     * Get the [skill_focus] column value.
     *
     * @return int
     */
    public function getSkillFocus()
    {
        return $this->skill_focus;
    }

    /**
     * Get the [skill_guile] column value.
     *
     * @return int
     */
    public function getSkillGuile()
    {
        return $this->skill_guile;
    }

    /**
     * Get the [skill_intimidate] column value.
     *
     * @return int
     */
    public function getSkillIntimidate()
    {
        return $this->skill_intimidate;
    }

    /**
     * Get the [skill_intuition] column value.
     *
     * @return int
     */
    public function getSkillIntuition()
    {
        return $this->skill_intuition;
    }

    /**
     * Get the [skill_perception] column value.
     *
     * @return int
     */
    public function getSkillPerception()
    {
        return $this->skill_perception;
    }

    /**
     * Get the [skill_stealth] column value.
     *
     * @return int
     */
    public function getSkillStealth()
    {
        return $this->skill_stealth;
    }

    /**
     * Get the [skill_survival] column value.
     *
     * @return int
     */
    public function getSkillSurvival()
    {
        return $this->skill_survival;
    }

    /**
     * Get the [ap_spent] column value.
     *
     * @return int
     */
    public function getApSpent()
    {
        return $this->ap_spent;
    }

    /**
     * Get the [ap_bound] column value.
     *
     * @return int
     */
    public function getApBound()
    {
        return $this->ap_bound;
    }

    /**
     * Get the [ap_drained] column value.
     *
     * @return int
     */
    public function getApDrained()
    {
        return $this->ap_drained;
    }

    /**
     * Get the [background_name] column value.
     *
     * @return string
     */
    public function getBackgroundName()
    {
        return $this->background_name;
    }

    /**
     * Get the [background_adept] column value.
     *
     * @return string
     */
    public function getBackgroundAdept()
    {
        return $this->background_adept;
    }

    /**
     * Get the [background_novice] column value.
     *
     * @return string
     */
    public function getBackgroundNovice()
    {
        return $this->background_novice;
    }

    /**
     * Get the [background_pthc1] column value.
     *
     * @return string
     */
    public function getBackgroundPthc1()
    {
        return $this->background_pthc1;
    }

    /**
     * Get the [background_pthc2] column value.
     *
     * @return string
     */
    public function getBackgroundPthc2()
    {
        return $this->background_pthc2;
    }

    /**
     * Get the [background_pthc3] column value.
     *
     * @return string
     */
    public function getBackgroundPthc3()
    {
        return $this->background_pthc3;
    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get the [nature] column value.
     *
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set the value of [character_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setCharacterId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->character_id !== $v) {
            $this->character_id = $v;
            $this->modifiedColumns[CharactersTableMap::COL_CHARACTER_ID] = true;
        }

        return $this;
    } // setCharacterId()

    /**
     * Set the value of [campaign_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setCampaignId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->campaign_id !== $v) {
            $this->campaign_id = $v;
            $this->modifiedColumns[CharactersTableMap::COL_CAMPAIGN_ID] = true;
        }

        if ($this->aCampaigns !== null && $this->aCampaigns->getCampaignId() !== $v) {
            $this->aCampaigns = null;
        }

        return $this;
    } // setCampaignId()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[CharactersTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [pokedex_id] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setPokedexId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pokedex_id !== $v) {
            $this->pokedex_id = $v;
            $this->modifiedColumns[CharactersTableMap::COL_POKEDEX_ID] = true;
        }

        return $this;
    } // setPokedexId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CharactersTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [owner] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setOwner($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->owner !== $v) {
            $this->owner = $v;
            $this->modifiedColumns[CharactersTableMap::COL_OWNER] = true;
        }

        return $this;
    } // setOwner()

    /**
     * Set the value of [age] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAge($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->age !== $v) {
            $this->age = $v;
            $this->modifiedColumns[CharactersTableMap::COL_AGE] = true;
        }

        return $this;
    } // setAge()

    /**
     * Set the value of [weight] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setWeight($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->weight !== $v) {
            $this->weight = $v;
            $this->modifiedColumns[CharactersTableMap::COL_WEIGHT] = true;
        }

        return $this;
    } // setWeight()

    /**
     * Set the value of [height] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setHeight($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->height !== $v) {
            $this->height = $v;
            $this->modifiedColumns[CharactersTableMap::COL_HEIGHT] = true;
        }

        return $this;
    } // setHeight()

    /**
     * Set the value of [sex] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSex($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sex !== $v) {
            $this->sex = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SEX] = true;
        }

        return $this;
    } // setSex()

    /**
     * Set the value of [base_type1] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setType1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->base_type1 !== $v) {
            $this->base_type1 = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_TYPE1] = true;
        }

        return $this;
    } // setType1()

    /**
     * Set the value of [base_type2] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setType2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->base_type2 !== $v) {
            $this->base_type2 = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_TYPE2] = true;
        }

        return $this;
    } // setType2()

    /**
     * Set the value of [level] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setLevel($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->level !== $v) {
            $this->level = $v;
            $this->modifiedColumns[CharactersTableMap::COL_LEVEL] = true;
        }

        return $this;
    } // setLevel()

    /**
     * Set the value of [exp] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setExp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->exp !== $v) {
            $this->exp = $v;
            $this->modifiedColumns[CharactersTableMap::COL_EXP] = true;
        }

        return $this;
    } // setExp()

    /**
     * Set the value of [base_hp] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseHp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_hp !== $v) {
            $this->base_hp = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_HP] = true;
        }

        return $this;
    } // setBaseHp()

    /**
     * Set the value of [base_atk] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseAtk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_atk !== $v) {
            $this->base_atk = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_ATK] = true;
        }

        return $this;
    } // setBaseAtk()

    /**
     * Set the value of [base_def] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseDef($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_def !== $v) {
            $this->base_def = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_DEF] = true;
        }

        return $this;
    } // setBaseDef()

    /**
     * Set the value of [base_satk] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseSatk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_satk !== $v) {
            $this->base_satk = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_SATK] = true;
        }

        return $this;
    } // setBaseSatk()

    /**
     * Set the value of [base_sdef] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseSdef($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_sdef !== $v) {
            $this->base_sdef = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_SDEF] = true;
        }

        return $this;
    } // setBaseSdef()

    /**
     * Set the value of [base_spd] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBaseSpd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->base_spd !== $v) {
            $this->base_spd = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BASE_SPD] = true;
        }

        return $this;
    } // setBaseSpd()

    /**
     * Set the value of [add_hp] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddHp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_hp !== $v) {
            $this->add_hp = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_HP] = true;
        }

        return $this;
    } // setAddHp()

    /**
     * Set the value of [add_atk] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddAtk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_atk !== $v) {
            $this->add_atk = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_ATK] = true;
        }

        return $this;
    } // setAddAtk()

    /**
     * Set the value of [add_def] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddDef($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_def !== $v) {
            $this->add_def = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_DEF] = true;
        }

        return $this;
    } // setAddDef()

    /**
     * Set the value of [add_satk] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddSatk($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_satk !== $v) {
            $this->add_satk = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_SATK] = true;
        }

        return $this;
    } // setAddSatk()

    /**
     * Set the value of [add_sdef] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddSdef($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_sdef !== $v) {
            $this->add_sdef = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_SDEF] = true;
        }

        return $this;
    } // setAddSdef()

    /**
     * Set the value of [add_spd] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setAddSpd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->add_spd !== $v) {
            $this->add_spd = $v;
            $this->modifiedColumns[CharactersTableMap::COL_ADD_SPD] = true;
        }

        return $this;
    } // setAddSpd()

    /**
     * Set the value of [health] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setHealth($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->health !== $v) {
            $this->health = $v;
            $this->modifiedColumns[CharactersTableMap::COL_HEALTH] = true;
        }

        return $this;
    } // setHealth()

    /**
     * Set the value of [injuries] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setInjuries($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->injuries !== $v) {
            $this->injuries = $v;
            $this->modifiedColumns[CharactersTableMap::COL_INJURIES] = true;
        }

        return $this;
    } // setInjuries()

    /**
     * Set the value of [money] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setMoney($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->money !== $v) {
            $this->money = $v;
            $this->modifiedColumns[CharactersTableMap::COL_MONEY] = true;
        }

        return $this;
    } // setMoney()

    /**
     * Set the value of [skill_acrobatics] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillAcrobatics($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_acrobatics !== $v) {
            $this->skill_acrobatics = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_ACROBATICS] = true;
        }

        return $this;
    } // setSkillAcrobatics()

    /**
     * Set the value of [skill_athletics] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillAthletics($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_athletics !== $v) {
            $this->skill_athletics = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_ATHLETICS] = true;
        }

        return $this;
    } // setSkillAthletics()

    /**
     * Set the value of [skill_charm] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillCharm($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_charm !== $v) {
            $this->skill_charm = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_CHARM] = true;
        }

        return $this;
    } // setSkillCharm()

    /**
     * Set the value of [skill_combat] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillCombat($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_combat !== $v) {
            $this->skill_combat = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_COMBAT] = true;
        }

        return $this;
    } // setSkillCombat()

    /**
     * Set the value of [skill_command] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillCommand($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_command !== $v) {
            $this->skill_command = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_COMMAND] = true;
        }

        return $this;
    } // setSkillCommand()

    /**
     * Set the value of [skill_general_ed] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillGeneralEd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_general_ed !== $v) {
            $this->skill_general_ed = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_GENERAL_ED] = true;
        }

        return $this;
    } // setSkillGeneralEd()

    /**
     * Set the value of [skill_medicine_ed] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillMedicineEd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_medicine_ed !== $v) {
            $this->skill_medicine_ed = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_MEDICINE_ED] = true;
        }

        return $this;
    } // setSkillMedicineEd()

    /**
     * Set the value of [skill_occult_ed] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillOccultEd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_occult_ed !== $v) {
            $this->skill_occult_ed = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_OCCULT_ED] = true;
        }

        return $this;
    } // setSkillOccultEd()

    /**
     * Set the value of [skill_pokemon_ed] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillPokemonEd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_pokemon_ed !== $v) {
            $this->skill_pokemon_ed = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_POKEMON_ED] = true;
        }

        return $this;
    } // setSkillPokemonEd()

    /**
     * Set the value of [skill_technology_ed] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillTechnologyEd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_technology_ed !== $v) {
            $this->skill_technology_ed = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_TECHNOLOGY_ED] = true;
        }

        return $this;
    } // setSkillTechnologyEd()

    /**
     * Set the value of [skill_focus] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillFocus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_focus !== $v) {
            $this->skill_focus = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_FOCUS] = true;
        }

        return $this;
    } // setSkillFocus()

    /**
     * Set the value of [skill_guile] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillGuile($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_guile !== $v) {
            $this->skill_guile = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_GUILE] = true;
        }

        return $this;
    } // setSkillGuile()

    /**
     * Set the value of [skill_intimidate] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillIntimidate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_intimidate !== $v) {
            $this->skill_intimidate = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_INTIMIDATE] = true;
        }

        return $this;
    } // setSkillIntimidate()

    /**
     * Set the value of [skill_intuition] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillIntuition($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_intuition !== $v) {
            $this->skill_intuition = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_INTUITION] = true;
        }

        return $this;
    } // setSkillIntuition()

    /**
     * Set the value of [skill_perception] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillPerception($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_perception !== $v) {
            $this->skill_perception = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_PERCEPTION] = true;
        }

        return $this;
    } // setSkillPerception()

    /**
     * Set the value of [skill_stealth] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillStealth($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_stealth !== $v) {
            $this->skill_stealth = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_STEALTH] = true;
        }

        return $this;
    } // setSkillStealth()

    /**
     * Set the value of [skill_survival] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setSkillSurvival($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->skill_survival !== $v) {
            $this->skill_survival = $v;
            $this->modifiedColumns[CharactersTableMap::COL_SKILL_SURVIVAL] = true;
        }

        return $this;
    } // setSkillSurvival()

    /**
     * Set the value of [ap_spent] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setApSpent($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ap_spent !== $v) {
            $this->ap_spent = $v;
            $this->modifiedColumns[CharactersTableMap::COL_AP_SPENT] = true;
        }

        return $this;
    } // setApSpent()

    /**
     * Set the value of [ap_bound] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setApBound($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ap_bound !== $v) {
            $this->ap_bound = $v;
            $this->modifiedColumns[CharactersTableMap::COL_AP_BOUND] = true;
        }

        return $this;
    } // setApBound()

    /**
     * Set the value of [ap_drained] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setApDrained($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ap_drained !== $v) {
            $this->ap_drained = $v;
            $this->modifiedColumns[CharactersTableMap::COL_AP_DRAINED] = true;
        }

        return $this;
    } // setApDrained()

    /**
     * Set the value of [background_name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_name !== $v) {
            $this->background_name = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_NAME] = true;
        }

        return $this;
    } // setBackgroundName()

    /**
     * Set the value of [background_adept] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundAdept($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_adept !== $v) {
            $this->background_adept = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_ADEPT] = true;
        }

        return $this;
    } // setBackgroundAdept()

    /**
     * Set the value of [background_novice] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundNovice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_novice !== $v) {
            $this->background_novice = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_NOVICE] = true;
        }

        return $this;
    } // setBackgroundNovice()

    /**
     * Set the value of [background_pthc1] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundPthc1($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_pthc1 !== $v) {
            $this->background_pthc1 = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_PTHC1] = true;
        }

        return $this;
    } // setBackgroundPthc1()

    /**
     * Set the value of [background_pthc2] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundPthc2($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_pthc2 !== $v) {
            $this->background_pthc2 = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_PTHC2] = true;
        }

        return $this;
    } // setBackgroundPthc2()

    /**
     * Set the value of [background_pthc3] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setBackgroundPthc3($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->background_pthc3 !== $v) {
            $this->background_pthc3 = $v;
            $this->modifiedColumns[CharactersTableMap::COL_BACKGROUND_PTHC3] = true;
        }

        return $this;
    } // setBackgroundPthc3()

    /**
     * Set the value of [notes] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[CharactersTableMap::COL_NOTES] = true;
        }

        return $this;
    } // setNotes()

    /**
     * Set the value of [nature] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function setNature($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nature !== $v) {
            $this->nature = $v;
            $this->modifiedColumns[CharactersTableMap::COL_NATURE] = true;
        }

        return $this;
    } // setNature()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->add_hp !== 0) {
                return false;
            }

            if ($this->add_atk !== 0) {
                return false;
            }

            if ($this->add_def !== 0) {
                return false;
            }

            if ($this->add_satk !== 0) {
                return false;
            }

            if ($this->add_sdef !== 0) {
                return false;
            }

            if ($this->add_spd !== 0) {
                return false;
            }

            if ($this->injuries !== 0) {
                return false;
            }

            if ($this->money !== 0) {
                return false;
            }

            if ($this->skill_acrobatics !== 2) {
                return false;
            }

            if ($this->skill_athletics !== 2) {
                return false;
            }

            if ($this->skill_charm !== 2) {
                return false;
            }

            if ($this->skill_combat !== 2) {
                return false;
            }

            if ($this->skill_command !== 2) {
                return false;
            }

            if ($this->skill_general_ed !== 2) {
                return false;
            }

            if ($this->skill_medicine_ed !== 2) {
                return false;
            }

            if ($this->skill_occult_ed !== 2) {
                return false;
            }

            if ($this->skill_pokemon_ed !== 2) {
                return false;
            }

            if ($this->skill_technology_ed !== 2) {
                return false;
            }

            if ($this->skill_focus !== 2) {
                return false;
            }

            if ($this->skill_guile !== 2) {
                return false;
            }

            if ($this->skill_intimidate !== 2) {
                return false;
            }

            if ($this->skill_intuition !== 2) {
                return false;
            }

            if ($this->skill_perception !== 2) {
                return false;
            }

            if ($this->skill_stealth !== 2) {
                return false;
            }

            if ($this->skill_survival !== 2) {
                return false;
            }

            if ($this->ap_spent !== 0) {
                return false;
            }

            if ($this->ap_bound !== 0) {
                return false;
            }

            if ($this->ap_drained !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CharactersTableMap::translateFieldName('CharacterId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->character_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CharactersTableMap::translateFieldName('CampaignId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->campaign_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CharactersTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CharactersTableMap::translateFieldName('PokedexId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pokedex_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CharactersTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CharactersTableMap::translateFieldName('Owner', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CharactersTableMap::translateFieldName('Age', TableMap::TYPE_PHPNAME, $indexType)];
            $this->age = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CharactersTableMap::translateFieldName('Weight', TableMap::TYPE_PHPNAME, $indexType)];
            $this->weight = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CharactersTableMap::translateFieldName('Height', TableMap::TYPE_PHPNAME, $indexType)];
            $this->height = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : CharactersTableMap::translateFieldName('Sex', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sex = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : CharactersTableMap::translateFieldName('Type1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_type1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : CharactersTableMap::translateFieldName('Type2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_type2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : CharactersTableMap::translateFieldName('Level', TableMap::TYPE_PHPNAME, $indexType)];
            $this->level = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : CharactersTableMap::translateFieldName('Exp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : CharactersTableMap::translateFieldName('BaseHp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_hp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : CharactersTableMap::translateFieldName('BaseAtk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_atk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : CharactersTableMap::translateFieldName('BaseDef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_def = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : CharactersTableMap::translateFieldName('BaseSatk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_satk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : CharactersTableMap::translateFieldName('BaseSdef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_sdef = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : CharactersTableMap::translateFieldName('BaseSpd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_spd = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : CharactersTableMap::translateFieldName('AddHp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_hp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : CharactersTableMap::translateFieldName('AddAtk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_atk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : CharactersTableMap::translateFieldName('AddDef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_def = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : CharactersTableMap::translateFieldName('AddSatk', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_satk = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : CharactersTableMap::translateFieldName('AddSdef', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_sdef = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : CharactersTableMap::translateFieldName('AddSpd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->add_spd = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : CharactersTableMap::translateFieldName('Health', TableMap::TYPE_PHPNAME, $indexType)];
            $this->health = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : CharactersTableMap::translateFieldName('Injuries', TableMap::TYPE_PHPNAME, $indexType)];
            $this->injuries = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : CharactersTableMap::translateFieldName('Money', TableMap::TYPE_PHPNAME, $indexType)];
            $this->money = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : CharactersTableMap::translateFieldName('SkillAcrobatics', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_acrobatics = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : CharactersTableMap::translateFieldName('SkillAthletics', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_athletics = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : CharactersTableMap::translateFieldName('SkillCharm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_charm = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : CharactersTableMap::translateFieldName('SkillCombat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_combat = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : CharactersTableMap::translateFieldName('SkillCommand', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_command = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : CharactersTableMap::translateFieldName('SkillGeneralEd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_general_ed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : CharactersTableMap::translateFieldName('SkillMedicineEd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_medicine_ed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : CharactersTableMap::translateFieldName('SkillOccultEd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_occult_ed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : CharactersTableMap::translateFieldName('SkillPokemonEd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_pokemon_ed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : CharactersTableMap::translateFieldName('SkillTechnologyEd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_technology_ed = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : CharactersTableMap::translateFieldName('SkillFocus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_focus = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : CharactersTableMap::translateFieldName('SkillGuile', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_guile = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : CharactersTableMap::translateFieldName('SkillIntimidate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_intimidate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : CharactersTableMap::translateFieldName('SkillIntuition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_intuition = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : CharactersTableMap::translateFieldName('SkillPerception', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_perception = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : CharactersTableMap::translateFieldName('SkillStealth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_stealth = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : CharactersTableMap::translateFieldName('SkillSurvival', TableMap::TYPE_PHPNAME, $indexType)];
            $this->skill_survival = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : CharactersTableMap::translateFieldName('ApSpent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_spent = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : CharactersTableMap::translateFieldName('ApBound', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_bound = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : CharactersTableMap::translateFieldName('ApDrained', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_drained = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : CharactersTableMap::translateFieldName('BackgroundName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : CharactersTableMap::translateFieldName('BackgroundAdept', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_adept = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 51 + $startcol : CharactersTableMap::translateFieldName('BackgroundNovice', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_novice = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 52 + $startcol : CharactersTableMap::translateFieldName('BackgroundPthc1', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_pthc1 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 53 + $startcol : CharactersTableMap::translateFieldName('BackgroundPthc2', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_pthc2 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 54 + $startcol : CharactersTableMap::translateFieldName('BackgroundPthc3', TableMap::TYPE_PHPNAME, $indexType)];
            $this->background_pthc3 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 55 + $startcol : CharactersTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 56 + $startcol : CharactersTableMap::translateFieldName('Nature', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nature = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 57; // 57 = CharactersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\PtuToolkit\\Characters'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aCampaigns !== null && $this->campaign_id !== $this->aCampaigns->getCampaignId()) {
            $this->aCampaigns = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CharactersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCharactersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCampaigns = null;
            $this->collBattleEntriess = null;

            $this->collCharacterAbilitiess = null;

            $this->collCharacterBuffss = null;

            $this->collCharacterMovess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Characters::setDeleted()
     * @see Characters::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCharactersQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharactersTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CharactersTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCampaigns !== null) {
                if ($this->aCampaigns->isModified() || $this->aCampaigns->isNew()) {
                    $affectedRows += $this->aCampaigns->save($con);
                }
                $this->setCampaigns($this->aCampaigns);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->battleEntriessScheduledForDeletion !== null) {
                if (!$this->battleEntriessScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\BattleEntriesQuery::create()
                        ->filterByPrimaryKeys($this->battleEntriessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->battleEntriessScheduledForDeletion = null;
                }
            }

            if ($this->collBattleEntriess !== null) {
                foreach ($this->collBattleEntriess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->characterAbilitiessScheduledForDeletion !== null) {
                if (!$this->characterAbilitiessScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\CharacterAbilitiesQuery::create()
                        ->filterByPrimaryKeys($this->characterAbilitiessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->characterAbilitiessScheduledForDeletion = null;
                }
            }

            if ($this->collCharacterAbilitiess !== null) {
                foreach ($this->collCharacterAbilitiess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->characterBuffssScheduledForDeletion !== null) {
                if (!$this->characterBuffssScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\CharacterBuffsQuery::create()
                        ->filterByPrimaryKeys($this->characterBuffssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->characterBuffssScheduledForDeletion = null;
                }
            }

            if ($this->collCharacterBuffss !== null) {
                foreach ($this->collCharacterBuffss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->characterMovessScheduledForDeletion !== null) {
                if (!$this->characterMovessScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\CharacterMovesQuery::create()
                        ->filterByPrimaryKeys($this->characterMovessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->characterMovessScheduledForDeletion = null;
                }
            }

            if ($this->collCharacterMovess !== null) {
                foreach ($this->collCharacterMovess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[CharactersTableMap::COL_CHARACTER_ID] = true;
        if (null !== $this->character_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CharactersTableMap::COL_CHARACTER_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CharactersTableMap::COL_CHARACTER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'character_id';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_CAMPAIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'campaign_id';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_POKEDEX_ID)) {
            $modifiedColumns[':p' . $index++]  = 'pokedex_id';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_OWNER)) {
            $modifiedColumns[':p' . $index++]  = 'owner';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AGE)) {
            $modifiedColumns[':p' . $index++]  = 'age';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_WEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'weight';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_HEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'height';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SEX)) {
            $modifiedColumns[':p' . $index++]  = 'sex';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_TYPE1)) {
            $modifiedColumns[':p' . $index++]  = 'base_type1';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_TYPE2)) {
            $modifiedColumns[':p' . $index++]  = 'base_type2';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_LEVEL)) {
            $modifiedColumns[':p' . $index++]  = 'level';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_EXP)) {
            $modifiedColumns[':p' . $index++]  = 'exp';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_HP)) {
            $modifiedColumns[':p' . $index++]  = 'base_hp';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_ATK)) {
            $modifiedColumns[':p' . $index++]  = 'base_atk';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_DEF)) {
            $modifiedColumns[':p' . $index++]  = 'base_def';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SATK)) {
            $modifiedColumns[':p' . $index++]  = 'base_satk';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SDEF)) {
            $modifiedColumns[':p' . $index++]  = 'base_sdef';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SPD)) {
            $modifiedColumns[':p' . $index++]  = 'base_spd';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_HP)) {
            $modifiedColumns[':p' . $index++]  = 'add_hp';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_ATK)) {
            $modifiedColumns[':p' . $index++]  = 'add_atk';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_DEF)) {
            $modifiedColumns[':p' . $index++]  = 'add_def';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SATK)) {
            $modifiedColumns[':p' . $index++]  = 'add_satk';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SDEF)) {
            $modifiedColumns[':p' . $index++]  = 'add_sdef';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SPD)) {
            $modifiedColumns[':p' . $index++]  = 'add_spd';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_HEALTH)) {
            $modifiedColumns[':p' . $index++]  = 'health';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_INJURIES)) {
            $modifiedColumns[':p' . $index++]  = 'injuries';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_MONEY)) {
            $modifiedColumns[':p' . $index++]  = 'money';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_ACROBATICS)) {
            $modifiedColumns[':p' . $index++]  = 'skill_acrobatics';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_ATHLETICS)) {
            $modifiedColumns[':p' . $index++]  = 'skill_athletics';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_CHARM)) {
            $modifiedColumns[':p' . $index++]  = 'skill_charm';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_COMBAT)) {
            $modifiedColumns[':p' . $index++]  = 'skill_combat';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_COMMAND)) {
            $modifiedColumns[':p' . $index++]  = 'skill_command';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_GENERAL_ED)) {
            $modifiedColumns[':p' . $index++]  = 'skill_general_ed';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_MEDICINE_ED)) {
            $modifiedColumns[':p' . $index++]  = 'skill_medicine_ed';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_OCCULT_ED)) {
            $modifiedColumns[':p' . $index++]  = 'skill_occult_ed';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_POKEMON_ED)) {
            $modifiedColumns[':p' . $index++]  = 'skill_pokemon_ed';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED)) {
            $modifiedColumns[':p' . $index++]  = 'skill_technology_ed';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_FOCUS)) {
            $modifiedColumns[':p' . $index++]  = 'skill_focus';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_GUILE)) {
            $modifiedColumns[':p' . $index++]  = 'skill_guile';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_INTIMIDATE)) {
            $modifiedColumns[':p' . $index++]  = 'skill_intimidate';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_INTUITION)) {
            $modifiedColumns[':p' . $index++]  = 'skill_intuition';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_PERCEPTION)) {
            $modifiedColumns[':p' . $index++]  = 'skill_perception';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_STEALTH)) {
            $modifiedColumns[':p' . $index++]  = 'skill_stealth';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_SURVIVAL)) {
            $modifiedColumns[':p' . $index++]  = 'skill_survival';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_SPENT)) {
            $modifiedColumns[':p' . $index++]  = 'ap_spent';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_BOUND)) {
            $modifiedColumns[':p' . $index++]  = 'ap_bound';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_DRAINED)) {
            $modifiedColumns[':p' . $index++]  = 'ap_drained';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'background_name';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_ADEPT)) {
            $modifiedColumns[':p' . $index++]  = 'background_adept';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_NOVICE)) {
            $modifiedColumns[':p' . $index++]  = 'background_novice';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC1)) {
            $modifiedColumns[':p' . $index++]  = 'background_pthc1';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC2)) {
            $modifiedColumns[':p' . $index++]  = 'background_pthc2';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC3)) {
            $modifiedColumns[':p' . $index++]  = 'background_pthc3';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'notes';
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NATURE)) {
            $modifiedColumns[':p' . $index++]  = 'nature';
        }

        $sql = sprintf(
            'INSERT INTO characters (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'character_id':
                        $stmt->bindValue($identifier, $this->character_id, PDO::PARAM_INT);
                        break;
                    case 'campaign_id':
                        $stmt->bindValue($identifier, $this->campaign_id, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'pokedex_id':
                        $stmt->bindValue($identifier, $this->pokedex_id, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'owner':
                        $stmt->bindValue($identifier, $this->owner, PDO::PARAM_INT);
                        break;
                    case 'age':
                        $stmt->bindValue($identifier, $this->age, PDO::PARAM_STR);
                        break;
                    case 'weight':
                        $stmt->bindValue($identifier, $this->weight, PDO::PARAM_STR);
                        break;
                    case 'height':
                        $stmt->bindValue($identifier, $this->height, PDO::PARAM_STR);
                        break;
                    case 'sex':
                        $stmt->bindValue($identifier, $this->sex, PDO::PARAM_STR);
                        break;
                    case 'base_type1':
                        $stmt->bindValue($identifier, $this->base_type1, PDO::PARAM_STR);
                        break;
                    case 'base_type2':
                        $stmt->bindValue($identifier, $this->base_type2, PDO::PARAM_STR);
                        break;
                    case 'level':
                        $stmt->bindValue($identifier, $this->level, PDO::PARAM_INT);
                        break;
                    case 'exp':
                        $stmt->bindValue($identifier, $this->exp, PDO::PARAM_INT);
                        break;
                    case 'base_hp':
                        $stmt->bindValue($identifier, $this->base_hp, PDO::PARAM_INT);
                        break;
                    case 'base_atk':
                        $stmt->bindValue($identifier, $this->base_atk, PDO::PARAM_INT);
                        break;
                    case 'base_def':
                        $stmt->bindValue($identifier, $this->base_def, PDO::PARAM_INT);
                        break;
                    case 'base_satk':
                        $stmt->bindValue($identifier, $this->base_satk, PDO::PARAM_INT);
                        break;
                    case 'base_sdef':
                        $stmt->bindValue($identifier, $this->base_sdef, PDO::PARAM_INT);
                        break;
                    case 'base_spd':
                        $stmt->bindValue($identifier, $this->base_spd, PDO::PARAM_INT);
                        break;
                    case 'add_hp':
                        $stmt->bindValue($identifier, $this->add_hp, PDO::PARAM_INT);
                        break;
                    case 'add_atk':
                        $stmt->bindValue($identifier, $this->add_atk, PDO::PARAM_INT);
                        break;
                    case 'add_def':
                        $stmt->bindValue($identifier, $this->add_def, PDO::PARAM_INT);
                        break;
                    case 'add_satk':
                        $stmt->bindValue($identifier, $this->add_satk, PDO::PARAM_INT);
                        break;
                    case 'add_sdef':
                        $stmt->bindValue($identifier, $this->add_sdef, PDO::PARAM_INT);
                        break;
                    case 'add_spd':
                        $stmt->bindValue($identifier, $this->add_spd, PDO::PARAM_INT);
                        break;
                    case 'health':
                        $stmt->bindValue($identifier, $this->health, PDO::PARAM_INT);
                        break;
                    case 'injuries':
                        $stmt->bindValue($identifier, $this->injuries, PDO::PARAM_INT);
                        break;
                    case 'money':
                        $stmt->bindValue($identifier, $this->money, PDO::PARAM_INT);
                        break;
                    case 'skill_acrobatics':
                        $stmt->bindValue($identifier, $this->skill_acrobatics, PDO::PARAM_INT);
                        break;
                    case 'skill_athletics':
                        $stmt->bindValue($identifier, $this->skill_athletics, PDO::PARAM_INT);
                        break;
                    case 'skill_charm':
                        $stmt->bindValue($identifier, $this->skill_charm, PDO::PARAM_INT);
                        break;
                    case 'skill_combat':
                        $stmt->bindValue($identifier, $this->skill_combat, PDO::PARAM_INT);
                        break;
                    case 'skill_command':
                        $stmt->bindValue($identifier, $this->skill_command, PDO::PARAM_INT);
                        break;
                    case 'skill_general_ed':
                        $stmt->bindValue($identifier, $this->skill_general_ed, PDO::PARAM_INT);
                        break;
                    case 'skill_medicine_ed':
                        $stmt->bindValue($identifier, $this->skill_medicine_ed, PDO::PARAM_INT);
                        break;
                    case 'skill_occult_ed':
                        $stmt->bindValue($identifier, $this->skill_occult_ed, PDO::PARAM_INT);
                        break;
                    case 'skill_pokemon_ed':
                        $stmt->bindValue($identifier, $this->skill_pokemon_ed, PDO::PARAM_INT);
                        break;
                    case 'skill_technology_ed':
                        $stmt->bindValue($identifier, $this->skill_technology_ed, PDO::PARAM_INT);
                        break;
                    case 'skill_focus':
                        $stmt->bindValue($identifier, $this->skill_focus, PDO::PARAM_INT);
                        break;
                    case 'skill_guile':
                        $stmt->bindValue($identifier, $this->skill_guile, PDO::PARAM_INT);
                        break;
                    case 'skill_intimidate':
                        $stmt->bindValue($identifier, $this->skill_intimidate, PDO::PARAM_INT);
                        break;
                    case 'skill_intuition':
                        $stmt->bindValue($identifier, $this->skill_intuition, PDO::PARAM_INT);
                        break;
                    case 'skill_perception':
                        $stmt->bindValue($identifier, $this->skill_perception, PDO::PARAM_INT);
                        break;
                    case 'skill_stealth':
                        $stmt->bindValue($identifier, $this->skill_stealth, PDO::PARAM_INT);
                        break;
                    case 'skill_survival':
                        $stmt->bindValue($identifier, $this->skill_survival, PDO::PARAM_INT);
                        break;
                    case 'ap_spent':
                        $stmt->bindValue($identifier, $this->ap_spent, PDO::PARAM_INT);
                        break;
                    case 'ap_bound':
                        $stmt->bindValue($identifier, $this->ap_bound, PDO::PARAM_INT);
                        break;
                    case 'ap_drained':
                        $stmt->bindValue($identifier, $this->ap_drained, PDO::PARAM_INT);
                        break;
                    case 'background_name':
                        $stmt->bindValue($identifier, $this->background_name, PDO::PARAM_STR);
                        break;
                    case 'background_adept':
                        $stmt->bindValue($identifier, $this->background_adept, PDO::PARAM_STR);
                        break;
                    case 'background_novice':
                        $stmt->bindValue($identifier, $this->background_novice, PDO::PARAM_STR);
                        break;
                    case 'background_pthc1':
                        $stmt->bindValue($identifier, $this->background_pthc1, PDO::PARAM_STR);
                        break;
                    case 'background_pthc2':
                        $stmt->bindValue($identifier, $this->background_pthc2, PDO::PARAM_STR);
                        break;
                    case 'background_pthc3':
                        $stmt->bindValue($identifier, $this->background_pthc3, PDO::PARAM_STR);
                        break;
                    case 'notes':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'nature':
                        $stmt->bindValue($identifier, $this->nature, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setCharacterId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CharactersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCharacterId();
                break;
            case 1:
                return $this->getCampaignId();
                break;
            case 2:
                return $this->getType();
                break;
            case 3:
                return $this->getPokedexId();
                break;
            case 4:
                return $this->getName();
                break;
            case 5:
                return $this->getOwner();
                break;
            case 6:
                return $this->getAge();
                break;
            case 7:
                return $this->getWeight();
                break;
            case 8:
                return $this->getHeight();
                break;
            case 9:
                return $this->getSex();
                break;
            case 10:
                return $this->getType1();
                break;
            case 11:
                return $this->getType2();
                break;
            case 12:
                return $this->getLevel();
                break;
            case 13:
                return $this->getExp();
                break;
            case 14:
                return $this->getBaseHp();
                break;
            case 15:
                return $this->getBaseAtk();
                break;
            case 16:
                return $this->getBaseDef();
                break;
            case 17:
                return $this->getBaseSatk();
                break;
            case 18:
                return $this->getBaseSdef();
                break;
            case 19:
                return $this->getBaseSpd();
                break;
            case 20:
                return $this->getAddHp();
                break;
            case 21:
                return $this->getAddAtk();
                break;
            case 22:
                return $this->getAddDef();
                break;
            case 23:
                return $this->getAddSatk();
                break;
            case 24:
                return $this->getAddSdef();
                break;
            case 25:
                return $this->getAddSpd();
                break;
            case 26:
                return $this->getHealth();
                break;
            case 27:
                return $this->getInjuries();
                break;
            case 28:
                return $this->getMoney();
                break;
            case 29:
                return $this->getSkillAcrobatics();
                break;
            case 30:
                return $this->getSkillAthletics();
                break;
            case 31:
                return $this->getSkillCharm();
                break;
            case 32:
                return $this->getSkillCombat();
                break;
            case 33:
                return $this->getSkillCommand();
                break;
            case 34:
                return $this->getSkillGeneralEd();
                break;
            case 35:
                return $this->getSkillMedicineEd();
                break;
            case 36:
                return $this->getSkillOccultEd();
                break;
            case 37:
                return $this->getSkillPokemonEd();
                break;
            case 38:
                return $this->getSkillTechnologyEd();
                break;
            case 39:
                return $this->getSkillFocus();
                break;
            case 40:
                return $this->getSkillGuile();
                break;
            case 41:
                return $this->getSkillIntimidate();
                break;
            case 42:
                return $this->getSkillIntuition();
                break;
            case 43:
                return $this->getSkillPerception();
                break;
            case 44:
                return $this->getSkillStealth();
                break;
            case 45:
                return $this->getSkillSurvival();
                break;
            case 46:
                return $this->getApSpent();
                break;
            case 47:
                return $this->getApBound();
                break;
            case 48:
                return $this->getApDrained();
                break;
            case 49:
                return $this->getBackgroundName();
                break;
            case 50:
                return $this->getBackgroundAdept();
                break;
            case 51:
                return $this->getBackgroundNovice();
                break;
            case 52:
                return $this->getBackgroundPthc1();
                break;
            case 53:
                return $this->getBackgroundPthc2();
                break;
            case 54:
                return $this->getBackgroundPthc3();
                break;
            case 55:
                return $this->getNotes();
                break;
            case 56:
                return $this->getNature();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Characters'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Characters'][$this->hashCode()] = true;
        $keys = CharactersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCharacterId(),
            $keys[1] => $this->getCampaignId(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getPokedexId(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getOwner(),
            $keys[6] => $this->getAge(),
            $keys[7] => $this->getWeight(),
            $keys[8] => $this->getHeight(),
            $keys[9] => $this->getSex(),
            $keys[10] => $this->getType1(),
            $keys[11] => $this->getType2(),
            $keys[12] => $this->getLevel(),
            $keys[13] => $this->getExp(),
            $keys[14] => $this->getBaseHp(),
            $keys[15] => $this->getBaseAtk(),
            $keys[16] => $this->getBaseDef(),
            $keys[17] => $this->getBaseSatk(),
            $keys[18] => $this->getBaseSdef(),
            $keys[19] => $this->getBaseSpd(),
            $keys[20] => $this->getAddHp(),
            $keys[21] => $this->getAddAtk(),
            $keys[22] => $this->getAddDef(),
            $keys[23] => $this->getAddSatk(),
            $keys[24] => $this->getAddSdef(),
            $keys[25] => $this->getAddSpd(),
            $keys[26] => $this->getHealth(),
            $keys[27] => $this->getInjuries(),
            $keys[28] => $this->getMoney(),
            $keys[29] => $this->getSkillAcrobatics(),
            $keys[30] => $this->getSkillAthletics(),
            $keys[31] => $this->getSkillCharm(),
            $keys[32] => $this->getSkillCombat(),
            $keys[33] => $this->getSkillCommand(),
            $keys[34] => $this->getSkillGeneralEd(),
            $keys[35] => $this->getSkillMedicineEd(),
            $keys[36] => $this->getSkillOccultEd(),
            $keys[37] => $this->getSkillPokemonEd(),
            $keys[38] => $this->getSkillTechnologyEd(),
            $keys[39] => $this->getSkillFocus(),
            $keys[40] => $this->getSkillGuile(),
            $keys[41] => $this->getSkillIntimidate(),
            $keys[42] => $this->getSkillIntuition(),
            $keys[43] => $this->getSkillPerception(),
            $keys[44] => $this->getSkillStealth(),
            $keys[45] => $this->getSkillSurvival(),
            $keys[46] => $this->getApSpent(),
            $keys[47] => $this->getApBound(),
            $keys[48] => $this->getApDrained(),
            $keys[49] => $this->getBackgroundName(),
            $keys[50] => $this->getBackgroundAdept(),
            $keys[51] => $this->getBackgroundNovice(),
            $keys[52] => $this->getBackgroundPthc1(),
            $keys[53] => $this->getBackgroundPthc2(),
            $keys[54] => $this->getBackgroundPthc3(),
            $keys[55] => $this->getNotes(),
            $keys[56] => $this->getNature(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCampaigns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'campaigns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'campaigns';
                        break;
                    default:
                        $key = 'Campaigns';
                }

                $result[$key] = $this->aCampaigns->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBattleEntriess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'battleEntriess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'battle_entriess';
                        break;
                    default:
                        $key = 'BattleEntriess';
                }

                $result[$key] = $this->collBattleEntriess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCharacterAbilitiess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'characterAbilitiess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'character_abilitiess';
                        break;
                    default:
                        $key = 'CharacterAbilitiess';
                }

                $result[$key] = $this->collCharacterAbilitiess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCharacterBuffss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'characterBuffss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'character_buffss';
                        break;
                    default:
                        $key = 'CharacterBuffss';
                }

                $result[$key] = $this->collCharacterBuffss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCharacterMovess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'characterMovess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'character_movess';
                        break;
                    default:
                        $key = 'CharacterMovess';
                }

                $result[$key] = $this->collCharacterMovess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Propel\PtuToolkit\Characters
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CharactersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\PtuToolkit\Characters
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCharacterId($value);
                break;
            case 1:
                $this->setCampaignId($value);
                break;
            case 2:
                $this->setType($value);
                break;
            case 3:
                $this->setPokedexId($value);
                break;
            case 4:
                $this->setName($value);
                break;
            case 5:
                $this->setOwner($value);
                break;
            case 6:
                $this->setAge($value);
                break;
            case 7:
                $this->setWeight($value);
                break;
            case 8:
                $this->setHeight($value);
                break;
            case 9:
                $this->setSex($value);
                break;
            case 10:
                $this->setType1($value);
                break;
            case 11:
                $this->setType2($value);
                break;
            case 12:
                $this->setLevel($value);
                break;
            case 13:
                $this->setExp($value);
                break;
            case 14:
                $this->setBaseHp($value);
                break;
            case 15:
                $this->setBaseAtk($value);
                break;
            case 16:
                $this->setBaseDef($value);
                break;
            case 17:
                $this->setBaseSatk($value);
                break;
            case 18:
                $this->setBaseSdef($value);
                break;
            case 19:
                $this->setBaseSpd($value);
                break;
            case 20:
                $this->setAddHp($value);
                break;
            case 21:
                $this->setAddAtk($value);
                break;
            case 22:
                $this->setAddDef($value);
                break;
            case 23:
                $this->setAddSatk($value);
                break;
            case 24:
                $this->setAddSdef($value);
                break;
            case 25:
                $this->setAddSpd($value);
                break;
            case 26:
                $this->setHealth($value);
                break;
            case 27:
                $this->setInjuries($value);
                break;
            case 28:
                $this->setMoney($value);
                break;
            case 29:
                $this->setSkillAcrobatics($value);
                break;
            case 30:
                $this->setSkillAthletics($value);
                break;
            case 31:
                $this->setSkillCharm($value);
                break;
            case 32:
                $this->setSkillCombat($value);
                break;
            case 33:
                $this->setSkillCommand($value);
                break;
            case 34:
                $this->setSkillGeneralEd($value);
                break;
            case 35:
                $this->setSkillMedicineEd($value);
                break;
            case 36:
                $this->setSkillOccultEd($value);
                break;
            case 37:
                $this->setSkillPokemonEd($value);
                break;
            case 38:
                $this->setSkillTechnologyEd($value);
                break;
            case 39:
                $this->setSkillFocus($value);
                break;
            case 40:
                $this->setSkillGuile($value);
                break;
            case 41:
                $this->setSkillIntimidate($value);
                break;
            case 42:
                $this->setSkillIntuition($value);
                break;
            case 43:
                $this->setSkillPerception($value);
                break;
            case 44:
                $this->setSkillStealth($value);
                break;
            case 45:
                $this->setSkillSurvival($value);
                break;
            case 46:
                $this->setApSpent($value);
                break;
            case 47:
                $this->setApBound($value);
                break;
            case 48:
                $this->setApDrained($value);
                break;
            case 49:
                $this->setBackgroundName($value);
                break;
            case 50:
                $this->setBackgroundAdept($value);
                break;
            case 51:
                $this->setBackgroundNovice($value);
                break;
            case 52:
                $this->setBackgroundPthc1($value);
                break;
            case 53:
                $this->setBackgroundPthc2($value);
                break;
            case 54:
                $this->setBackgroundPthc3($value);
                break;
            case 55:
                $this->setNotes($value);
                break;
            case 56:
                $this->setNature($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CharactersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCharacterId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCampaignId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPokedexId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setOwner($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAge($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setWeight($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setHeight($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSex($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setType1($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setType2($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setLevel($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setExp($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setBaseHp($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setBaseAtk($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setBaseDef($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setBaseSatk($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setBaseSdef($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setBaseSpd($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setAddHp($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setAddAtk($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setAddDef($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setAddSatk($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setAddSdef($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setAddSpd($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setHealth($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setInjuries($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setMoney($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setSkillAcrobatics($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setSkillAthletics($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setSkillCharm($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setSkillCombat($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setSkillCommand($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->setSkillGeneralEd($arr[$keys[34]]);
        }
        if (array_key_exists($keys[35], $arr)) {
            $this->setSkillMedicineEd($arr[$keys[35]]);
        }
        if (array_key_exists($keys[36], $arr)) {
            $this->setSkillOccultEd($arr[$keys[36]]);
        }
        if (array_key_exists($keys[37], $arr)) {
            $this->setSkillPokemonEd($arr[$keys[37]]);
        }
        if (array_key_exists($keys[38], $arr)) {
            $this->setSkillTechnologyEd($arr[$keys[38]]);
        }
        if (array_key_exists($keys[39], $arr)) {
            $this->setSkillFocus($arr[$keys[39]]);
        }
        if (array_key_exists($keys[40], $arr)) {
            $this->setSkillGuile($arr[$keys[40]]);
        }
        if (array_key_exists($keys[41], $arr)) {
            $this->setSkillIntimidate($arr[$keys[41]]);
        }
        if (array_key_exists($keys[42], $arr)) {
            $this->setSkillIntuition($arr[$keys[42]]);
        }
        if (array_key_exists($keys[43], $arr)) {
            $this->setSkillPerception($arr[$keys[43]]);
        }
        if (array_key_exists($keys[44], $arr)) {
            $this->setSkillStealth($arr[$keys[44]]);
        }
        if (array_key_exists($keys[45], $arr)) {
            $this->setSkillSurvival($arr[$keys[45]]);
        }
        if (array_key_exists($keys[46], $arr)) {
            $this->setApSpent($arr[$keys[46]]);
        }
        if (array_key_exists($keys[47], $arr)) {
            $this->setApBound($arr[$keys[47]]);
        }
        if (array_key_exists($keys[48], $arr)) {
            $this->setApDrained($arr[$keys[48]]);
        }
        if (array_key_exists($keys[49], $arr)) {
            $this->setBackgroundName($arr[$keys[49]]);
        }
        if (array_key_exists($keys[50], $arr)) {
            $this->setBackgroundAdept($arr[$keys[50]]);
        }
        if (array_key_exists($keys[51], $arr)) {
            $this->setBackgroundNovice($arr[$keys[51]]);
        }
        if (array_key_exists($keys[52], $arr)) {
            $this->setBackgroundPthc1($arr[$keys[52]]);
        }
        if (array_key_exists($keys[53], $arr)) {
            $this->setBackgroundPthc2($arr[$keys[53]]);
        }
        if (array_key_exists($keys[54], $arr)) {
            $this->setBackgroundPthc3($arr[$keys[54]]);
        }
        if (array_key_exists($keys[55], $arr)) {
            $this->setNotes($arr[$keys[55]]);
        }
        if (array_key_exists($keys[56], $arr)) {
            $this->setNature($arr[$keys[56]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Propel\PtuToolkit\Characters The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CharactersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CharactersTableMap::COL_CHARACTER_ID)) {
            $criteria->add(CharactersTableMap::COL_CHARACTER_ID, $this->character_id);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_CAMPAIGN_ID)) {
            $criteria->add(CharactersTableMap::COL_CAMPAIGN_ID, $this->campaign_id);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_TYPE)) {
            $criteria->add(CharactersTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_POKEDEX_ID)) {
            $criteria->add(CharactersTableMap::COL_POKEDEX_ID, $this->pokedex_id);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NAME)) {
            $criteria->add(CharactersTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_OWNER)) {
            $criteria->add(CharactersTableMap::COL_OWNER, $this->owner);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AGE)) {
            $criteria->add(CharactersTableMap::COL_AGE, $this->age);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_WEIGHT)) {
            $criteria->add(CharactersTableMap::COL_WEIGHT, $this->weight);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_HEIGHT)) {
            $criteria->add(CharactersTableMap::COL_HEIGHT, $this->height);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SEX)) {
            $criteria->add(CharactersTableMap::COL_SEX, $this->sex);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_TYPE1)) {
            $criteria->add(CharactersTableMap::COL_BASE_TYPE1, $this->base_type1);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_TYPE2)) {
            $criteria->add(CharactersTableMap::COL_BASE_TYPE2, $this->base_type2);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_LEVEL)) {
            $criteria->add(CharactersTableMap::COL_LEVEL, $this->level);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_EXP)) {
            $criteria->add(CharactersTableMap::COL_EXP, $this->exp);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_HP)) {
            $criteria->add(CharactersTableMap::COL_BASE_HP, $this->base_hp);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_ATK)) {
            $criteria->add(CharactersTableMap::COL_BASE_ATK, $this->base_atk);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_DEF)) {
            $criteria->add(CharactersTableMap::COL_BASE_DEF, $this->base_def);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SATK)) {
            $criteria->add(CharactersTableMap::COL_BASE_SATK, $this->base_satk);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SDEF)) {
            $criteria->add(CharactersTableMap::COL_BASE_SDEF, $this->base_sdef);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BASE_SPD)) {
            $criteria->add(CharactersTableMap::COL_BASE_SPD, $this->base_spd);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_HP)) {
            $criteria->add(CharactersTableMap::COL_ADD_HP, $this->add_hp);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_ATK)) {
            $criteria->add(CharactersTableMap::COL_ADD_ATK, $this->add_atk);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_DEF)) {
            $criteria->add(CharactersTableMap::COL_ADD_DEF, $this->add_def);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SATK)) {
            $criteria->add(CharactersTableMap::COL_ADD_SATK, $this->add_satk);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SDEF)) {
            $criteria->add(CharactersTableMap::COL_ADD_SDEF, $this->add_sdef);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_ADD_SPD)) {
            $criteria->add(CharactersTableMap::COL_ADD_SPD, $this->add_spd);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_HEALTH)) {
            $criteria->add(CharactersTableMap::COL_HEALTH, $this->health);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_INJURIES)) {
            $criteria->add(CharactersTableMap::COL_INJURIES, $this->injuries);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_MONEY)) {
            $criteria->add(CharactersTableMap::COL_MONEY, $this->money);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_ACROBATICS)) {
            $criteria->add(CharactersTableMap::COL_SKILL_ACROBATICS, $this->skill_acrobatics);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_ATHLETICS)) {
            $criteria->add(CharactersTableMap::COL_SKILL_ATHLETICS, $this->skill_athletics);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_CHARM)) {
            $criteria->add(CharactersTableMap::COL_SKILL_CHARM, $this->skill_charm);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_COMBAT)) {
            $criteria->add(CharactersTableMap::COL_SKILL_COMBAT, $this->skill_combat);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_COMMAND)) {
            $criteria->add(CharactersTableMap::COL_SKILL_COMMAND, $this->skill_command);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_GENERAL_ED)) {
            $criteria->add(CharactersTableMap::COL_SKILL_GENERAL_ED, $this->skill_general_ed);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_MEDICINE_ED)) {
            $criteria->add(CharactersTableMap::COL_SKILL_MEDICINE_ED, $this->skill_medicine_ed);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_OCCULT_ED)) {
            $criteria->add(CharactersTableMap::COL_SKILL_OCCULT_ED, $this->skill_occult_ed);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_POKEMON_ED)) {
            $criteria->add(CharactersTableMap::COL_SKILL_POKEMON_ED, $this->skill_pokemon_ed);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED)) {
            $criteria->add(CharactersTableMap::COL_SKILL_TECHNOLOGY_ED, $this->skill_technology_ed);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_FOCUS)) {
            $criteria->add(CharactersTableMap::COL_SKILL_FOCUS, $this->skill_focus);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_GUILE)) {
            $criteria->add(CharactersTableMap::COL_SKILL_GUILE, $this->skill_guile);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_INTIMIDATE)) {
            $criteria->add(CharactersTableMap::COL_SKILL_INTIMIDATE, $this->skill_intimidate);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_INTUITION)) {
            $criteria->add(CharactersTableMap::COL_SKILL_INTUITION, $this->skill_intuition);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_PERCEPTION)) {
            $criteria->add(CharactersTableMap::COL_SKILL_PERCEPTION, $this->skill_perception);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_STEALTH)) {
            $criteria->add(CharactersTableMap::COL_SKILL_STEALTH, $this->skill_stealth);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_SKILL_SURVIVAL)) {
            $criteria->add(CharactersTableMap::COL_SKILL_SURVIVAL, $this->skill_survival);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_SPENT)) {
            $criteria->add(CharactersTableMap::COL_AP_SPENT, $this->ap_spent);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_BOUND)) {
            $criteria->add(CharactersTableMap::COL_AP_BOUND, $this->ap_bound);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_AP_DRAINED)) {
            $criteria->add(CharactersTableMap::COL_AP_DRAINED, $this->ap_drained);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_NAME)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_NAME, $this->background_name);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_ADEPT)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_ADEPT, $this->background_adept);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_NOVICE)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_NOVICE, $this->background_novice);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC1)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_PTHC1, $this->background_pthc1);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC2)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_PTHC2, $this->background_pthc2);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_BACKGROUND_PTHC3)) {
            $criteria->add(CharactersTableMap::COL_BACKGROUND_PTHC3, $this->background_pthc3);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NOTES)) {
            $criteria->add(CharactersTableMap::COL_NOTES, $this->notes);
        }
        if ($this->isColumnModified(CharactersTableMap::COL_NATURE)) {
            $criteria->add(CharactersTableMap::COL_NATURE, $this->nature);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildCharactersQuery::create();
        $criteria->add(CharactersTableMap::COL_CHARACTER_ID, $this->character_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getCharacterId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCharacterId();
    }

    /**
     * Generic method to set the primary key (character_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCharacterId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCharacterId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Propel\PtuToolkit\Characters (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCampaignId($this->getCampaignId());
        $copyObj->setType($this->getType());
        $copyObj->setPokedexId($this->getPokedexId());
        $copyObj->setName($this->getName());
        $copyObj->setOwner($this->getOwner());
        $copyObj->setAge($this->getAge());
        $copyObj->setWeight($this->getWeight());
        $copyObj->setHeight($this->getHeight());
        $copyObj->setSex($this->getSex());
        $copyObj->setType1($this->getType1());
        $copyObj->setType2($this->getType2());
        $copyObj->setLevel($this->getLevel());
        $copyObj->setExp($this->getExp());
        $copyObj->setBaseHp($this->getBaseHp());
        $copyObj->setBaseAtk($this->getBaseAtk());
        $copyObj->setBaseDef($this->getBaseDef());
        $copyObj->setBaseSatk($this->getBaseSatk());
        $copyObj->setBaseSdef($this->getBaseSdef());
        $copyObj->setBaseSpd($this->getBaseSpd());
        $copyObj->setAddHp($this->getAddHp());
        $copyObj->setAddAtk($this->getAddAtk());
        $copyObj->setAddDef($this->getAddDef());
        $copyObj->setAddSatk($this->getAddSatk());
        $copyObj->setAddSdef($this->getAddSdef());
        $copyObj->setAddSpd($this->getAddSpd());
        $copyObj->setHealth($this->getHealth());
        $copyObj->setInjuries($this->getInjuries());
        $copyObj->setMoney($this->getMoney());
        $copyObj->setSkillAcrobatics($this->getSkillAcrobatics());
        $copyObj->setSkillAthletics($this->getSkillAthletics());
        $copyObj->setSkillCharm($this->getSkillCharm());
        $copyObj->setSkillCombat($this->getSkillCombat());
        $copyObj->setSkillCommand($this->getSkillCommand());
        $copyObj->setSkillGeneralEd($this->getSkillGeneralEd());
        $copyObj->setSkillMedicineEd($this->getSkillMedicineEd());
        $copyObj->setSkillOccultEd($this->getSkillOccultEd());
        $copyObj->setSkillPokemonEd($this->getSkillPokemonEd());
        $copyObj->setSkillTechnologyEd($this->getSkillTechnologyEd());
        $copyObj->setSkillFocus($this->getSkillFocus());
        $copyObj->setSkillGuile($this->getSkillGuile());
        $copyObj->setSkillIntimidate($this->getSkillIntimidate());
        $copyObj->setSkillIntuition($this->getSkillIntuition());
        $copyObj->setSkillPerception($this->getSkillPerception());
        $copyObj->setSkillStealth($this->getSkillStealth());
        $copyObj->setSkillSurvival($this->getSkillSurvival());
        $copyObj->setApSpent($this->getApSpent());
        $copyObj->setApBound($this->getApBound());
        $copyObj->setApDrained($this->getApDrained());
        $copyObj->setBackgroundName($this->getBackgroundName());
        $copyObj->setBackgroundAdept($this->getBackgroundAdept());
        $copyObj->setBackgroundNovice($this->getBackgroundNovice());
        $copyObj->setBackgroundPthc1($this->getBackgroundPthc1());
        $copyObj->setBackgroundPthc2($this->getBackgroundPthc2());
        $copyObj->setBackgroundPthc3($this->getBackgroundPthc3());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setNature($this->getNature());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBattleEntriess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBattleEntries($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCharacterAbilitiess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCharacterAbilities($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCharacterBuffss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCharacterBuffs($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCharacterMovess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCharacterMoves($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCharacterId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Propel\PtuToolkit\Characters Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildCampaigns object.
     *
     * @param  ChildCampaigns $v
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCampaigns(ChildCampaigns $v = null)
    {
        if ($v === null) {
            $this->setCampaignId(NULL);
        } else {
            $this->setCampaignId($v->getCampaignId());
        }

        $this->aCampaigns = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCampaigns object, it will not be re-added.
        if ($v !== null) {
            $v->addCharacters($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCampaigns object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCampaigns The associated ChildCampaigns object.
     * @throws PropelException
     */
    public function getCampaigns(ConnectionInterface $con = null)
    {
        if ($this->aCampaigns === null && ($this->campaign_id != 0)) {
            $this->aCampaigns = ChildCampaignsQuery::create()->findPk($this->campaign_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCampaigns->addCharacterss($this);
             */
        }

        return $this->aCampaigns;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('BattleEntries' == $relationName) {
            $this->initBattleEntriess();
            return;
        }
        if ('CharacterAbilities' == $relationName) {
            $this->initCharacterAbilitiess();
            return;
        }
        if ('CharacterBuffs' == $relationName) {
            $this->initCharacterBuffss();
            return;
        }
        if ('CharacterMoves' == $relationName) {
            $this->initCharacterMovess();
            return;
        }
    }

    /**
     * Clears out the collBattleEntriess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBattleEntriess()
     */
    public function clearBattleEntriess()
    {
        $this->collBattleEntriess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBattleEntriess collection loaded partially.
     */
    public function resetPartialBattleEntriess($v = true)
    {
        $this->collBattleEntriessPartial = $v;
    }

    /**
     * Initializes the collBattleEntriess collection.
     *
     * By default this just sets the collBattleEntriess collection to an empty array (like clearcollBattleEntriess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBattleEntriess($overrideExisting = true)
    {
        if (null !== $this->collBattleEntriess && !$overrideExisting) {
            return;
        }

        $collectionClassName = BattleEntriesTableMap::getTableMap()->getCollectionClassName();

        $this->collBattleEntriess = new $collectionClassName;
        $this->collBattleEntriess->setModel('\Propel\PtuToolkit\BattleEntries');
    }

    /**
     * Gets an array of ChildBattleEntries objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCharacters is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBattleEntries[] List of ChildBattleEntries objects
     * @throws PropelException
     */
    public function getBattleEntriess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBattleEntriessPartial && !$this->isNew();
        if (null === $this->collBattleEntriess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBattleEntriess) {
                // return empty collection
                $this->initBattleEntriess();
            } else {
                $collBattleEntriess = ChildBattleEntriesQuery::create(null, $criteria)
                    ->filterByCharacters($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBattleEntriessPartial && count($collBattleEntriess)) {
                        $this->initBattleEntriess(false);

                        foreach ($collBattleEntriess as $obj) {
                            if (false == $this->collBattleEntriess->contains($obj)) {
                                $this->collBattleEntriess->append($obj);
                            }
                        }

                        $this->collBattleEntriessPartial = true;
                    }

                    return $collBattleEntriess;
                }

                if ($partial && $this->collBattleEntriess) {
                    foreach ($this->collBattleEntriess as $obj) {
                        if ($obj->isNew()) {
                            $collBattleEntriess[] = $obj;
                        }
                    }
                }

                $this->collBattleEntriess = $collBattleEntriess;
                $this->collBattleEntriessPartial = false;
            }
        }

        return $this->collBattleEntriess;
    }

    /**
     * Sets a collection of ChildBattleEntries objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $battleEntriess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function setBattleEntriess(Collection $battleEntriess, ConnectionInterface $con = null)
    {
        /** @var ChildBattleEntries[] $battleEntriessToDelete */
        $battleEntriessToDelete = $this->getBattleEntriess(new Criteria(), $con)->diff($battleEntriess);


        $this->battleEntriessScheduledForDeletion = $battleEntriessToDelete;

        foreach ($battleEntriessToDelete as $battleEntriesRemoved) {
            $battleEntriesRemoved->setCharacters(null);
        }

        $this->collBattleEntriess = null;
        foreach ($battleEntriess as $battleEntries) {
            $this->addBattleEntries($battleEntries);
        }

        $this->collBattleEntriess = $battleEntriess;
        $this->collBattleEntriessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BattleEntries objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BattleEntries objects.
     * @throws PropelException
     */
    public function countBattleEntriess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBattleEntriessPartial && !$this->isNew();
        if (null === $this->collBattleEntriess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBattleEntriess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBattleEntriess());
            }

            $query = ChildBattleEntriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCharacters($this)
                ->count($con);
        }

        return count($this->collBattleEntriess);
    }

    /**
     * Method called to associate a ChildBattleEntries object to this object
     * through the ChildBattleEntries foreign key attribute.
     *
     * @param  ChildBattleEntries $l ChildBattleEntries
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function addBattleEntries(ChildBattleEntries $l)
    {
        if ($this->collBattleEntriess === null) {
            $this->initBattleEntriess();
            $this->collBattleEntriessPartial = true;
        }

        if (!$this->collBattleEntriess->contains($l)) {
            $this->doAddBattleEntries($l);

            if ($this->battleEntriessScheduledForDeletion and $this->battleEntriessScheduledForDeletion->contains($l)) {
                $this->battleEntriessScheduledForDeletion->remove($this->battleEntriessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBattleEntries $battleEntries The ChildBattleEntries object to add.
     */
    protected function doAddBattleEntries(ChildBattleEntries $battleEntries)
    {
        $this->collBattleEntriess[]= $battleEntries;
        $battleEntries->setCharacters($this);
    }

    /**
     * @param  ChildBattleEntries $battleEntries The ChildBattleEntries object to remove.
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function removeBattleEntries(ChildBattleEntries $battleEntries)
    {
        if ($this->getBattleEntriess()->contains($battleEntries)) {
            $pos = $this->collBattleEntriess->search($battleEntries);
            $this->collBattleEntriess->remove($pos);
            if (null === $this->battleEntriessScheduledForDeletion) {
                $this->battleEntriessScheduledForDeletion = clone $this->collBattleEntriess;
                $this->battleEntriessScheduledForDeletion->clear();
            }
            $this->battleEntriessScheduledForDeletion[]= clone $battleEntries;
            $battleEntries->setCharacters(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Characters is new, it will return
     * an empty collection; or if this Characters has previously
     * been saved, it will retrieve related BattleEntriess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Characters.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildBattleEntries[] List of ChildBattleEntries objects
     */
    public function getBattleEntriessJoinBattles(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildBattleEntriesQuery::create(null, $criteria);
        $query->joinWith('Battles', $joinBehavior);

        return $this->getBattleEntriess($query, $con);
    }

    /**
     * Clears out the collCharacterAbilitiess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCharacterAbilitiess()
     */
    public function clearCharacterAbilitiess()
    {
        $this->collCharacterAbilitiess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCharacterAbilitiess collection loaded partially.
     */
    public function resetPartialCharacterAbilitiess($v = true)
    {
        $this->collCharacterAbilitiessPartial = $v;
    }

    /**
     * Initializes the collCharacterAbilitiess collection.
     *
     * By default this just sets the collCharacterAbilitiess collection to an empty array (like clearcollCharacterAbilitiess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCharacterAbilitiess($overrideExisting = true)
    {
        if (null !== $this->collCharacterAbilitiess && !$overrideExisting) {
            return;
        }

        $collectionClassName = CharacterAbilitiesTableMap::getTableMap()->getCollectionClassName();

        $this->collCharacterAbilitiess = new $collectionClassName;
        $this->collCharacterAbilitiess->setModel('\Propel\PtuToolkit\CharacterAbilities');
    }

    /**
     * Gets an array of ChildCharacterAbilities objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCharacters is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCharacterAbilities[] List of ChildCharacterAbilities objects
     * @throws PropelException
     */
    public function getCharacterAbilitiess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterAbilitiessPartial && !$this->isNew();
        if (null === $this->collCharacterAbilitiess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCharacterAbilitiess) {
                // return empty collection
                $this->initCharacterAbilitiess();
            } else {
                $collCharacterAbilitiess = ChildCharacterAbilitiesQuery::create(null, $criteria)
                    ->filterByCharacters($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCharacterAbilitiessPartial && count($collCharacterAbilitiess)) {
                        $this->initCharacterAbilitiess(false);

                        foreach ($collCharacterAbilitiess as $obj) {
                            if (false == $this->collCharacterAbilitiess->contains($obj)) {
                                $this->collCharacterAbilitiess->append($obj);
                            }
                        }

                        $this->collCharacterAbilitiessPartial = true;
                    }

                    return $collCharacterAbilitiess;
                }

                if ($partial && $this->collCharacterAbilitiess) {
                    foreach ($this->collCharacterAbilitiess as $obj) {
                        if ($obj->isNew()) {
                            $collCharacterAbilitiess[] = $obj;
                        }
                    }
                }

                $this->collCharacterAbilitiess = $collCharacterAbilitiess;
                $this->collCharacterAbilitiessPartial = false;
            }
        }

        return $this->collCharacterAbilitiess;
    }

    /**
     * Sets a collection of ChildCharacterAbilities objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $characterAbilitiess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function setCharacterAbilitiess(Collection $characterAbilitiess, ConnectionInterface $con = null)
    {
        /** @var ChildCharacterAbilities[] $characterAbilitiessToDelete */
        $characterAbilitiessToDelete = $this->getCharacterAbilitiess(new Criteria(), $con)->diff($characterAbilitiess);


        $this->characterAbilitiessScheduledForDeletion = $characterAbilitiessToDelete;

        foreach ($characterAbilitiessToDelete as $characterAbilitiesRemoved) {
            $characterAbilitiesRemoved->setCharacters(null);
        }

        $this->collCharacterAbilitiess = null;
        foreach ($characterAbilitiess as $characterAbilities) {
            $this->addCharacterAbilities($characterAbilities);
        }

        $this->collCharacterAbilitiess = $characterAbilitiess;
        $this->collCharacterAbilitiessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CharacterAbilities objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CharacterAbilities objects.
     * @throws PropelException
     */
    public function countCharacterAbilitiess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterAbilitiessPartial && !$this->isNew();
        if (null === $this->collCharacterAbilitiess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCharacterAbilitiess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCharacterAbilitiess());
            }

            $query = ChildCharacterAbilitiesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCharacters($this)
                ->count($con);
        }

        return count($this->collCharacterAbilitiess);
    }

    /**
     * Method called to associate a ChildCharacterAbilities object to this object
     * through the ChildCharacterAbilities foreign key attribute.
     *
     * @param  ChildCharacterAbilities $l ChildCharacterAbilities
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function addCharacterAbilities(ChildCharacterAbilities $l)
    {
        if ($this->collCharacterAbilitiess === null) {
            $this->initCharacterAbilitiess();
            $this->collCharacterAbilitiessPartial = true;
        }

        if (!$this->collCharacterAbilitiess->contains($l)) {
            $this->doAddCharacterAbilities($l);

            if ($this->characterAbilitiessScheduledForDeletion and $this->characterAbilitiessScheduledForDeletion->contains($l)) {
                $this->characterAbilitiessScheduledForDeletion->remove($this->characterAbilitiessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCharacterAbilities $characterAbilities The ChildCharacterAbilities object to add.
     */
    protected function doAddCharacterAbilities(ChildCharacterAbilities $characterAbilities)
    {
        $this->collCharacterAbilitiess[]= $characterAbilities;
        $characterAbilities->setCharacters($this);
    }

    /**
     * @param  ChildCharacterAbilities $characterAbilities The ChildCharacterAbilities object to remove.
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function removeCharacterAbilities(ChildCharacterAbilities $characterAbilities)
    {
        if ($this->getCharacterAbilitiess()->contains($characterAbilities)) {
            $pos = $this->collCharacterAbilitiess->search($characterAbilities);
            $this->collCharacterAbilitiess->remove($pos);
            if (null === $this->characterAbilitiessScheduledForDeletion) {
                $this->characterAbilitiessScheduledForDeletion = clone $this->collCharacterAbilitiess;
                $this->characterAbilitiessScheduledForDeletion->clear();
            }
            $this->characterAbilitiessScheduledForDeletion[]= clone $characterAbilities;
            $characterAbilities->setCharacters(null);
        }

        return $this;
    }

    /**
     * Clears out the collCharacterBuffss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCharacterBuffss()
     */
    public function clearCharacterBuffss()
    {
        $this->collCharacterBuffss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCharacterBuffss collection loaded partially.
     */
    public function resetPartialCharacterBuffss($v = true)
    {
        $this->collCharacterBuffssPartial = $v;
    }

    /**
     * Initializes the collCharacterBuffss collection.
     *
     * By default this just sets the collCharacterBuffss collection to an empty array (like clearcollCharacterBuffss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCharacterBuffss($overrideExisting = true)
    {
        if (null !== $this->collCharacterBuffss && !$overrideExisting) {
            return;
        }

        $collectionClassName = CharacterBuffsTableMap::getTableMap()->getCollectionClassName();

        $this->collCharacterBuffss = new $collectionClassName;
        $this->collCharacterBuffss->setModel('\Propel\PtuToolkit\CharacterBuffs');
    }

    /**
     * Gets an array of ChildCharacterBuffs objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCharacters is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCharacterBuffs[] List of ChildCharacterBuffs objects
     * @throws PropelException
     */
    public function getCharacterBuffss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterBuffssPartial && !$this->isNew();
        if (null === $this->collCharacterBuffss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCharacterBuffss) {
                // return empty collection
                $this->initCharacterBuffss();
            } else {
                $collCharacterBuffss = ChildCharacterBuffsQuery::create(null, $criteria)
                    ->filterByCharacters($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCharacterBuffssPartial && count($collCharacterBuffss)) {
                        $this->initCharacterBuffss(false);

                        foreach ($collCharacterBuffss as $obj) {
                            if (false == $this->collCharacterBuffss->contains($obj)) {
                                $this->collCharacterBuffss->append($obj);
                            }
                        }

                        $this->collCharacterBuffssPartial = true;
                    }

                    return $collCharacterBuffss;
                }

                if ($partial && $this->collCharacterBuffss) {
                    foreach ($this->collCharacterBuffss as $obj) {
                        if ($obj->isNew()) {
                            $collCharacterBuffss[] = $obj;
                        }
                    }
                }

                $this->collCharacterBuffss = $collCharacterBuffss;
                $this->collCharacterBuffssPartial = false;
            }
        }

        return $this->collCharacterBuffss;
    }

    /**
     * Sets a collection of ChildCharacterBuffs objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $characterBuffss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function setCharacterBuffss(Collection $characterBuffss, ConnectionInterface $con = null)
    {
        /** @var ChildCharacterBuffs[] $characterBuffssToDelete */
        $characterBuffssToDelete = $this->getCharacterBuffss(new Criteria(), $con)->diff($characterBuffss);


        $this->characterBuffssScheduledForDeletion = $characterBuffssToDelete;

        foreach ($characterBuffssToDelete as $characterBuffsRemoved) {
            $characterBuffsRemoved->setCharacters(null);
        }

        $this->collCharacterBuffss = null;
        foreach ($characterBuffss as $characterBuffs) {
            $this->addCharacterBuffs($characterBuffs);
        }

        $this->collCharacterBuffss = $characterBuffss;
        $this->collCharacterBuffssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CharacterBuffs objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CharacterBuffs objects.
     * @throws PropelException
     */
    public function countCharacterBuffss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterBuffssPartial && !$this->isNew();
        if (null === $this->collCharacterBuffss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCharacterBuffss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCharacterBuffss());
            }

            $query = ChildCharacterBuffsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCharacters($this)
                ->count($con);
        }

        return count($this->collCharacterBuffss);
    }

    /**
     * Method called to associate a ChildCharacterBuffs object to this object
     * through the ChildCharacterBuffs foreign key attribute.
     *
     * @param  ChildCharacterBuffs $l ChildCharacterBuffs
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function addCharacterBuffs(ChildCharacterBuffs $l)
    {
        if ($this->collCharacterBuffss === null) {
            $this->initCharacterBuffss();
            $this->collCharacterBuffssPartial = true;
        }

        if (!$this->collCharacterBuffss->contains($l)) {
            $this->doAddCharacterBuffs($l);

            if ($this->characterBuffssScheduledForDeletion and $this->characterBuffssScheduledForDeletion->contains($l)) {
                $this->characterBuffssScheduledForDeletion->remove($this->characterBuffssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCharacterBuffs $characterBuffs The ChildCharacterBuffs object to add.
     */
    protected function doAddCharacterBuffs(ChildCharacterBuffs $characterBuffs)
    {
        $this->collCharacterBuffss[]= $characterBuffs;
        $characterBuffs->setCharacters($this);
    }

    /**
     * @param  ChildCharacterBuffs $characterBuffs The ChildCharacterBuffs object to remove.
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function removeCharacterBuffs(ChildCharacterBuffs $characterBuffs)
    {
        if ($this->getCharacterBuffss()->contains($characterBuffs)) {
            $pos = $this->collCharacterBuffss->search($characterBuffs);
            $this->collCharacterBuffss->remove($pos);
            if (null === $this->characterBuffssScheduledForDeletion) {
                $this->characterBuffssScheduledForDeletion = clone $this->collCharacterBuffss;
                $this->characterBuffssScheduledForDeletion->clear();
            }
            $this->characterBuffssScheduledForDeletion[]= clone $characterBuffs;
            $characterBuffs->setCharacters(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Characters is new, it will return
     * an empty collection; or if this Characters has previously
     * been saved, it will retrieve related CharacterBuffss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Characters.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCharacterBuffs[] List of ChildCharacterBuffs objects
     */
    public function getCharacterBuffssJoinBattles(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCharacterBuffsQuery::create(null, $criteria);
        $query->joinWith('Battles', $joinBehavior);

        return $this->getCharacterBuffss($query, $con);
    }

    /**
     * Clears out the collCharacterMovess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCharacterMovess()
     */
    public function clearCharacterMovess()
    {
        $this->collCharacterMovess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCharacterMovess collection loaded partially.
     */
    public function resetPartialCharacterMovess($v = true)
    {
        $this->collCharacterMovessPartial = $v;
    }

    /**
     * Initializes the collCharacterMovess collection.
     *
     * By default this just sets the collCharacterMovess collection to an empty array (like clearcollCharacterMovess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCharacterMovess($overrideExisting = true)
    {
        if (null !== $this->collCharacterMovess && !$overrideExisting) {
            return;
        }

        $collectionClassName = CharacterMovesTableMap::getTableMap()->getCollectionClassName();

        $this->collCharacterMovess = new $collectionClassName;
        $this->collCharacterMovess->setModel('\Propel\PtuToolkit\CharacterMoves');
    }

    /**
     * Gets an array of ChildCharacterMoves objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCharacters is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCharacterMoves[] List of ChildCharacterMoves objects
     * @throws PropelException
     */
    public function getCharacterMovess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterMovessPartial && !$this->isNew();
        if (null === $this->collCharacterMovess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCharacterMovess) {
                // return empty collection
                $this->initCharacterMovess();
            } else {
                $collCharacterMovess = ChildCharacterMovesQuery::create(null, $criteria)
                    ->filterByCharacters($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCharacterMovessPartial && count($collCharacterMovess)) {
                        $this->initCharacterMovess(false);

                        foreach ($collCharacterMovess as $obj) {
                            if (false == $this->collCharacterMovess->contains($obj)) {
                                $this->collCharacterMovess->append($obj);
                            }
                        }

                        $this->collCharacterMovessPartial = true;
                    }

                    return $collCharacterMovess;
                }

                if ($partial && $this->collCharacterMovess) {
                    foreach ($this->collCharacterMovess as $obj) {
                        if ($obj->isNew()) {
                            $collCharacterMovess[] = $obj;
                        }
                    }
                }

                $this->collCharacterMovess = $collCharacterMovess;
                $this->collCharacterMovessPartial = false;
            }
        }

        return $this->collCharacterMovess;
    }

    /**
     * Sets a collection of ChildCharacterMoves objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $characterMovess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function setCharacterMovess(Collection $characterMovess, ConnectionInterface $con = null)
    {
        /** @var ChildCharacterMoves[] $characterMovessToDelete */
        $characterMovessToDelete = $this->getCharacterMovess(new Criteria(), $con)->diff($characterMovess);


        $this->characterMovessScheduledForDeletion = $characterMovessToDelete;

        foreach ($characterMovessToDelete as $characterMovesRemoved) {
            $characterMovesRemoved->setCharacters(null);
        }

        $this->collCharacterMovess = null;
        foreach ($characterMovess as $characterMoves) {
            $this->addCharacterMoves($characterMoves);
        }

        $this->collCharacterMovess = $characterMovess;
        $this->collCharacterMovessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CharacterMoves objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CharacterMoves objects.
     * @throws PropelException
     */
    public function countCharacterMovess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterMovessPartial && !$this->isNew();
        if (null === $this->collCharacterMovess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCharacterMovess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCharacterMovess());
            }

            $query = ChildCharacterMovesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCharacters($this)
                ->count($con);
        }

        return count($this->collCharacterMovess);
    }

    /**
     * Method called to associate a ChildCharacterMoves object to this object
     * through the ChildCharacterMoves foreign key attribute.
     *
     * @param  ChildCharacterMoves $l ChildCharacterMoves
     * @return $this|\Propel\PtuToolkit\Characters The current object (for fluent API support)
     */
    public function addCharacterMoves(ChildCharacterMoves $l)
    {
        if ($this->collCharacterMovess === null) {
            $this->initCharacterMovess();
            $this->collCharacterMovessPartial = true;
        }

        if (!$this->collCharacterMovess->contains($l)) {
            $this->doAddCharacterMoves($l);

            if ($this->characterMovessScheduledForDeletion and $this->characterMovessScheduledForDeletion->contains($l)) {
                $this->characterMovessScheduledForDeletion->remove($this->characterMovessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCharacterMoves $characterMoves The ChildCharacterMoves object to add.
     */
    protected function doAddCharacterMoves(ChildCharacterMoves $characterMoves)
    {
        $this->collCharacterMovess[]= $characterMoves;
        $characterMoves->setCharacters($this);
    }

    /**
     * @param  ChildCharacterMoves $characterMoves The ChildCharacterMoves object to remove.
     * @return $this|ChildCharacters The current object (for fluent API support)
     */
    public function removeCharacterMoves(ChildCharacterMoves $characterMoves)
    {
        if ($this->getCharacterMovess()->contains($characterMoves)) {
            $pos = $this->collCharacterMovess->search($characterMoves);
            $this->collCharacterMovess->remove($pos);
            if (null === $this->characterMovessScheduledForDeletion) {
                $this->characterMovessScheduledForDeletion = clone $this->collCharacterMovess;
                $this->characterMovessScheduledForDeletion->clear();
            }
            $this->characterMovessScheduledForDeletion[]= clone $characterMoves;
            $characterMoves->setCharacters(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Characters is new, it will return
     * an empty collection; or if this Characters has previously
     * been saved, it will retrieve related CharacterMovess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Characters.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCharacterMoves[] List of ChildCharacterMoves objects
     */
    public function getCharacterMovessJoinMoves(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCharacterMovesQuery::create(null, $criteria);
        $query->joinWith('Moves', $joinBehavior);

        return $this->getCharacterMovess($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCampaigns) {
            $this->aCampaigns->removeCharacters($this);
        }
        $this->character_id = null;
        $this->campaign_id = null;
        $this->type = null;
        $this->pokedex_id = null;
        $this->name = null;
        $this->owner = null;
        $this->age = null;
        $this->weight = null;
        $this->height = null;
        $this->sex = null;
        $this->base_type1 = null;
        $this->base_type2 = null;
        $this->level = null;
        $this->exp = null;
        $this->base_hp = null;
        $this->base_atk = null;
        $this->base_def = null;
        $this->base_satk = null;
        $this->base_sdef = null;
        $this->base_spd = null;
        $this->add_hp = null;
        $this->add_atk = null;
        $this->add_def = null;
        $this->add_satk = null;
        $this->add_sdef = null;
        $this->add_spd = null;
        $this->health = null;
        $this->injuries = null;
        $this->money = null;
        $this->skill_acrobatics = null;
        $this->skill_athletics = null;
        $this->skill_charm = null;
        $this->skill_combat = null;
        $this->skill_command = null;
        $this->skill_general_ed = null;
        $this->skill_medicine_ed = null;
        $this->skill_occult_ed = null;
        $this->skill_pokemon_ed = null;
        $this->skill_technology_ed = null;
        $this->skill_focus = null;
        $this->skill_guile = null;
        $this->skill_intimidate = null;
        $this->skill_intuition = null;
        $this->skill_perception = null;
        $this->skill_stealth = null;
        $this->skill_survival = null;
        $this->ap_spent = null;
        $this->ap_bound = null;
        $this->ap_drained = null;
        $this->background_name = null;
        $this->background_adept = null;
        $this->background_novice = null;
        $this->background_pthc1 = null;
        $this->background_pthc2 = null;
        $this->background_pthc3 = null;
        $this->notes = null;
        $this->nature = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collBattleEntriess) {
                foreach ($this->collBattleEntriess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCharacterAbilitiess) {
                foreach ($this->collCharacterAbilitiess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCharacterBuffss) {
                foreach ($this->collCharacterBuffss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCharacterMovess) {
                foreach ($this->collCharacterMovess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBattleEntriess = null;
        $this->collCharacterAbilitiess = null;
        $this->collCharacterBuffss = null;
        $this->collCharacterMovess = null;
        $this->aCampaigns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CharactersTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
