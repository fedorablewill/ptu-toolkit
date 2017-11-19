<?php

namespace Propel\PtuToolkit\Map;

use Propel\PtuToolkit\PokedexMoves;
use Propel\PtuToolkit\PokedexMovesQuery;
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
 * This class defines the structure of the 'pokedex_moves' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PokedexMovesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.PtuToolkit.Map.PokedexMovesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'pokedex_moves';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\PtuToolkit\\PokedexMoves';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.PtuToolkit.PokedexMoves';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the pokedex_move_id field
     */
    const COL_POKEDEX_MOVE_ID = 'pokedex_moves.pokedex_move_id';

    /**
     * the column name for the pokedex_no field
     */
    const COL_POKEDEX_NO = 'pokedex_moves.pokedex_no';

    /**
     * the column name for the pokedex_id field
     */
    const COL_POKEDEX_ID = 'pokedex_moves.pokedex_id';

    /**
     * the column name for the move_id field
     */
    const COL_MOVE_ID = 'pokedex_moves.move_id';

    /**
     * the column name for the level_learned field
     */
    const COL_LEVEL_LEARNED = 'pokedex_moves.level_learned';

    /**
     * the column name for the tm_id field
     */
    const COL_TM_ID = 'pokedex_moves.tm_id';

    /**
     * the column name for the is_natural field
     */
    const COL_IS_NATURAL = 'pokedex_moves.is_natural';

    /**
     * the column name for the is_egg_move field
     */
    const COL_IS_EGG_MOVE = 'pokedex_moves.is_egg_move';

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
        self::TYPE_PHPNAME       => array('PokedexMoveId', 'PokedexNo', 'PokedexId', 'MoveId', 'LevelLearned', 'TechnicalMachineId', 'Natural', 'EggMove', ),
        self::TYPE_CAMELNAME     => array('pokedexMoveId', 'pokedexNo', 'pokedexId', 'moveId', 'levelLearned', 'technicalMachineId', 'natural', 'eggMove', ),
        self::TYPE_COLNAME       => array(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, PokedexMovesTableMap::COL_POKEDEX_NO, PokedexMovesTableMap::COL_POKEDEX_ID, PokedexMovesTableMap::COL_MOVE_ID, PokedexMovesTableMap::COL_LEVEL_LEARNED, PokedexMovesTableMap::COL_TM_ID, PokedexMovesTableMap::COL_IS_NATURAL, PokedexMovesTableMap::COL_IS_EGG_MOVE, ),
        self::TYPE_FIELDNAME     => array('pokedex_move_id', 'pokedex_no', 'pokedex_id', 'move_id', 'level_learned', 'tm_id', 'is_natural', 'is_egg_move', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PokedexMoveId' => 0, 'PokedexNo' => 1, 'PokedexId' => 2, 'MoveId' => 3, 'LevelLearned' => 4, 'TechnicalMachineId' => 5, 'Natural' => 6, 'EggMove' => 7, ),
        self::TYPE_CAMELNAME     => array('pokedexMoveId' => 0, 'pokedexNo' => 1, 'pokedexId' => 2, 'moveId' => 3, 'levelLearned' => 4, 'technicalMachineId' => 5, 'natural' => 6, 'eggMove' => 7, ),
        self::TYPE_COLNAME       => array(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID => 0, PokedexMovesTableMap::COL_POKEDEX_NO => 1, PokedexMovesTableMap::COL_POKEDEX_ID => 2, PokedexMovesTableMap::COL_MOVE_ID => 3, PokedexMovesTableMap::COL_LEVEL_LEARNED => 4, PokedexMovesTableMap::COL_TM_ID => 5, PokedexMovesTableMap::COL_IS_NATURAL => 6, PokedexMovesTableMap::COL_IS_EGG_MOVE => 7, ),
        self::TYPE_FIELDNAME     => array('pokedex_move_id' => 0, 'pokedex_no' => 1, 'pokedex_id' => 2, 'move_id' => 3, 'level_learned' => 4, 'tm_id' => 5, 'is_natural' => 6, 'is_egg_move' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('pokedex_moves');
        $this->setPhpName('PokedexMoves');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\PtuToolkit\\PokedexMoves');
        $this->setPackage('Propel.PtuToolkit');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('pokedex_move_id', 'PokedexMoveId', 'INTEGER', true, null, null);
        $this->addForeignKey('pokedex_no', 'PokedexNo', 'VARCHAR', 'data_pokedex_entry', 'pokedex_no', true, 8, null);
        $this->addForeignKey('pokedex_id', 'PokedexId', 'INTEGER', 'data_pokedex_entry', 'pokedex_id', true, null, null);
        $this->addForeignKey('move_id', 'MoveId', 'INTEGER', 'moves', 'move_id', true, null, null);
        $this->addColumn('level_learned', 'LevelLearned', 'INTEGER', false, null, null);
        $this->addColumn('tm_id', 'TechnicalMachineId', 'INTEGER', false, null, null);
        $this->addColumn('is_natural', 'Natural', 'BOOLEAN', false, 1, null);
        $this->addColumn('is_egg_move', 'EggMove', 'BOOLEAN', false, 1, false);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('DataPokedexEntry', '\\Propel\\PtuToolkit\\DataPokedexEntry', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':pokedex_id',
    1 => ':pokedex_id',
  ),
  1 =>
  array (
    0 => ':pokedex_no',
    1 => ':pokedex_no',
  ),
), null, null, null, false);
        $this->addRelation('Moves', '\\Propel\\PtuToolkit\\Moves', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':move_id',
    1 => ':move_id',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PokedexMoveId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PokedexMovesTableMap::CLASS_DEFAULT : PokedexMovesTableMap::OM_CLASS;
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
     * @return array           (PokedexMoves object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PokedexMovesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PokedexMovesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PokedexMovesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PokedexMovesTableMap::OM_CLASS;
            /** @var PokedexMoves $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PokedexMovesTableMap::addInstanceToPool($obj, $key);
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
            $key = PokedexMovesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PokedexMovesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PokedexMoves $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PokedexMovesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_POKEDEX_NO);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_POKEDEX_ID);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_MOVE_ID);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_LEVEL_LEARNED);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_TM_ID);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_IS_NATURAL);
            $criteria->addSelectColumn(PokedexMovesTableMap::COL_IS_EGG_MOVE);
        } else {
            $criteria->addSelectColumn($alias . '.pokedex_move_id');
            $criteria->addSelectColumn($alias . '.pokedex_no');
            $criteria->addSelectColumn($alias . '.pokedex_id');
            $criteria->addSelectColumn($alias . '.move_id');
            $criteria->addSelectColumn($alias . '.level_learned');
            $criteria->addSelectColumn($alias . '.tm_id');
            $criteria->addSelectColumn($alias . '.is_natural');
            $criteria->addSelectColumn($alias . '.is_egg_move');
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
        return Propel::getServiceContainer()->getDatabaseMap(PokedexMovesTableMap::DATABASE_NAME)->getTable(PokedexMovesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PokedexMovesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PokedexMovesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PokedexMovesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PokedexMoves or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PokedexMoves object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PokedexMovesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\PtuToolkit\PokedexMoves) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PokedexMovesTableMap::DATABASE_NAME);
            $criteria->add(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, (array) $values, Criteria::IN);
        }

        $query = PokedexMovesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PokedexMovesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PokedexMovesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the pokedex_moves table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PokedexMovesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PokedexMoves or Criteria object.
     *
     * @param mixed               $criteria Criteria or PokedexMoves object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PokedexMovesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PokedexMoves object
        }

        if ($criteria->containsKey(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID) && $criteria->keyContainsValue(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PokedexMovesTableMap::COL_POKEDEX_MOVE_ID.')');
        }


        // Set the correct dbName
        $query = PokedexMovesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PokedexMovesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PokedexMovesTableMap::buildTableMap();
