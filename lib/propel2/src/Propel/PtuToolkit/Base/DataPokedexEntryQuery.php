<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\DataPokedexEntry as ChildDataPokedexEntry;
use Propel\PtuToolkit\DataPokedexEntryQuery as ChildDataPokedexEntryQuery;
use Propel\PtuToolkit\Map\DataPokedexEntryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'data_pokedex_entry' table.
 *
 *
 *
 * @method     ChildDataPokedexEntryQuery orderByPokedexNo($order = Criteria::ASC) Order by the pokedex_no column
 * @method     ChildDataPokedexEntryQuery orderByPokedexId($order = Criteria::ASC) Order by the pokedex_id column
 * @method     ChildDataPokedexEntryQuery orderByData($order = Criteria::ASC) Order by the data column
 *
 * @method     ChildDataPokedexEntryQuery groupByPokedexNo() Group by the pokedex_no column
 * @method     ChildDataPokedexEntryQuery groupByPokedexId() Group by the pokedex_id column
 * @method     ChildDataPokedexEntryQuery groupByData() Group by the data column
 *
 * @method     ChildDataPokedexEntryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDataPokedexEntryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDataPokedexEntryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDataPokedexEntryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDataPokedexEntryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDataPokedexEntryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDataPokedexEntryQuery leftJoinDataPokedex($relationAlias = null) Adds a LEFT JOIN clause to the query using the DataPokedex relation
 * @method     ChildDataPokedexEntryQuery rightJoinDataPokedex($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DataPokedex relation
 * @method     ChildDataPokedexEntryQuery innerJoinDataPokedex($relationAlias = null) Adds a INNER JOIN clause to the query using the DataPokedex relation
 *
 * @method     ChildDataPokedexEntryQuery joinWithDataPokedex($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DataPokedex relation
 *
 * @method     ChildDataPokedexEntryQuery leftJoinWithDataPokedex() Adds a LEFT JOIN clause and with to the query using the DataPokedex relation
 * @method     ChildDataPokedexEntryQuery rightJoinWithDataPokedex() Adds a RIGHT JOIN clause and with to the query using the DataPokedex relation
 * @method     ChildDataPokedexEntryQuery innerJoinWithDataPokedex() Adds a INNER JOIN clause and with to the query using the DataPokedex relation
 *
 * @method     ChildDataPokedexEntryQuery leftJoinPokedexMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the PokedexMoves relation
 * @method     ChildDataPokedexEntryQuery rightJoinPokedexMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PokedexMoves relation
 * @method     ChildDataPokedexEntryQuery innerJoinPokedexMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the PokedexMoves relation
 *
 * @method     ChildDataPokedexEntryQuery joinWithPokedexMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PokedexMoves relation
 *
 * @method     ChildDataPokedexEntryQuery leftJoinWithPokedexMoves() Adds a LEFT JOIN clause and with to the query using the PokedexMoves relation
 * @method     ChildDataPokedexEntryQuery rightJoinWithPokedexMoves() Adds a RIGHT JOIN clause and with to the query using the PokedexMoves relation
 * @method     ChildDataPokedexEntryQuery innerJoinWithPokedexMoves() Adds a INNER JOIN clause and with to the query using the PokedexMoves relation
 *
 * @method     \Propel\PtuToolkit\DataPokedexQuery|\Propel\PtuToolkit\PokedexMovesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDataPokedexEntry findOne(ConnectionInterface $con = null) Return the first ChildDataPokedexEntry matching the query
 * @method     ChildDataPokedexEntry findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDataPokedexEntry matching the query, or a new ChildDataPokedexEntry object populated from the query conditions when no match is found
 *
 * @method     ChildDataPokedexEntry findOneByPokedexNo(string $pokedex_no) Return the first ChildDataPokedexEntry filtered by the pokedex_no column
 * @method     ChildDataPokedexEntry findOneByPokedexId(int $pokedex_id) Return the first ChildDataPokedexEntry filtered by the pokedex_id column
 * @method     ChildDataPokedexEntry findOneByData(string $data) Return the first ChildDataPokedexEntry filtered by the data column *

 * @method     ChildDataPokedexEntry requirePk($key, ConnectionInterface $con = null) Return the ChildDataPokedexEntry by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDataPokedexEntry requireOne(ConnectionInterface $con = null) Return the first ChildDataPokedexEntry matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDataPokedexEntry requireOneByPokedexNo(string $pokedex_no) Return the first ChildDataPokedexEntry filtered by the pokedex_no column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDataPokedexEntry requireOneByPokedexId(int $pokedex_id) Return the first ChildDataPokedexEntry filtered by the pokedex_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDataPokedexEntry requireOneByData(string $data) Return the first ChildDataPokedexEntry filtered by the data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDataPokedexEntry[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDataPokedexEntry objects based on current ModelCriteria
 * @method     ChildDataPokedexEntry[]|ObjectCollection findByPokedexNo(string $pokedex_no) Return ChildDataPokedexEntry objects filtered by the pokedex_no column
 * @method     ChildDataPokedexEntry[]|ObjectCollection findByPokedexId(int $pokedex_id) Return ChildDataPokedexEntry objects filtered by the pokedex_id column
 * @method     ChildDataPokedexEntry[]|ObjectCollection findByData(string $data) Return ChildDataPokedexEntry objects filtered by the data column
 * @method     ChildDataPokedexEntry[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DataPokedexEntryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\DataPokedexEntryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\DataPokedexEntry', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDataPokedexEntryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDataPokedexEntryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDataPokedexEntryQuery) {
            return $criteria;
        }
        $query = new ChildDataPokedexEntryQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$pokedex_no, $pokedex_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDataPokedexEntry|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DataPokedexEntryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DataPokedexEntryTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildDataPokedexEntry A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT pokedex_no, pokedex_id, data FROM data_pokedex_entry WHERE pokedex_no = :p0 AND pokedex_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDataPokedexEntry $obj */
            $obj = new ChildDataPokedexEntry();
            $obj->hydrate($row);
            DataPokedexEntryTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildDataPokedexEntry|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_NO, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(DataPokedexEntryTableMap::COL_POKEDEX_NO, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(DataPokedexEntryTableMap::COL_POKEDEX_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByPokedexNo($pokedexNo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pokedexNo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_NO, $pokedexNo, $comparison);
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
     * @see       filterByDataPokedex()
     *
     * @param     mixed $pokedexId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByPokedexId($pokedexId = null, $comparison = null)
    {
        if (is_array($pokedexId)) {
            $useMinMax = false;
            if (isset($pokedexId['min'])) {
                $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $pokedexId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexId['max'])) {
                $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $pokedexId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $pokedexId, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * @param     mixed $data The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {

        return $this->addUsingAlias(DataPokedexEntryTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\DataPokedex object
     *
     * @param \Propel\PtuToolkit\DataPokedex|ObjectCollection $dataPokedex The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByDataPokedex($dataPokedex, $comparison = null)
    {
        if ($dataPokedex instanceof \Propel\PtuToolkit\DataPokedex) {
            return $this
                ->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $dataPokedex->getPokedexId(), $comparison);
        } elseif ($dataPokedex instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $dataPokedex->toKeyValue('PrimaryKey', 'PokedexId'), $comparison);
        } else {
            throw new PropelException('filterByDataPokedex() only accepts arguments of type \Propel\PtuToolkit\DataPokedex or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DataPokedex relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function joinDataPokedex($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DataPokedex');

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
            $this->addJoinObject($join, 'DataPokedex');
        }

        return $this;
    }

    /**
     * Use the DataPokedex relation DataPokedex object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\DataPokedexQuery A secondary query class using the current class as primary query
     */
    public function useDataPokedexQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDataPokedex($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DataPokedex', '\Propel\PtuToolkit\DataPokedexQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\PokedexMoves object
     *
     * @param \Propel\PtuToolkit\PokedexMoves|ObjectCollection $pokedexMoves the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function filterByPokedexMoves($pokedexMoves, $comparison = null)
    {
        if ($pokedexMoves instanceof \Propel\PtuToolkit\PokedexMoves) {
            return $this
                ->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_ID, $pokedexMoves->getPokedexId(), $comparison)
                ->addUsingAlias(DataPokedexEntryTableMap::COL_POKEDEX_NO, $pokedexMoves->getPokedexNo(), $comparison);
        } else {
            throw new PropelException('filterByPokedexMoves() only accepts arguments of type \Propel\PtuToolkit\PokedexMoves');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PokedexMoves relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function joinPokedexMoves($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PokedexMoves');

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
            $this->addJoinObject($join, 'PokedexMoves');
        }

        return $this;
    }

    /**
     * Use the PokedexMoves relation PokedexMoves object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\PokedexMovesQuery A secondary query class using the current class as primary query
     */
    public function usePokedexMovesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPokedexMoves($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PokedexMoves', '\Propel\PtuToolkit\PokedexMovesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDataPokedexEntry $dataPokedexEntry Object to remove from the list of results
     *
     * @return $this|ChildDataPokedexEntryQuery The current query, for fluid interface
     */
    public function prune($dataPokedexEntry = null)
    {
        if ($dataPokedexEntry) {
            $this->addCond('pruneCond0', $this->getAliasedColName(DataPokedexEntryTableMap::COL_POKEDEX_NO), $dataPokedexEntry->getPokedexNo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(DataPokedexEntryTableMap::COL_POKEDEX_ID), $dataPokedexEntry->getPokedexId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the data_pokedex_entry table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexEntryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DataPokedexEntryTableMap::clearInstancePool();
            DataPokedexEntryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexEntryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DataPokedexEntryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DataPokedexEntryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DataPokedexEntryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DataPokedexEntryQuery
