<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\DataPokedex as ChildDataPokedex;
use Propel\PtuToolkit\DataPokedexQuery as ChildDataPokedexQuery;
use Propel\PtuToolkit\Map\DataPokedexTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'data_pokedex' table.
 *
 *
 *
 * @method     ChildDataPokedexQuery orderByPokedexId($order = Criteria::ASC) Order by the pokedex_id column
 * @method     ChildDataPokedexQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildDataPokedexQuery groupByPokedexId() Group by the pokedex_id column
 * @method     ChildDataPokedexQuery groupByName() Group by the name column
 *
 * @method     ChildDataPokedexQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDataPokedexQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDataPokedexQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDataPokedexQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDataPokedexQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDataPokedexQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDataPokedexQuery leftJoinDataPokedexEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the DataPokedexEntry relation
 * @method     ChildDataPokedexQuery rightJoinDataPokedexEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DataPokedexEntry relation
 * @method     ChildDataPokedexQuery innerJoinDataPokedexEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the DataPokedexEntry relation
 *
 * @method     ChildDataPokedexQuery joinWithDataPokedexEntry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DataPokedexEntry relation
 *
 * @method     ChildDataPokedexQuery leftJoinWithDataPokedexEntry() Adds a LEFT JOIN clause and with to the query using the DataPokedexEntry relation
 * @method     ChildDataPokedexQuery rightJoinWithDataPokedexEntry() Adds a RIGHT JOIN clause and with to the query using the DataPokedexEntry relation
 * @method     ChildDataPokedexQuery innerJoinWithDataPokedexEntry() Adds a INNER JOIN clause and with to the query using the DataPokedexEntry relation
 *
 * @method     \Propel\PtuToolkit\DataPokedexEntryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDataPokedex findOne(ConnectionInterface $con = null) Return the first ChildDataPokedex matching the query
 * @method     ChildDataPokedex findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDataPokedex matching the query, or a new ChildDataPokedex object populated from the query conditions when no match is found
 *
 * @method     ChildDataPokedex findOneByPokedexId(int $pokedex_id) Return the first ChildDataPokedex filtered by the pokedex_id column
 * @method     ChildDataPokedex findOneByName(string $name) Return the first ChildDataPokedex filtered by the name column *

 * @method     ChildDataPokedex requirePk($key, ConnectionInterface $con = null) Return the ChildDataPokedex by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDataPokedex requireOne(ConnectionInterface $con = null) Return the first ChildDataPokedex matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDataPokedex requireOneByPokedexId(int $pokedex_id) Return the first ChildDataPokedex filtered by the pokedex_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDataPokedex requireOneByName(string $name) Return the first ChildDataPokedex filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDataPokedex[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDataPokedex objects based on current ModelCriteria
 * @method     ChildDataPokedex[]|ObjectCollection findByPokedexId(int $pokedex_id) Return ChildDataPokedex objects filtered by the pokedex_id column
 * @method     ChildDataPokedex[]|ObjectCollection findByName(string $name) Return ChildDataPokedex objects filtered by the name column
 * @method     ChildDataPokedex[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DataPokedexQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\DataPokedexQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\DataPokedex', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDataPokedexQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDataPokedexQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDataPokedexQuery) {
            return $criteria;
        }
        $query = new ChildDataPokedexQuery();
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
     * @return ChildDataPokedex|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DataPokedexTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DataPokedexTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDataPokedex A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT pokedex_id, name FROM data_pokedex WHERE pokedex_id = :p0';
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
            /** @var ChildDataPokedex $obj */
            $obj = new ChildDataPokedex();
            $obj->hydrate($row);
            DataPokedexTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDataPokedex|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function filterByPokedexId($pokedexId = null, $comparison = null)
    {
        if (is_array($pokedexId)) {
            $useMinMax = false;
            if (isset($pokedexId['min'])) {
                $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $pokedexId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexId['max'])) {
                $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $pokedexId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $pokedexId, $comparison);
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
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataPokedexTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\DataPokedexEntry object
     *
     * @param \Propel\PtuToolkit\DataPokedexEntry|ObjectCollection $dataPokedexEntry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataPokedexQuery The current query, for fluid interface
     */
    public function filterByDataPokedexEntry($dataPokedexEntry, $comparison = null)
    {
        if ($dataPokedexEntry instanceof \Propel\PtuToolkit\DataPokedexEntry) {
            return $this
                ->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $dataPokedexEntry->getPokedexId(), $comparison);
        } elseif ($dataPokedexEntry instanceof ObjectCollection) {
            return $this
                ->useDataPokedexEntryQuery()
                ->filterByPrimaryKeys($dataPokedexEntry->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDataPokedexEntry() only accepts arguments of type \Propel\PtuToolkit\DataPokedexEntry or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DataPokedexEntry relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function joinDataPokedexEntry($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DataPokedexEntry');

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
            $this->addJoinObject($join, 'DataPokedexEntry');
        }

        return $this;
    }

    /**
     * Use the DataPokedexEntry relation DataPokedexEntry object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\DataPokedexEntryQuery A secondary query class using the current class as primary query
     */
    public function useDataPokedexEntryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDataPokedexEntry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DataPokedexEntry', '\Propel\PtuToolkit\DataPokedexEntryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDataPokedex $dataPokedex Object to remove from the list of results
     *
     * @return $this|ChildDataPokedexQuery The current query, for fluid interface
     */
    public function prune($dataPokedex = null)
    {
        if ($dataPokedex) {
            $this->addUsingAlias(DataPokedexTableMap::COL_POKEDEX_ID, $dataPokedex->getPokedexId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the data_pokedex table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DataPokedexTableMap::clearInstancePool();
            DataPokedexTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DataPokedexTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DataPokedexTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DataPokedexTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DataPokedexTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DataPokedexQuery
