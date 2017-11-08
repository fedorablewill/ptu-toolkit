<?php

namespace Propel\PtuToolkit\Map;

use Propel\PtuToolkit\DataPokedexEntry;
use Propel\PtuToolkit\DataPokedexEntryQuery;
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
 * This class defines the structure of the 'data_pokedex_entry' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DataPokedexEntryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.PtuToolkit.Map.DataPokedexEntryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'data_pokedex_entry';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\PtuToolkit\\DataPokedexEntry';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.PtuToolkit.DataPokedexEntry';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the pokedex_no field
     */
    const COL_POKEDEX_NO = 'data_pokedex_entry.pokedex_no';

    /**
     * the column name for the pokedex_id field
     */
    const COL_POKEDEX_ID = 'data_pokedex_entry.pokedex_id';

    /**
     * the column name for the data field
     */
    const COL_DATA = 'data_pokedex_entry.data';

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
        self::TYPE_PHPNAME       => array('PokedexNo', 'PokedexId', 'Data', ),
        self::TYPE_CAMELNAME     => array('pokedexNo', 'pokedexId', 'data', ),
        self::TYPE_COLNAME       => array(DataPokedexEntryTableMap::COL_POKEDEX_NO, DataPokedexEntryTableMap::COL_POKEDEX_ID, DataPokedexEntryTableMap::COL_DATA, ),
        self::TYPE_FIELDNAME     => array('pokedex_no', 'pokedex_id', 'data', ),
        self::TYPE_NUM           => array(0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PokedexNo' => 0, 'PokedexId' => 1, 'Data' => 2, ),
        self::TYPE_CAMELNAME     => array('pokedexNo' => 0, 'pokedexId' => 1, 'data' => 2, ),
        self::TYPE_COLNAME       => array(DataPokedexEntryTableMap::COL_POKEDEX_NO => 0, DataPokedexEntryTableMap::COL_POKEDEX_ID => 1, DataPokedexEntryTableMap::COL_DATA => 2, ),
        self::TYPE_FIELDNAME     => array('pokedex_no' => 0, 'pokedex_id' => 1, 'data' => 2, ),
        self::TYPE_NUM           => array(0, 1, 2, )
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
        $this->setName('data_pokedex_entry');
        $this->setPhpName('DataPokedexEntry');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\PtuToolkit\\DataPokedexEntry');
        $this->setPackage('Propel.PtuToolkit');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('pokedex_no', 'PokedexNo', 'VARCHAR', true, 8, null);
        $this->addForeignKey('pokedex_id', 'PokedexId', 'INTEGER', 'data_pokedex', 'pokedex_id', false, null, null);
        $this->addColumn('data', 'Data', 'LONGVARCHAR', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('DataPokedex', '\\Propel\\PtuToolkit\\DataPokedex', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':pokedex_id',
    1 => ':pokedex_id',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('PokedexNo', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? DataPokedexEntryTableMap::CLASS_DEFAULT : DataPokedexEntryTableMap::OM_CLASS;
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
     * @return array           (DataPokedexEntry object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DataPokedexEntryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DataPokedexEntryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DataPokedexEntryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DataPokedexEntryTableMap::OM_CLASS;
            /** @var DataPokedexEntry $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DataPokedexEntryTableMap::addInstanceToPool($obj, $key);
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
            $key = DataPokedexEntryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DataPokedexEntryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DataPokedexEntry $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DataPokedexEntryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DataPokedexEntryTableMap::COL_POKEDEX_NO);
            $criteria->addSelectColumn(DataPokedexEntryTableMap::COL_POKEDEX_ID);
            $criteria->addSelectColumn(DataPokedexEntryTableMap::COL_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.pokedex_no');
            $criteria->addSelectColumn($alias . '.pokedex_id');
            $criteria->addSelectColumn($alias . '.data');
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
        return Propel::getServiceContainer()->getDatabaseMap(DataPokedexEntryTableMap::DATABASE_NAME)->getTable(DataPokedexEntryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DataPokedexEntryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DataPokedexEntryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DataPokedexEntryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DataPokedexEntry or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DataPokedexEntry object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexEntryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\PtuToolkit\DataPokedexEntry) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DataPokedexEntryTableMap::DATABASE_NAME);
            $criteria->add(DataPokedexEntryTableMap::COL_POKEDEX_NO, (array) $values, Criteria::IN);
        }

        $query = DataPokedexEntryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DataPokedexEntryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DataPokedexEntryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the data_pokedex_entry table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DataPokedexEntryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DataPokedexEntry or Criteria object.
     *
     * @param mixed               $criteria Criteria or DataPokedexEntry object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexEntryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DataPokedexEntry object
        }


        // Set the correct dbName
        $query = DataPokedexEntryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DataPokedexEntryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DataPokedexEntryTableMap::buildTableMap();
