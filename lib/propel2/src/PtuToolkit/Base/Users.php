<?php

namespace PtuToolkit\Base;

use \Exception;
use \PDO;
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
use PtuToolkit\Campaigns as ChildCampaigns;
use PtuToolkit\CampaignsQuery as ChildCampaignsQuery;
use PtuToolkit\Sessions as ChildSessions;
use PtuToolkit\SessionsQuery as ChildSessionsQuery;
use PtuToolkit\Users as ChildUsers;
use PtuToolkit\UsersQuery as ChildUsersQuery;
use PtuToolkit\Map\CampaignsTableMap;
use PtuToolkit\Map\SessionsTableMap;
use PtuToolkit\Map\UsersTableMap;

/**
 * Base class that represents a row from the 'users' table.
 *
 *
 *
 * @package    propel.generator.PtuToolkit.Base
 */
abstract class Users implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PtuToolkit\\Map\\UsersTableMap';


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
     * The value for the firebase_id field.
     *
     * @var        string
     */
    protected $firebase_id;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the peer_id field.
     *
     * @var        string
     */
    protected $peer_id;

    /**
     * The value for the settings field.
     *
     * @var        string
     */
    protected $settings;

    /**
     * @var        ObjectCollection|ChildCampaigns[] Collection to store aggregation of ChildCampaigns objects.
     */
    protected $collCampaignss;
    protected $collCampaignssPartial;

    /**
     * @var        ObjectCollection|ChildSessions[] Collection to store aggregation of ChildSessions objects.
     */
    protected $collSessionss;
    protected $collSessionssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCampaigns[]
     */
    protected $campaignssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSessions[]
     */
    protected $sessionssScheduledForDeletion = null;

    /**
     * Initializes internal state of PtuToolkit\Base\Users object.
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
     * Compares this with another <code>Users</code> instance.  If
     * <code>obj</code> is an instance of <code>Users</code>, delegates to
     * <code>equals(Users)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Users The current object, for fluid interface
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
     * Get the [firebase_id] column value.
     *
     * @return string
     */
    public function getFirebaseId()
    {
        return $this->firebase_id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [peer_id] column value.
     *
     * @return string
     */
    public function getPeerId()
    {
        return $this->peer_id;
    }

    /**
     * Get the [settings] column value.
     *
     * @return string
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set the value of [firebase_id] column.
     *
     * @param string $v new value
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function setFirebaseId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firebase_id !== $v) {
            $this->firebase_id = $v;
            $this->modifiedColumns[UsersTableMap::COL_FIREBASE_ID] = true;
        }

        return $this;
    } // setFirebaseId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UsersTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [peer_id] column.
     *
     * @param string $v new value
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function setPeerId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->peer_id !== $v) {
            $this->peer_id = $v;
            $this->modifiedColumns[UsersTableMap::COL_PEER_ID] = true;
        }

        return $this;
    } // setPeerId()

    /**
     * Set the value of [settings] column.
     *
     * @param string $v new value
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function setSettings($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->settings = fopen('php://memory', 'r+');
            fwrite($this->settings, $v);
            rewind($this->settings);
        } else { // it's already a stream
            $this->settings = $v;
        }
        $this->modifiedColumns[UsersTableMap::COL_SETTINGS] = true;

        return $this;
    } // setSettings()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsersTableMap::translateFieldName('FirebaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firebase_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsersTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsersTableMap::translateFieldName('PeerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->peer_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsersTableMap::translateFieldName('Settings', TableMap::TYPE_PHPNAME, $indexType)];
            if (null !== $col) {
                $this->settings = fopen('php://memory', 'r+');
                fwrite($this->settings, $col);
                rewind($this->settings);
            } else {
                $this->settings = null;
            }
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = UsersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PtuToolkit\\Users'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCampaignss = null;

            $this->collSessionss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Users::setDeleted()
     * @see Users::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
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
                UsersTableMap::addInstanceToPool($this);
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

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                // Rewind the settings LOB column, since PDO does not rewind after inserting value.
                if ($this->settings !== null && is_resource($this->settings)) {
                    rewind($this->settings);
                }

                $this->resetModified();
            }

            if ($this->campaignssScheduledForDeletion !== null) {
                if (!$this->campaignssScheduledForDeletion->isEmpty()) {
                    \PtuToolkit\CampaignsQuery::create()
                        ->filterByPrimaryKeys($this->campaignssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->campaignssScheduledForDeletion = null;
                }
            }

            if ($this->collCampaignss !== null) {
                foreach ($this->collCampaignss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sessionssScheduledForDeletion !== null) {
                if (!$this->sessionssScheduledForDeletion->isEmpty()) {
                    \PtuToolkit\SessionsQuery::create()
                        ->filterByPrimaryKeys($this->sessionssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sessionssScheduledForDeletion = null;
                }
            }

            if ($this->collSessionss !== null) {
                foreach ($this->collSessionss as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsersTableMap::COL_FIREBASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'firebase_id';
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UsersTableMap::COL_PEER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'peer_id';
        }
        if ($this->isColumnModified(UsersTableMap::COL_SETTINGS)) {
            $modifiedColumns[':p' . $index++]  = 'settings';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'firebase_id':
                        $stmt->bindValue($identifier, $this->firebase_id, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'peer_id':
                        $stmt->bindValue($identifier, $this->peer_id, PDO::PARAM_STR);
                        break;
                    case 'settings':
                        if (is_resource($this->settings)) {
                            rewind($this->settings);
                        }
                        $stmt->bindValue($identifier, $this->settings, PDO::PARAM_LOB);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFirebaseId();
                break;
            case 1:
                return $this->getUsername();
                break;
            case 2:
                return $this->getPeerId();
                break;
            case 3:
                return $this->getSettings();
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

        if (isset($alreadyDumpedObjects['Users'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Users'][$this->hashCode()] = true;
        $keys = UsersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFirebaseId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPeerId(),
            $keys[3] => $this->getSettings(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCampaignss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'campaignss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'campaignss';
                        break;
                    default:
                        $key = 'Campaignss';
                }

                $result[$key] = $this->collCampaignss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSessionss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sessionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sessionss';
                        break;
                    default:
                        $key = 'Sessionss';
                }

                $result[$key] = $this->collSessionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\PtuToolkit\Users
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PtuToolkit\Users
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setFirebaseId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setPeerId($value);
                break;
            case 3:
                $this->setSettings($value);
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
        $keys = UsersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setFirebaseId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPeerId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSettings($arr[$keys[3]]);
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
     * @return $this|\PtuToolkit\Users The current object, for fluid interface
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
        $criteria = new Criteria(UsersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsersTableMap::COL_FIREBASE_ID)) {
            $criteria->add(UsersTableMap::COL_FIREBASE_ID, $this->firebase_id);
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $criteria->add(UsersTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UsersTableMap::COL_PEER_ID)) {
            $criteria->add(UsersTableMap::COL_PEER_ID, $this->peer_id);
        }
        if ($this->isColumnModified(UsersTableMap::COL_SETTINGS)) {
            $criteria->add(UsersTableMap::COL_SETTINGS, $this->settings);
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
        $criteria = ChildUsersQuery::create();
        $criteria->add(UsersTableMap::COL_FIREBASE_ID, $this->firebase_id);

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
        $validPk = null !== $this->getFirebaseId();

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getFirebaseId();
    }

    /**
     * Generic method to set the primary key (firebase_id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFirebaseId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getFirebaseId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PtuToolkit\Users (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirebaseId($this->getFirebaseId());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPeerId($this->getPeerId());
        $copyObj->setSettings($this->getSettings());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCampaignss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCampaigns($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSessionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSessions($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \PtuToolkit\Users Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Campaigns' == $relationName) {
            $this->initCampaignss();
            return;
        }
        if ('Sessions' == $relationName) {
            $this->initSessionss();
            return;
        }
    }

    /**
     * Clears out the collCampaignss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCampaignss()
     */
    public function clearCampaignss()
    {
        $this->collCampaignss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCampaignss collection loaded partially.
     */
    public function resetPartialCampaignss($v = true)
    {
        $this->collCampaignssPartial = $v;
    }

    /**
     * Initializes the collCampaignss collection.
     *
     * By default this just sets the collCampaignss collection to an empty array (like clearcollCampaignss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCampaignss($overrideExisting = true)
    {
        if (null !== $this->collCampaignss && !$overrideExisting) {
            return;
        }

        $collectionClassName = CampaignsTableMap::getTableMap()->getCollectionClassName();

        $this->collCampaignss = new $collectionClassName;
        $this->collCampaignss->setModel('\PtuToolkit\Campaigns');
    }

    /**
     * Gets an array of ChildCampaigns objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCampaigns[] List of ChildCampaigns objects
     * @throws PropelException
     */
    public function getCampaignss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCampaignssPartial && !$this->isNew();
        if (null === $this->collCampaignss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCampaignss) {
                // return empty collection
                $this->initCampaignss();
            } else {
                $collCampaignss = ChildCampaignsQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCampaignssPartial && count($collCampaignss)) {
                        $this->initCampaignss(false);

                        foreach ($collCampaignss as $obj) {
                            if (false == $this->collCampaignss->contains($obj)) {
                                $this->collCampaignss->append($obj);
                            }
                        }

                        $this->collCampaignssPartial = true;
                    }

                    return $collCampaignss;
                }

                if ($partial && $this->collCampaignss) {
                    foreach ($this->collCampaignss as $obj) {
                        if ($obj->isNew()) {
                            $collCampaignss[] = $obj;
                        }
                    }
                }

                $this->collCampaignss = $collCampaignss;
                $this->collCampaignssPartial = false;
            }
        }

        return $this->collCampaignss;
    }

    /**
     * Sets a collection of ChildCampaigns objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $campaignss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setCampaignss(Collection $campaignss, ConnectionInterface $con = null)
    {
        /** @var ChildCampaigns[] $campaignssToDelete */
        $campaignssToDelete = $this->getCampaignss(new Criteria(), $con)->diff($campaignss);


        $this->campaignssScheduledForDeletion = $campaignssToDelete;

        foreach ($campaignssToDelete as $campaignsRemoved) {
            $campaignsRemoved->setUsers(null);
        }

        $this->collCampaignss = null;
        foreach ($campaignss as $campaigns) {
            $this->addCampaigns($campaigns);
        }

        $this->collCampaignss = $campaignss;
        $this->collCampaignssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Campaigns objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Campaigns objects.
     * @throws PropelException
     */
    public function countCampaignss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCampaignssPartial && !$this->isNew();
        if (null === $this->collCampaignss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCampaignss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCampaignss());
            }

            $query = ChildCampaignsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collCampaignss);
    }

    /**
     * Method called to associate a ChildCampaigns object to this object
     * through the ChildCampaigns foreign key attribute.
     *
     * @param  ChildCampaigns $l ChildCampaigns
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function addCampaigns(ChildCampaigns $l)
    {
        if ($this->collCampaignss === null) {
            $this->initCampaignss();
            $this->collCampaignssPartial = true;
        }

        if (!$this->collCampaignss->contains($l)) {
            $this->doAddCampaigns($l);

            if ($this->campaignssScheduledForDeletion and $this->campaignssScheduledForDeletion->contains($l)) {
                $this->campaignssScheduledForDeletion->remove($this->campaignssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCampaigns $campaigns The ChildCampaigns object to add.
     */
    protected function doAddCampaigns(ChildCampaigns $campaigns)
    {
        $this->collCampaignss[]= $campaigns;
        $campaigns->setUsers($this);
    }

    /**
     * @param  ChildCampaigns $campaigns The ChildCampaigns object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeCampaigns(ChildCampaigns $campaigns)
    {
        if ($this->getCampaignss()->contains($campaigns)) {
            $pos = $this->collCampaignss->search($campaigns);
            $this->collCampaignss->remove($pos);
            if (null === $this->campaignssScheduledForDeletion) {
                $this->campaignssScheduledForDeletion = clone $this->collCampaignss;
                $this->campaignssScheduledForDeletion->clear();
            }
            $this->campaignssScheduledForDeletion[]= clone $campaigns;
            $campaigns->setUsers(null);
        }

        return $this;
    }

    /**
     * Clears out the collSessionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSessionss()
     */
    public function clearSessionss()
    {
        $this->collSessionss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSessionss collection loaded partially.
     */
    public function resetPartialSessionss($v = true)
    {
        $this->collSessionssPartial = $v;
    }

    /**
     * Initializes the collSessionss collection.
     *
     * By default this just sets the collSessionss collection to an empty array (like clearcollSessionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSessionss($overrideExisting = true)
    {
        if (null !== $this->collSessionss && !$overrideExisting) {
            return;
        }

        $collectionClassName = SessionsTableMap::getTableMap()->getCollectionClassName();

        $this->collSessionss = new $collectionClassName;
        $this->collSessionss->setModel('\PtuToolkit\Sessions');
    }

    /**
     * Gets an array of ChildSessions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSessions[] List of ChildSessions objects
     * @throws PropelException
     */
    public function getSessionss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSessionssPartial && !$this->isNew();
        if (null === $this->collSessionss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSessionss) {
                // return empty collection
                $this->initSessionss();
            } else {
                $collSessionss = ChildSessionsQuery::create(null, $criteria)
                    ->filterByUsers($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSessionssPartial && count($collSessionss)) {
                        $this->initSessionss(false);

                        foreach ($collSessionss as $obj) {
                            if (false == $this->collSessionss->contains($obj)) {
                                $this->collSessionss->append($obj);
                            }
                        }

                        $this->collSessionssPartial = true;
                    }

                    return $collSessionss;
                }

                if ($partial && $this->collSessionss) {
                    foreach ($this->collSessionss as $obj) {
                        if ($obj->isNew()) {
                            $collSessionss[] = $obj;
                        }
                    }
                }

                $this->collSessionss = $collSessionss;
                $this->collSessionssPartial = false;
            }
        }

        return $this->collSessionss;
    }

    /**
     * Sets a collection of ChildSessions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sessionss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setSessionss(Collection $sessionss, ConnectionInterface $con = null)
    {
        /** @var ChildSessions[] $sessionssToDelete */
        $sessionssToDelete = $this->getSessionss(new Criteria(), $con)->diff($sessionss);


        $this->sessionssScheduledForDeletion = $sessionssToDelete;

        foreach ($sessionssToDelete as $sessionsRemoved) {
            $sessionsRemoved->setUsers(null);
        }

        $this->collSessionss = null;
        foreach ($sessionss as $sessions) {
            $this->addSessions($sessions);
        }

        $this->collSessionss = $sessionss;
        $this->collSessionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Sessions objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Sessions objects.
     * @throws PropelException
     */
    public function countSessionss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSessionssPartial && !$this->isNew();
        if (null === $this->collSessionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSessionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSessionss());
            }

            $query = ChildSessionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collSessionss);
    }

    /**
     * Method called to associate a ChildSessions object to this object
     * through the ChildSessions foreign key attribute.
     *
     * @param  ChildSessions $l ChildSessions
     * @return $this|\PtuToolkit\Users The current object (for fluent API support)
     */
    public function addSessions(ChildSessions $l)
    {
        if ($this->collSessionss === null) {
            $this->initSessionss();
            $this->collSessionssPartial = true;
        }

        if (!$this->collSessionss->contains($l)) {
            $this->doAddSessions($l);

            if ($this->sessionssScheduledForDeletion and $this->sessionssScheduledForDeletion->contains($l)) {
                $this->sessionssScheduledForDeletion->remove($this->sessionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSessions $sessions The ChildSessions object to add.
     */
    protected function doAddSessions(ChildSessions $sessions)
    {
        $this->collSessionss[]= $sessions;
        $sessions->setUsers($this);
    }

    /**
     * @param  ChildSessions $sessions The ChildSessions object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeSessions(ChildSessions $sessions)
    {
        if ($this->getSessionss()->contains($sessions)) {
            $pos = $this->collSessionss->search($sessions);
            $this->collSessionss->remove($pos);
            if (null === $this->sessionssScheduledForDeletion) {
                $this->sessionssScheduledForDeletion = clone $this->collSessionss;
                $this->sessionssScheduledForDeletion->clear();
            }
            $this->sessionssScheduledForDeletion[]= clone $sessions;
            $sessions->setUsers(null);
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
        $this->firebase_id = null;
        $this->username = null;
        $this->peer_id = null;
        $this->settings = null;
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
            if ($this->collCampaignss) {
                foreach ($this->collCampaignss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSessionss) {
                foreach ($this->collSessionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCampaignss = null;
        $this->collSessionss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsersTableMap::DEFAULT_STRING_FORMAT);
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
