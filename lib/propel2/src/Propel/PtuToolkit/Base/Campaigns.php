<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\Battles as ChildBattles;
use Propel\PtuToolkit\BattlesQuery as ChildBattlesQuery;
use Propel\PtuToolkit\Campaigns as ChildCampaigns;
use Propel\PtuToolkit\CampaignsQuery as ChildCampaignsQuery;
use Propel\PtuToolkit\Characters as ChildCharacters;
use Propel\PtuToolkit\CharactersQuery as ChildCharactersQuery;
use Propel\PtuToolkit\Users as ChildUsers;
use Propel\PtuToolkit\UsersQuery as ChildUsersQuery;
use Propel\PtuToolkit\Map\BattlesTableMap;
use Propel\PtuToolkit\Map\CampaignsTableMap;
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
 * Base class that represents a row from the 'campaigns' table.
 *
 *
 *
 * @package    propel.generator.Propel.PtuToolkit.Base
 */
abstract class Campaigns implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\PtuToolkit\\Map\\CampaignsTableMap';


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
     * The value for the campaign_id field.
     *
     * @var        int
     */
    protected $campaign_id;

    /**
     * The value for the user_firebase_id field.
     *
     * @var        string
     */
    protected $user_firebase_id;

    /**
     * The value for the campaign_name field.
     *
     * @var        string
     */
    protected $campaign_name;

    /**
     * The value for the campaign_data field.
     *
     * @var        string
     */
    protected $campaign_data;

    /**
     * @var        ChildUsers
     */
    protected $aUsers;

    /**
     * @var        ObjectCollection|ChildBattles[] Collection to store aggregation of ChildBattles objects.
     */
    protected $collBattless;
    protected $collBattlessPartial;

    /**
     * @var        ObjectCollection|ChildCharacters[] Collection to store aggregation of ChildCharacters objects.
     */
    protected $collCharacterss;
    protected $collCharacterssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBattles[]
     */
    protected $battlessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCharacters[]
     */
    protected $characterssScheduledForDeletion = null;

    /**
     * Initializes internal state of Propel\PtuToolkit\Base\Campaigns object.
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
     * Compares this with another <code>Campaigns</code> instance.  If
     * <code>obj</code> is an instance of <code>Campaigns</code>, delegates to
     * <code>equals(Campaigns)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Campaigns The current object, for fluid interface
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
     * Get the [campaign_id] column value.
     *
     * @return int
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * Get the [user_firebase_id] column value.
     *
     * @return string
     */
    public function getUserFirebaseId()
    {
        return $this->user_firebase_id;
    }

    /**
     * Get the [campaign_name] column value.
     *
     * @return string
     */
    public function getCampaignName()
    {
        return $this->campaign_name;
    }

    /**
     * Get the [campaign_data] column value.
     *
     * @return string
     */
    public function getCampaignData()
    {
        return $this->campaign_data;
    }

    /**
     * Set the value of [campaign_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function setCampaignId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->campaign_id !== $v) {
            $this->campaign_id = $v;
            $this->modifiedColumns[CampaignsTableMap::COL_CAMPAIGN_ID] = true;
        }

        return $this;
    } // setCampaignId()

    /**
     * Set the value of [user_firebase_id] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function setUserFirebaseId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_firebase_id !== $v) {
            $this->user_firebase_id = $v;
            $this->modifiedColumns[CampaignsTableMap::COL_USER_FIREBASE_ID] = true;
        }

        if ($this->aUsers !== null && $this->aUsers->getFirebaseId() !== $v) {
            $this->aUsers = null;
        }

        return $this;
    } // setUserFirebaseId()

    /**
     * Set the value of [campaign_name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function setCampaignName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->campaign_name !== $v) {
            $this->campaign_name = $v;
            $this->modifiedColumns[CampaignsTableMap::COL_CAMPAIGN_NAME] = true;
        }

        return $this;
    } // setCampaignName()

    /**
     * Set the value of [campaign_data] column.
     *
     * @param string $v new value
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function setCampaignData($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->campaign_data = fopen('php://memory', 'r+');
            fwrite($this->campaign_data, $v);
            rewind($this->campaign_data);
        } else { // it's already a stream
            $this->campaign_data = $v;
        }
        $this->modifiedColumns[CampaignsTableMap::COL_CAMPAIGN_DATA] = true;

        return $this;
    } // setCampaignData()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CampaignsTableMap::translateFieldName('CampaignId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->campaign_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CampaignsTableMap::translateFieldName('UserFirebaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_firebase_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CampaignsTableMap::translateFieldName('CampaignName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->campaign_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CampaignsTableMap::translateFieldName('CampaignData', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->campaign_data = fopen('php://memory', 'r+');
                fwrite($this->campaign_data, $col);
                rewind($this->campaign_data);
            } else {
                $this->campaign_data = null;
            }
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = CampaignsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\PtuToolkit\\Campaigns'), 0, $e);
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
        if ($this->aUsers !== null && $this->user_firebase_id !== $this->aUsers->getFirebaseId()) {
            $this->aUsers = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CampaignsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCampaignsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUsers = null;
            $this->collBattless = null;

            $this->collCharacterss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Campaigns::setDeleted()
     * @see Campaigns::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCampaignsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignsTableMap::DATABASE_NAME);
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
                CampaignsTableMap::addInstanceToPool($this);
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

            if ($this->aUsers !== null) {
                if ($this->aUsers->isModified() || $this->aUsers->isNew()) {
                    $affectedRows += $this->aUsers->save($con);
                }
                $this->setUsers($this->aUsers);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                // Rewind the campaign_data LOB column, since PDO does not rewind after inserting value.
                if ($this->campaign_data !== null && is_resource($this->campaign_data)) {
                    rewind($this->campaign_data);
                }

                $this->resetModified();
            }

            if ($this->battlessScheduledForDeletion !== null) {
                if (!$this->battlessScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\BattlesQuery::create()
                        ->filterByPrimaryKeys($this->battlessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->battlessScheduledForDeletion = null;
                }
            }

            if ($this->collBattless !== null) {
                foreach ($this->collBattless as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->characterssScheduledForDeletion !== null) {
                if (!$this->characterssScheduledForDeletion->isEmpty()) {
                    \Propel\PtuToolkit\CharactersQuery::create()
                        ->filterByPrimaryKeys($this->characterssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->characterssScheduledForDeletion = null;
                }
            }

            if ($this->collCharacterss !== null) {
                foreach ($this->collCharacterss as $referrerFK) {
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

        $this->modifiedColumns[CampaignsTableMap::COL_CAMPAIGN_ID] = true;
        if (null !== $this->campaign_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CampaignsTableMap::COL_CAMPAIGN_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'campaign_id';
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_USER_FIREBASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_firebase_id';
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'campaign_name';
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'campaign_data';
        }

        $sql = sprintf(
            'INSERT INTO campaigns (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'campaign_id':
                        $stmt->bindValue($identifier, $this->campaign_id, PDO::PARAM_INT);
                        break;
                    case 'user_firebase_id':
                        $stmt->bindValue($identifier, $this->user_firebase_id, PDO::PARAM_STR);
                        break;
                    case 'campaign_name':
                        $stmt->bindValue($identifier, $this->campaign_name, PDO::PARAM_STR);
                        break;
                    case 'campaign_data':
                        if (is_resource($this->campaign_data)) {
                            rewind($this->campaign_data);
                        }
                        $stmt->bindValue($identifier, $this->campaign_data, PDO::PARAM_LOB);
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
        $this->setCampaignId($pk);

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
        $pos = CampaignsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCampaignId();
                break;
            case 1:
                return $this->getUserFirebaseId();
                break;
            case 2:
                return $this->getCampaignName();
                break;
            case 3:
                return $this->getCampaignData();
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

        if (isset($alreadyDumpedObjects['Campaigns'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Campaigns'][$this->hashCode()] = true;
        $keys = CampaignsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCampaignId(),
            $keys[1] => $this->getUserFirebaseId(),
            $keys[2] => $this->getCampaignName(),
            $keys[3] => $this->getCampaignData(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'Users';
                }

                $result[$key] = $this->aUsers->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBattless) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'battless';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'battless';
                        break;
                    default:
                        $key = 'Battless';
                }

                $result[$key] = $this->collBattless->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCharacterss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'characterss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'characterss';
                        break;
                    default:
                        $key = 'Characterss';
                }

                $result[$key] = $this->collCharacterss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Propel\PtuToolkit\Campaigns
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CampaignsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\PtuToolkit\Campaigns
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCampaignId($value);
                break;
            case 1:
                $this->setUserFirebaseId($value);
                break;
            case 2:
                $this->setCampaignName($value);
                break;
            case 3:
                $this->setCampaignData($value);
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
        $keys = CampaignsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setCampaignId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserFirebaseId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCampaignName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCampaignData($arr[$keys[3]]);
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
     * @return $this|\Propel\PtuToolkit\Campaigns The current object, for fluid interface
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
        $criteria = new Criteria(CampaignsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_ID)) {
            $criteria->add(CampaignsTableMap::COL_CAMPAIGN_ID, $this->campaign_id);
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_USER_FIREBASE_ID)) {
            $criteria->add(CampaignsTableMap::COL_USER_FIREBASE_ID, $this->user_firebase_id);
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_NAME)) {
            $criteria->add(CampaignsTableMap::COL_CAMPAIGN_NAME, $this->campaign_name);
        }
        if ($this->isColumnModified(CampaignsTableMap::COL_CAMPAIGN_DATA)) {
            $criteria->add(CampaignsTableMap::COL_CAMPAIGN_DATA, $this->campaign_data);
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
        $criteria = ChildCampaignsQuery::create();
        $criteria->add(CampaignsTableMap::COL_CAMPAIGN_ID, $this->campaign_id);

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
        $validPk = null !== $this->getCampaignId();

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
        return $this->getCampaignId();
    }

    /**
     * Generic method to set the primary key (campaign_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCampaignId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getCampaignId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Propel\PtuToolkit\Campaigns (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserFirebaseId($this->getUserFirebaseId());
        $copyObj->setCampaignName($this->getCampaignName());
        $copyObj->setCampaignData($this->getCampaignData());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getBattless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBattles($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCharacterss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCharacters($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCampaignId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Propel\PtuToolkit\Campaigns Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUsers(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setUserFirebaseId(NULL);
        } else {
            $this->setUserFirebaseId($v->getFirebaseId());
        }

        $this->aUsers = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addCampaigns($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUsers(ConnectionInterface $con = null)
    {
        if ($this->aUsers === null && (($this->user_firebase_id !== "" && $this->user_firebase_id !== null))) {
            $this->aUsers = ChildUsersQuery::create()->findPk($this->user_firebase_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUsers->addCampaignss($this);
             */
        }

        return $this->aUsers;
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
        if ('Battles' == $relationName) {
            $this->initBattless();
            return;
        }
        if ('Characters' == $relationName) {
            $this->initCharacterss();
            return;
        }
    }

    /**
     * Clears out the collBattless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBattless()
     */
    public function clearBattless()
    {
        $this->collBattless = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collBattless collection loaded partially.
     */
    public function resetPartialBattless($v = true)
    {
        $this->collBattlessPartial = $v;
    }

    /**
     * Initializes the collBattless collection.
     *
     * By default this just sets the collBattless collection to an empty array (like clearcollBattless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBattless($overrideExisting = true)
    {
        if (null !== $this->collBattless && !$overrideExisting) {
            return;
        }

        $collectionClassName = BattlesTableMap::getTableMap()->getCollectionClassName();

        $this->collBattless = new $collectionClassName;
        $this->collBattless->setModel('\Propel\PtuToolkit\Battles');
    }

    /**
     * Gets an array of ChildBattles objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCampaigns is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBattles[] List of ChildBattles objects
     * @throws PropelException
     */
    public function getBattless(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBattlessPartial && !$this->isNew();
        if (null === $this->collBattless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBattless) {
                // return empty collection
                $this->initBattless();
            } else {
                $collBattless = ChildBattlesQuery::create(null, $criteria)
                    ->filterByCampaigns($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBattlessPartial && count($collBattless)) {
                        $this->initBattless(false);

                        foreach ($collBattless as $obj) {
                            if (false == $this->collBattless->contains($obj)) {
                                $this->collBattless->append($obj);
                            }
                        }

                        $this->collBattlessPartial = true;
                    }

                    return $collBattless;
                }

                if ($partial && $this->collBattless) {
                    foreach ($this->collBattless as $obj) {
                        if ($obj->isNew()) {
                            $collBattless[] = $obj;
                        }
                    }
                }

                $this->collBattless = $collBattless;
                $this->collBattlessPartial = false;
            }
        }

        return $this->collBattless;
    }

    /**
     * Sets a collection of ChildBattles objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $battless A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCampaigns The current object (for fluent API support)
     */
    public function setBattless(Collection $battless, ConnectionInterface $con = null)
    {
        /** @var ChildBattles[] $battlessToDelete */
        $battlessToDelete = $this->getBattless(new Criteria(), $con)->diff($battless);


        $this->battlessScheduledForDeletion = $battlessToDelete;

        foreach ($battlessToDelete as $battlesRemoved) {
            $battlesRemoved->setCampaigns(null);
        }

        $this->collBattless = null;
        foreach ($battless as $battles) {
            $this->addBattles($battles);
        }

        $this->collBattless = $battless;
        $this->collBattlessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Battles objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Battles objects.
     * @throws PropelException
     */
    public function countBattless(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBattlessPartial && !$this->isNew();
        if (null === $this->collBattless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBattless) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBattless());
            }

            $query = ChildBattlesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCampaigns($this)
                ->count($con);
        }

        return count($this->collBattless);
    }

    /**
     * Method called to associate a ChildBattles object to this object
     * through the ChildBattles foreign key attribute.
     *
     * @param  ChildBattles $l ChildBattles
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function addBattles(ChildBattles $l)
    {
        if ($this->collBattless === null) {
            $this->initBattless();
            $this->collBattlessPartial = true;
        }

        if (!$this->collBattless->contains($l)) {
            $this->doAddBattles($l);

            if ($this->battlessScheduledForDeletion and $this->battlessScheduledForDeletion->contains($l)) {
                $this->battlessScheduledForDeletion->remove($this->battlessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBattles $battles The ChildBattles object to add.
     */
    protected function doAddBattles(ChildBattles $battles)
    {
        $this->collBattless[]= $battles;
        $battles->setCampaigns($this);
    }

    /**
     * @param  ChildBattles $battles The ChildBattles object to remove.
     * @return $this|ChildCampaigns The current object (for fluent API support)
     */
    public function removeBattles(ChildBattles $battles)
    {
        if ($this->getBattless()->contains($battles)) {
            $pos = $this->collBattless->search($battles);
            $this->collBattless->remove($pos);
            if (null === $this->battlessScheduledForDeletion) {
                $this->battlessScheduledForDeletion = clone $this->collBattless;
                $this->battlessScheduledForDeletion->clear();
            }
            $this->battlessScheduledForDeletion[]= clone $battles;
            $battles->setCampaigns(null);
        }

        return $this;
    }

    /**
     * Clears out the collCharacterss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCharacterss()
     */
    public function clearCharacterss()
    {
        $this->collCharacterss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCharacterss collection loaded partially.
     */
    public function resetPartialCharacterss($v = true)
    {
        $this->collCharacterssPartial = $v;
    }

    /**
     * Initializes the collCharacterss collection.
     *
     * By default this just sets the collCharacterss collection to an empty array (like clearcollCharacterss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCharacterss($overrideExisting = true)
    {
        if (null !== $this->collCharacterss && !$overrideExisting) {
            return;
        }

        $collectionClassName = CharactersTableMap::getTableMap()->getCollectionClassName();

        $this->collCharacterss = new $collectionClassName;
        $this->collCharacterss->setModel('\Propel\PtuToolkit\Characters');
    }

    /**
     * Gets an array of ChildCharacters objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCampaigns is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCharacters[] List of ChildCharacters objects
     * @throws PropelException
     */
    public function getCharacterss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterssPartial && !$this->isNew();
        if (null === $this->collCharacterss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCharacterss) {
                // return empty collection
                $this->initCharacterss();
            } else {
                $collCharacterss = ChildCharactersQuery::create(null, $criteria)
                    ->filterByCampaigns($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCharacterssPartial && count($collCharacterss)) {
                        $this->initCharacterss(false);

                        foreach ($collCharacterss as $obj) {
                            if (false == $this->collCharacterss->contains($obj)) {
                                $this->collCharacterss->append($obj);
                            }
                        }

                        $this->collCharacterssPartial = true;
                    }

                    return $collCharacterss;
                }

                if ($partial && $this->collCharacterss) {
                    foreach ($this->collCharacterss as $obj) {
                        if ($obj->isNew()) {
                            $collCharacterss[] = $obj;
                        }
                    }
                }

                $this->collCharacterss = $collCharacterss;
                $this->collCharacterssPartial = false;
            }
        }

        return $this->collCharacterss;
    }

    /**
     * Sets a collection of ChildCharacters objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $characterss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCampaigns The current object (for fluent API support)
     */
    public function setCharacterss(Collection $characterss, ConnectionInterface $con = null)
    {
        /** @var ChildCharacters[] $characterssToDelete */
        $characterssToDelete = $this->getCharacterss(new Criteria(), $con)->diff($characterss);


        $this->characterssScheduledForDeletion = $characterssToDelete;

        foreach ($characterssToDelete as $charactersRemoved) {
            $charactersRemoved->setCampaigns(null);
        }

        $this->collCharacterss = null;
        foreach ($characterss as $characters) {
            $this->addCharacters($characters);
        }

        $this->collCharacterss = $characterss;
        $this->collCharacterssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Characters objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Characters objects.
     * @throws PropelException
     */
    public function countCharacterss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCharacterssPartial && !$this->isNew();
        if (null === $this->collCharacterss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCharacterss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCharacterss());
            }

            $query = ChildCharactersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCampaigns($this)
                ->count($con);
        }

        return count($this->collCharacterss);
    }

    /**
     * Method called to associate a ChildCharacters object to this object
     * through the ChildCharacters foreign key attribute.
     *
     * @param  ChildCharacters $l ChildCharacters
     * @return $this|\Propel\PtuToolkit\Campaigns The current object (for fluent API support)
     */
    public function addCharacters(ChildCharacters $l)
    {
        if ($this->collCharacterss === null) {
            $this->initCharacterss();
            $this->collCharacterssPartial = true;
        }

        if (!$this->collCharacterss->contains($l)) {
            $this->doAddCharacters($l);

            if ($this->characterssScheduledForDeletion and $this->characterssScheduledForDeletion->contains($l)) {
                $this->characterssScheduledForDeletion->remove($this->characterssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCharacters $characters The ChildCharacters object to add.
     */
    protected function doAddCharacters(ChildCharacters $characters)
    {
        $this->collCharacterss[]= $characters;
        $characters->setCampaigns($this);
    }

    /**
     * @param  ChildCharacters $characters The ChildCharacters object to remove.
     * @return $this|ChildCampaigns The current object (for fluent API support)
     */
    public function removeCharacters(ChildCharacters $characters)
    {
        if ($this->getCharacterss()->contains($characters)) {
            $pos = $this->collCharacterss->search($characters);
            $this->collCharacterss->remove($pos);
            if (null === $this->characterssScheduledForDeletion) {
                $this->characterssScheduledForDeletion = clone $this->collCharacterss;
                $this->characterssScheduledForDeletion->clear();
            }
            $this->characterssScheduledForDeletion[]= clone $characters;
            $characters->setCampaigns(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUsers) {
            $this->aUsers->removeCampaigns($this);
        }
        $this->campaign_id = null;
        $this->user_firebase_id = null;
        $this->campaign_name = null;
        $this->campaign_data = null;
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
            if ($this->collBattless) {
                foreach ($this->collBattless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCharacterss) {
                foreach ($this->collCharacterss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collBattless = null;
        $this->collCharacterss = null;
        $this->aUsers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CampaignsTableMap::DEFAULT_STRING_FORMAT);
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
