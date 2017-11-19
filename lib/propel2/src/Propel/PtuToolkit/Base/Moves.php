<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\CharacterMoves as ChildCharacterMoves;
use Propel\PtuToolkit\CharacterMovesQuery as ChildCharacterMovesQuery;
use Propel\PtuToolkit\DataPokedex as ChildDataPokedex;
use Propel\PtuToolkit\DataPokedexQuery as ChildDataPokedexQuery;
use Propel\PtuToolkit\Moves as ChildMoves;
use Propel\PtuToolkit\MovesQuery as ChildMovesQuery;
use Propel\PtuToolkit\PokedexMoves as ChildPokedexMoves;
use Propel\PtuToolkit\PokedexMovesQuery as ChildPokedexMovesQuery;
use Propel\PtuToolkit\Map\CharacterMovesTableMap;
use Propel\PtuToolkit\Map\MovesTableMap;
use Propel\PtuToolkit\Map\PokedexMovesTableMap;
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
 * Base class that represents a row from the 'moves' table.
 *
 *
 *
 * @package    propel.generator.Propel.PtuToolkit.Base
 */
abstract class Moves implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\PtuToolkit\\Map\\MovesTableMap';


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
     * The value for the move_id field.
     *
     * @var        int
     */
    protected $move_id;

    /**
     * The value for the pokedex_id field.
     *
     * @var        int
     */
    protected $pokedex_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the effect field.
     *
     * @var        string
     */
    protected $effect;

    /**
     * The value for the freq field.
     *
     * @var        string
     */
    protected $freq;

    /**
     * The value for the class field.
     *
     * @var        string
     */
    protected $class;

    /**
     * The value for the range field.
     *
     * @var        string
     */
    protected $range;

    /**
     * The value for the contest_type field.
     *
     * @var        string
     */
    protected $contest_type;

    /**
     * The value for the contest_effect field.
     *
     * @var        string
     */
    protected $contest_effect;

    /**
     * The value for the crits_on field.
     *
     * @var        int
     */
    protected $crits_on;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the triggers field.
     *
     * @var        string
     */
    protected $triggers;

    /**
     * @var        ChildDataPokedex
     */
    protected $aDataPokedex;

    /**
     * @var        ObjectCollection|ChildCharacterMoves[] Collection to store aggregation of ChildCharacterMoves objects.
     */
    protected $collCharacterMovess;
    protected $collCharacterMovessPartial;

    /**
     * @var        ObjectCollection|ChildPokedexMoves[] Collection to store aggregation of ChildPokedexMoves objects.
     */
    protected $collPokedexMovess;
    protected $collPokedexMovessPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCharacterMoves[]
     */
    protected $characterMovessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPokedexMoves[]
     */
    protected $pokedexMovessScheduledForDeletion = null;

    /**
     * Initializes internal state of Propel\PtuToolkit\Base\Moves object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Moves</code> instance.  If
     * <code>obj</code> is an instance of <code>Moves</code>, delegates to
     * <code>equals(Moves)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Moves The current object, for fluid interface
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
     * Get the [move_id] column value.
     *
     * @return int
     */
    public function getMoveId()
    {
        return $this->move_id;
    }

    /**
     * Get the [pokedex_id] column value.
     *
     * @return int
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
     * Get the [effect] column value.
     *
     * @return string
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * Get the [freq] column value.
     *
     * @return string
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * Get the [class] column value.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Get the [range] column value.
     *
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Get the [contest_type] column value.
     *
     * @return string
     */
    public function getContestType()
    {
        return $this->contest_type;
    }

    /**
     * Get the [contest_effect] column value.
     *
     * @return string
     */
    public function getContestEffect()
    {
        return $this->contest_effect;
    }

    /**
     * Get the [crits_on] column value.
     *
     * @return int
     */
    public function getCritsOn()
    {
        return $this->crits_on;
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
     * Get the [triggers] column value.
     *
     * @return string
     */
    public function getTriggers()
    {
        return $this->triggers;
    }

    /**
     * Set the value of [move_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setMoveId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->move_id !== $v) {
            $this->move_id = $v;
            $this->modifiedColumns[MovesTableMap::COL_MOVE_ID] = true;
        }

        return $this;
    } // setMoveId()

    /**
     * Set the value of [pokedex_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setPokedexId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->pokedex_id !== $v) {
            $this->pokedex_id = $v;
            $this->modifiedColumns[MovesTableMap::COL_POKEDEX_ID] = true;
        }

        if ($this->aDataPokedex !== null && $this->aDataPokedex->getPokedexId() !== $v) {
            $this->aDataPokedex = null;
        }

        return $this;
    } // setPokedexId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[MovesTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [effect] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setEffect($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->effect !== $v) {
            $this->effect = $v;
            $this->modifiedColumns[MovesTableMap::COL_EFFECT] = true;
        }

        return $this;
    } // setEffect()

    /**
     * Set the value of [freq] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setFreq($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->freq !== $v) {
            $this->freq = $v;
            $this->modifiedColumns[MovesTableMap::COL_FREQ] = true;
        }

        return $this;
    } // setFreq()

    /**
     * Set the value of [class] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->class !== $v) {
            $this->class = $v;
            $this->modifiedColumns[MovesTableMap::COL_CLASS] = true;
        }

        return $this;
    } // setClass()

    /**
     * Set the value of [range] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setRange($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->range !== $v) {
            $this->range = $v;
            $this->modifiedColumns[MovesTableMap::COL_RANGE] = true;
        }

        return $this;
    } // setRange()

    /**
     * Set the value of [contest_type] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setContestType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->contest_type !== $v) {
            $this->contest_type = $v;
            $this->modifiedColumns[MovesTableMap::COL_CONTEST_TYPE] = true;
        }

        return $this;
    } // setContestType()

    /**
     * Set the value of [contest_effect] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setContestEffect($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->contest_effect !== $v) {
            $this->contest_effect = $v;
            $this->modifiedColumns[MovesTableMap::COL_CONTEST_EFFECT] = true;
        }

        return $this;
    } // setContestEffect()

    /**
     * Set the value of [crits_on] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setCritsOn($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->crits_on !== $v) {
            $this->crits_on = $v;
            $this->modifiedColumns[MovesTableMap::COL_CRITS_ON] = true;
        }

        return $this;
    } // setCritsOn()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[MovesTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [triggers] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function setTriggers($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->triggers !== $v) {
            $this->triggers = $v;
            $this->modifiedColumns[MovesTableMap::COL_TRIGGERS] = true;
        }

        return $this;
    } // setTriggers()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MovesTableMap::translateFieldName('MoveId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->move_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MovesTableMap::translateFieldName('PokedexId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pokedex_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MovesTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MovesTableMap::translateFieldName('Effect', TableMap::TYPE_PHPNAME, $indexType)];
            $this->effect = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MovesTableMap::translateFieldName('Freq', TableMap::TYPE_PHPNAME, $indexType)];
            $this->freq = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MovesTableMap::translateFieldName('Class', TableMap::TYPE_PHPNAME, $indexType)];
            $this->class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MovesTableMap::translateFieldName('Range', TableMap::TYPE_PHPNAME, $indexType)];
            $this->range = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MovesTableMap::translateFieldName('ContestType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contest_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : MovesTableMap::translateFieldName('ContestEffect', TableMap::TYPE_PHPNAME, $indexType)];
            $this->contest_effect = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : MovesTableMap::translateFieldName('CritsOn', TableMap::TYPE_PHPNAME, $indexType)];
            $this->crits_on = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : MovesTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : MovesTableMap::translateFieldName('Triggers', TableMap::TYPE_PHPNAME, $indexType)];
            $this->triggers = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = MovesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\PtuToolkit\\Moves'), 0, $e);
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
        if ($this->aDataPokedex !== null && $this->pokedex_id !== $this->aDataPokedex->getPokedexId()) {
            $this->aDataPokedex = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(MovesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMovesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDataPokedex = null;
            $this->collCharacterMovess = null;

            $this->collPokedexMovess = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Moves::setDeleted()
     * @see Moves::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MovesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMovesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MovesTableMap::DATABASE_NAME);
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
                MovesTableMap::addInstanceToPool($this);
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

            if ($this->aDataPokedex !== null) {
                if ($this->aDataPokedex->isModified() || $this->aDataPokedex->isNew()) {
                    $affectedRows += $this->aDataPokedex->save($con);
                }
                $this->setDataPokedex($this->aDataPokedex);
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

            if ($this->characterMovessScheduledForDeletion !== null) {
                if (!$this->characterMovessScheduledForDeletion->isEmpty()) {
                    foreach ($this->characterMovessScheduledForDeletion as $characterMoves) {
                        // need to save related object because we set the relation to null
                        $characterMoves->save($con);
                    }
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

            if ($this->pokedexMovessScheduledForDeletion !== null) {
                if (!$this->pokedexMovessScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\PokedexMovesQuery::create()
                        ->filterByPrimaryKeys($this->pokedexMovessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pokedexMovessScheduledForDeletion = null;
                }
            }

            if ($this->collPokedexMovess !== null) {
                foreach ($this->collPokedexMovess as $referrerFK) {
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

        $this->modifiedColumns[MovesTableMap::COL_MOVE_ID] = true;
        if (null !== $this->move_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MovesTableMap::COL_MOVE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MovesTableMap::COL_MOVE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'move_id';
        }
        if ($this->isColumnModified(MovesTableMap::COL_POKEDEX_ID)) {
            $modifiedColumns[':p' . $index++]  = 'pokedex_id';
        }
        if ($this->isColumnModified(MovesTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(MovesTableMap::COL_EFFECT)) {
            $modifiedColumns[':p' . $index++]  = 'effect';
        }
        if ($this->isColumnModified(MovesTableMap::COL_FREQ)) {
            $modifiedColumns[':p' . $index++]  = 'freq';
        }
        if ($this->isColumnModified(MovesTableMap::COL_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'class';
        }
        if ($this->isColumnModified(MovesTableMap::COL_RANGE)) {
            $modifiedColumns[':p' . $index++]  = 'range';
        }
        if ($this->isColumnModified(MovesTableMap::COL_CONTEST_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'contest_type';
        }
        if ($this->isColumnModified(MovesTableMap::COL_CONTEST_EFFECT)) {
            $modifiedColumns[':p' . $index++]  = 'contest_effect';
        }
        if ($this->isColumnModified(MovesTableMap::COL_CRITS_ON)) {
            $modifiedColumns[':p' . $index++]  = 'crits_on';
        }
        if ($this->isColumnModified(MovesTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(MovesTableMap::COL_TRIGGERS)) {
            $modifiedColumns[':p' . $index++]  = 'triggers';
        }

        $sql = sprintf(
            'INSERT INTO moves (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'move_id':
                        $stmt->bindValue($identifier, $this->move_id, PDO::PARAM_INT);
                        break;
                    case 'pokedex_id':
                        $stmt->bindValue($identifier, $this->pokedex_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'effect':
                        $stmt->bindValue($identifier, $this->effect, PDO::PARAM_STR);
                        break;
                    case 'freq':
                        $stmt->bindValue($identifier, $this->freq, PDO::PARAM_STR);
                        break;
                    case 'class':
                        $stmt->bindValue($identifier, $this->class, PDO::PARAM_STR);
                        break;
                    case 'range':
                        $stmt->bindValue($identifier, $this->range, PDO::PARAM_STR);
                        break;
                    case 'contest_type':
                        $stmt->bindValue($identifier, $this->contest_type, PDO::PARAM_STR);
                        break;
                    case 'contest_effect':
                        $stmt->bindValue($identifier, $this->contest_effect, PDO::PARAM_STR);
                        break;
                    case 'crits_on':
                        $stmt->bindValue($identifier, $this->crits_on, PDO::PARAM_INT);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case 'triggers':
                        $stmt->bindValue($identifier, $this->triggers, PDO::PARAM_STR);
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
        $this->setMoveId($pk);

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
        $pos = MovesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getMoveId();
                break;
            case 1:
                return $this->getPokedexId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getEffect();
                break;
            case 4:
                return $this->getFreq();
                break;
            case 5:
                return $this->getClass();
                break;
            case 6:
                return $this->getRange();
                break;
            case 7:
                return $this->getContestType();
                break;
            case 8:
                return $this->getContestEffect();
                break;
            case 9:
                return $this->getCritsOn();
                break;
            case 10:
                return $this->getType();
                break;
            case 11:
                return $this->getTriggers();
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

        if (isset($alreadyDumpedObjects['Moves'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Moves'][$this->hashCode()] = true;
        $keys = MovesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getMoveId(),
            $keys[1] => $this->getPokedexId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getEffect(),
            $keys[4] => $this->getFreq(),
            $keys[5] => $this->getClass(),
            $keys[6] => $this->getRange(),
            $keys[7] => $this->getContestType(),
            $keys[8] => $this->getContestEffect(),
            $keys[9] => $this->getCritsOn(),
            $keys[10] => $this->getType(),
            $keys[11] => $this->getTriggers(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aDataPokedex) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dataPokedex';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'data_pokedex';
                        break;
                    default:
                        $key = 'DataPokedex';
                }

                $result[$key] = $this->aDataPokedex->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collPokedexMovess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pokedexMovess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pokedex-movess';
                        break;
                    default:
                        $key = 'PokedexMovess';
                }

                $result[$key] = $this->collPokedexMovess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\PtuToolkit\Moves
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MovesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\PtuToolkit\Moves
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setMoveId($value);
                break;
            case 1:
                $this->setPokedexId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setEffect($value);
                break;
            case 4:
                $this->setFreq($value);
                break;
            case 5:
                $this->setClass($value);
                break;
            case 6:
                $this->setRange($value);
                break;
            case 7:
                $this->setContestType($value);
                break;
            case 8:
                $this->setContestEffect($value);
                break;
            case 9:
                $this->setCritsOn($value);
                break;
            case 10:
                $this->setType($value);
                break;
            case 11:
                $this->setTriggers($value);
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
        $keys = MovesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setMoveId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPokedexId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEffect($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFreq($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setClass($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRange($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setContestType($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setContestEffect($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCritsOn($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setType($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setTriggers($arr[$keys[11]]);
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
     * @return $this|\Propel\PtuToolkit\Moves The current object, for fluid interface
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
        $criteria = new Criteria(MovesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MovesTableMap::COL_MOVE_ID)) {
            $criteria->add(MovesTableMap::COL_MOVE_ID, $this->move_id);
        }
        if ($this->isColumnModified(MovesTableMap::COL_POKEDEX_ID)) {
            $criteria->add(MovesTableMap::COL_POKEDEX_ID, $this->pokedex_id);
        }
        if ($this->isColumnModified(MovesTableMap::COL_NAME)) {
            $criteria->add(MovesTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(MovesTableMap::COL_EFFECT)) {
            $criteria->add(MovesTableMap::COL_EFFECT, $this->effect);
        }
        if ($this->isColumnModified(MovesTableMap::COL_FREQ)) {
            $criteria->add(MovesTableMap::COL_FREQ, $this->freq);
        }
        if ($this->isColumnModified(MovesTableMap::COL_CLASS)) {
            $criteria->add(MovesTableMap::COL_CLASS, $this->class);
        }
        if ($this->isColumnModified(MovesTableMap::COL_RANGE)) {
            $criteria->add(MovesTableMap::COL_RANGE, $this->range);
        }
        if ($this->isColumnModified(MovesTableMap::COL_CONTEST_TYPE)) {
            $criteria->add(MovesTableMap::COL_CONTEST_TYPE, $this->contest_type);
        }
        if ($this->isColumnModified(MovesTableMap::COL_CONTEST_EFFECT)) {
            $criteria->add(MovesTableMap::COL_CONTEST_EFFECT, $this->contest_effect);
        }
        if ($this->isColumnModified(MovesTableMap::COL_CRITS_ON)) {
            $criteria->add(MovesTableMap::COL_CRITS_ON, $this->crits_on);
        }
        if ($this->isColumnModified(MovesTableMap::COL_TYPE)) {
            $criteria->add(MovesTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(MovesTableMap::COL_TRIGGERS)) {
            $criteria->add(MovesTableMap::COL_TRIGGERS, $this->triggers);
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
        $criteria = ChildMovesQuery::create();
        $criteria->add(MovesTableMap::COL_MOVE_ID, $this->move_id);

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
        $validPk = null !== $this->getMoveId();

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
        return $this->getMoveId();
    }

    /**
     * Generic method to set the primary key (move_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setMoveId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getMoveId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Propel\PtuToolkit\Moves (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPokedexId($this->getPokedexId());
        $copyObj->setName($this->getName());
        $copyObj->setEffect($this->getEffect());
        $copyObj->setFreq($this->getFreq());
        $copyObj->setClass($this->getClass());
        $copyObj->setRange($this->getRange());
        $copyObj->setContestType($this->getContestType());
        $copyObj->setContestEffect($this->getContestEffect());
        $copyObj->setCritsOn($this->getCritsOn());
        $copyObj->setType($this->getType());
        $copyObj->setTriggers($this->getTriggers());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCharacterMovess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCharacterMoves($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPokedexMovess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPokedexMoves($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setMoveId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Propel\PtuToolkit\Moves Clone of current object.
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
     * Declares an association between this object and a ChildDataPokedex object.
     *
     * @param  ChildDataPokedex $v
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDataPokedex(ChildDataPokedex $v = null)
    {
        if ($v === null) {
            $this->setPokedexId(NULL);
        } else {
            $this->setPokedexId($v->getPokedexId());
        }

        $this->aDataPokedex = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildDataPokedex object, it will not be re-added.
        if ($v !== null) {
            $v->addMoves($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildDataPokedex object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildDataPokedex The associated ChildDataPokedex object.
     * @throws PropelException
     */
    public function getDataPokedex(ConnectionInterface $con = null)
    {
        if ($this->aDataPokedex === null && ($this->pokedex_id != 0)) {
            $this->aDataPokedex = ChildDataPokedexQuery::create()->findPk($this->pokedex_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDataPokedex->addMovess($this);
             */
        }

        return $this->aDataPokedex;
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
        if ('CharacterMoves' == $relationName) {
            $this->initCharacterMovess();
            return;
        }
        if ('PokedexMoves' == $relationName) {
            $this->initPokedexMovess();
            return;
        }
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
     * If this ChildMoves is new, it will return
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
                    ->filterByMoves($this)
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
     * @return $this|ChildMoves The current object (for fluent API support)
     */
    public function setCharacterMovess(Collection $characterMovess, ConnectionInterface $con = null)
    {
        /** @var ChildCharacterMoves[] $characterMovessToDelete */
        $characterMovessToDelete = $this->getCharacterMovess(new Criteria(), $con)->diff($characterMovess);


        $this->characterMovessScheduledForDeletion = $characterMovessToDelete;

        foreach ($characterMovessToDelete as $characterMovesRemoved) {
            $characterMovesRemoved->setMoves(null);
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
                ->filterByMoves($this)
                ->count($con);
        }

        return count($this->collCharacterMovess);
    }

    /**
     * Method called to associate a ChildCharacterMoves object to this object
     * through the ChildCharacterMoves foreign key attribute.
     *
     * @param  ChildCharacterMoves $l ChildCharacterMoves
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
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
        $characterMoves->setMoves($this);
    }

    /**
     * @param  ChildCharacterMoves $characterMoves The ChildCharacterMoves object to remove.
     * @return $this|ChildMoves The current object (for fluent API support)
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
            $this->characterMovessScheduledForDeletion[]= $characterMoves;
            $characterMoves->setMoves(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moves is new, it will return
     * an empty collection; or if this Moves has previously
     * been saved, it will retrieve related CharacterMovess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moves.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCharacterMoves[] List of ChildCharacterMoves objects
     */
    public function getCharacterMovessJoinCharacters(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCharacterMovesQuery::create(null, $criteria);
        $query->joinWith('Characters', $joinBehavior);

        return $this->getCharacterMovess($query, $con);
    }

    /**
     * Clears out the collPokedexMovess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPokedexMovess()
     */
    public function clearPokedexMovess()
    {
        $this->collPokedexMovess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPokedexMovess collection loaded partially.
     */
    public function resetPartialPokedexMovess($v = true)
    {
        $this->collPokedexMovessPartial = $v;
    }

    /**
     * Initializes the collPokedexMovess collection.
     *
     * By default this just sets the collPokedexMovess collection to an empty array (like clearcollPokedexMovess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPokedexMovess($overrideExisting = true)
    {
        if (null !== $this->collPokedexMovess && !$overrideExisting) {
            return;
        }

        $collectionClassName = PokedexMovesTableMap::getTableMap()->getCollectionClassName();

        $this->collPokedexMovess = new $collectionClassName;
        $this->collPokedexMovess->setModel('\Propel\PtuToolkit\PokedexMoves');
    }

    /**
     * Gets an array of ChildPokedexMoves objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMoves is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPokedexMoves[] List of ChildPokedexMoves objects
     * @throws PropelException
     */
    public function getPokedexMovess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPokedexMovessPartial && !$this->isNew();
        if (null === $this->collPokedexMovess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPokedexMovess) {
                // return empty collection
                $this->initPokedexMovess();
            } else {
                $collPokedexMovess = ChildPokedexMovesQuery::create(null, $criteria)
                    ->filterByMoves($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPokedexMovessPartial && count($collPokedexMovess)) {
                        $this->initPokedexMovess(false);

                        foreach ($collPokedexMovess as $obj) {
                            if (false == $this->collPokedexMovess->contains($obj)) {
                                $this->collPokedexMovess->append($obj);
                            }
                        }

                        $this->collPokedexMovessPartial = true;
                    }

                    return $collPokedexMovess;
                }

                if ($partial && $this->collPokedexMovess) {
                    foreach ($this->collPokedexMovess as $obj) {
                        if ($obj->isNew()) {
                            $collPokedexMovess[] = $obj;
                        }
                    }
                }

                $this->collPokedexMovess = $collPokedexMovess;
                $this->collPokedexMovessPartial = false;
            }
        }

        return $this->collPokedexMovess;
    }

    /**
     * Sets a collection of ChildPokedexMoves objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pokedexMovess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMoves The current object (for fluent API support)
     */
    public function setPokedexMovess(Collection $pokedexMovess, ConnectionInterface $con = null)
    {
        /** @var ChildPokedexMoves[] $pokedexMovessToDelete */
        $pokedexMovessToDelete = $this->getPokedexMovess(new Criteria(), $con)->diff($pokedexMovess);


        $this->pokedexMovessScheduledForDeletion = $pokedexMovessToDelete;

        foreach ($pokedexMovessToDelete as $pokedexMovesRemoved) {
            $pokedexMovesRemoved->setMoves(null);
        }

        $this->collPokedexMovess = null;
        foreach ($pokedexMovess as $pokedexMoves) {
            $this->addPokedexMoves($pokedexMoves);
        }

        $this->collPokedexMovess = $pokedexMovess;
        $this->collPokedexMovessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PokedexMoves objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PokedexMoves objects.
     * @throws PropelException
     */
    public function countPokedexMovess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPokedexMovessPartial && !$this->isNew();
        if (null === $this->collPokedexMovess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPokedexMovess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPokedexMovess());
            }

            $query = ChildPokedexMovesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMoves($this)
                ->count($con);
        }

        return count($this->collPokedexMovess);
    }

    /**
     * Method called to associate a ChildPokedexMoves object to this object
     * through the ChildPokedexMoves foreign key attribute.
     *
     * @param  ChildPokedexMoves $l ChildPokedexMoves
     * @return $this|\Propel\PtuToolkit\Moves The current object (for fluent API support)
     */
    public function addPokedexMoves(ChildPokedexMoves $l)
    {
        if ($this->collPokedexMovess === null) {
            $this->initPokedexMovess();
            $this->collPokedexMovessPartial = true;
        }

        if (!$this->collPokedexMovess->contains($l)) {
            $this->doAddPokedexMoves($l);

            if ($this->pokedexMovessScheduledForDeletion and $this->pokedexMovessScheduledForDeletion->contains($l)) {
                $this->pokedexMovessScheduledForDeletion->remove($this->pokedexMovessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPokedexMoves $pokedexMoves The ChildPokedexMoves object to add.
     */
    protected function doAddPokedexMoves(ChildPokedexMoves $pokedexMoves)
    {
        $this->collPokedexMovess[]= $pokedexMoves;
        $pokedexMoves->setMoves($this);
    }

    /**
     * @param  ChildPokedexMoves $pokedexMoves The ChildPokedexMoves object to remove.
     * @return $this|ChildMoves The current object (for fluent API support)
     */
    public function removePokedexMoves(ChildPokedexMoves $pokedexMoves)
    {
        if ($this->getPokedexMovess()->contains($pokedexMoves)) {
            $pos = $this->collPokedexMovess->search($pokedexMoves);
            $this->collPokedexMovess->remove($pos);
            if (null === $this->pokedexMovessScheduledForDeletion) {
                $this->pokedexMovessScheduledForDeletion = clone $this->collPokedexMovess;
                $this->pokedexMovessScheduledForDeletion->clear();
            }
            $this->pokedexMovessScheduledForDeletion[]= clone $pokedexMoves;
            $pokedexMoves->setMoves(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Moves is new, it will return
     * an empty collection; or if this Moves has previously
     * been saved, it will retrieve related PokedexMovess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Moves.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPokedexMoves[] List of ChildPokedexMoves objects
     */
    public function getPokedexMovessJoinDataPokedexEntry(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPokedexMovesQuery::create(null, $criteria);
        $query->joinWith('DataPokedexEntry', $joinBehavior);

        return $this->getPokedexMovess($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aDataPokedex) {
            $this->aDataPokedex->removeMoves($this);
        }
        $this->move_id = null;
        $this->pokedex_id = null;
        $this->name = null;
        $this->effect = null;
        $this->freq = null;
        $this->class = null;
        $this->range = null;
        $this->contest_type = null;
        $this->contest_effect = null;
        $this->crits_on = null;
        $this->type = null;
        $this->triggers = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collCharacterMovess) {
                foreach ($this->collCharacterMovess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPokedexMovess) {
                foreach ($this->collPokedexMovess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCharacterMovess = null;
        $this->collPokedexMovess = null;
        $this->aDataPokedex = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MovesTableMap::DEFAULT_STRING_FORMAT);
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
