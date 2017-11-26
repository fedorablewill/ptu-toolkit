<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\BattleEntries as ChildBattleEntries;
use Propel\PtuToolkit\BattleEntriesQuery as ChildBattleEntriesQuery;
use Propel\PtuToolkit\Map\BattleEntriesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'battle_entries' table.
 *
 *
 *
 * @method     ChildBattleEntriesQuery orderByBattleEntryId($order = Criteria::ASC) Order by the battle_entry_id column
 * @method     ChildBattleEntriesQuery orderByBattleId($order = Criteria::ASC) Order by the battle_id column
 * @method     ChildBattleEntriesQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildBattleEntriesQuery orderByAfflictions($order = Criteria::ASC) Order by the afflictions column
 *
 * @method     ChildBattleEntriesQuery groupByBattleEntryId() Group by the battle_entry_id column
 * @method     ChildBattleEntriesQuery groupByBattleId() Group by the battle_id column
 * @method     ChildBattleEntriesQuery groupByCharacterId() Group by the character_id column
 * @method     ChildBattleEntriesQuery groupByAfflictions() Group by the afflictions column
 *
 * @method     ChildBattleEntriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBattleEntriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBattleEntriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBattleEntriesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBattleEntriesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBattleEntriesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBattleEntriesQuery leftJoinBattles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Battles relation
 * @method     ChildBattleEntriesQuery rightJoinBattles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Battles relation
 * @method     ChildBattleEntriesQuery innerJoinBattles($relationAlias = null) Adds a INNER JOIN clause to the query using the Battles relation
 *
 * @method     ChildBattleEntriesQuery joinWithBattles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Battles relation
 *
 * @method     ChildBattleEntriesQuery leftJoinWithBattles() Adds a LEFT JOIN clause and with to the query using the Battles relation
 * @method     ChildBattleEntriesQuery rightJoinWithBattles() Adds a RIGHT JOIN clause and with to the query using the Battles relation
 * @method     ChildBattleEntriesQuery innerJoinWithBattles() Adds a INNER JOIN clause and with to the query using the Battles relation
 *
 * @method     ChildBattleEntriesQuery leftJoinCharacters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Characters relation
 * @method     ChildBattleEntriesQuery rightJoinCharacters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Characters relation
 * @method     ChildBattleEntriesQuery innerJoinCharacters($relationAlias = null) Adds a INNER JOIN clause to the query using the Characters relation
 *
 * @method     ChildBattleEntriesQuery joinWithCharacters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Characters relation
 *
 * @method     ChildBattleEntriesQuery leftJoinWithCharacters() Adds a LEFT JOIN clause and with to the query using the Characters relation
 * @method     ChildBattleEntriesQuery rightJoinWithCharacters() Adds a RIGHT JOIN clause and with to the query using the Characters relation
 * @method     ChildBattleEntriesQuery innerJoinWithCharacters() Adds a INNER JOIN clause and with to the query using the Characters relation
 *
 * @method     \Propel\PtuToolkit\BattlesQuery|\Propel\PtuToolkit\CharactersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBattleEntries findOne(ConnectionInterface $con = null) Return the first ChildBattleEntries matching the query
 * @method     ChildBattleEntries findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBattleEntries matching the query, or a new ChildBattleEntries object populated from the query conditions when no match is found
 *
 * @method     ChildBattleEntries findOneByBattleEntryId(int $battle_entry_id) Return the first ChildBattleEntries filtered by the battle_entry_id column
 * @method     ChildBattleEntries findOneByBattleId(int $battle_id) Return the first ChildBattleEntries filtered by the battle_id column
 * @method     ChildBattleEntries findOneByCharacterId(int $character_id) Return the first ChildBattleEntries filtered by the character_id column
 * @method     ChildBattleEntries findOneByAfflictions(string $afflictions) Return the first ChildBattleEntries filtered by the afflictions column *

 * @method     ChildBattleEntries requirePk($key, ConnectionInterface $con = null) Return the ChildBattleEntries by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBattleEntries requireOne(ConnectionInterface $con = null) Return the first ChildBattleEntries matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBattleEntries requireOneByBattleEntryId(int $battle_entry_id) Return the first ChildBattleEntries filtered by the battle_entry_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBattleEntries requireOneByBattleId(int $battle_id) Return the first ChildBattleEntries filtered by the battle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBattleEntries requireOneByCharacterId(int $character_id) Return the first ChildBattleEntries filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBattleEntries requireOneByAfflictions(string $afflictions) Return the first ChildBattleEntries filtered by the afflictions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBattleEntries[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBattleEntries objects based on current ModelCriteria
 * @method     ChildBattleEntries[]|ObjectCollection findByBattleEntryId(int $battle_entry_id) Return ChildBattleEntries objects filtered by the battle_entry_id column
 * @method     ChildBattleEntries[]|ObjectCollection findByBattleId(int $battle_id) Return ChildBattleEntries objects filtered by the battle_id column
 * @method     ChildBattleEntries[]|ObjectCollection findByCharacterId(int $character_id) Return ChildBattleEntries objects filtered by the character_id column
 * @method     ChildBattleEntries[]|ObjectCollection findByAfflictions(string $afflictions) Return ChildBattleEntries objects filtered by the afflictions column
 * @method     ChildBattleEntries[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BattleEntriesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\BattleEntriesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\BattleEntries', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBattleEntriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBattleEntriesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBattleEntriesQuery) {
            return $criteria;
        }
        $query = new ChildBattleEntriesQuery();
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
     * @return ChildBattleEntries|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BattleEntriesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BattleEntriesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBattleEntries A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT battle_entry_id, battle_id, character_id, afflictions FROM battle_entries WHERE battle_entry_id = :p0';
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
            /** @var ChildBattleEntries $obj */
            $obj = new ChildBattleEntries();
            $obj->hydrate($row);
            BattleEntriesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBattleEntries|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the battle_entry_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBattleEntryId(1234); // WHERE battle_entry_id = 1234
     * $query->filterByBattleEntryId(array(12, 34)); // WHERE battle_entry_id IN (12, 34)
     * $query->filterByBattleEntryId(array('min' => 12)); // WHERE battle_entry_id > 12
     * </code>
     *
     * @param     mixed $battleEntryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByBattleEntryId($battleEntryId = null, $comparison = null)
    {
        if (is_array($battleEntryId)) {
            $useMinMax = false;
            if (isset($battleEntryId['min'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $battleEntryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($battleEntryId['max'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $battleEntryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $battleEntryId, $comparison);
    }

    /**
     * Filter the query on the battle_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBattleId(1234); // WHERE battle_id = 1234
     * $query->filterByBattleId(array(12, 34)); // WHERE battle_id IN (12, 34)
     * $query->filterByBattleId(array('min' => 12)); // WHERE battle_id > 12
     * </code>
     *
     * @see       filterByBattles()
     *
     * @param     mixed $battleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByBattleId($battleId = null, $comparison = null)
    {
        if (is_array($battleId)) {
            $useMinMax = false;
            if (isset($battleId['min'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ID, $battleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($battleId['max'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ID, $battleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ID, $battleId, $comparison);
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
     * @see       filterByCharacters()
     *
     * @param     mixed $characterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(BattleEntriesTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BattleEntriesTableMap::COL_CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the afflictions column
     *
     * Example usage:
     * <code>
     * $query->filterByAfflictions('fooValue');   // WHERE afflictions = 'fooValue'
     * $query->filterByAfflictions('%fooValue%', Criteria::LIKE); // WHERE afflictions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $afflictions The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByAfflictions($afflictions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($afflictions)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BattleEntriesTableMap::COL_AFFLICTIONS, $afflictions, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Battles object
     *
     * @param \Propel\PtuToolkit\Battles|ObjectCollection $battles The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByBattles($battles, $comparison = null)
    {
        if ($battles instanceof \Propel\PtuToolkit\Battles) {
            return $this
                ->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ID, $battles->getBattleId(), $comparison);
        } elseif ($battles instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ID, $battles->toKeyValue('PrimaryKey', 'BattleId'), $comparison);
        } else {
            throw new PropelException('filterByBattles() only accepts arguments of type \Propel\PtuToolkit\Battles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Battles relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function joinBattles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Battles');

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
            $this->addJoinObject($join, 'Battles');
        }

        return $this;
    }

    /**
     * Use the Battles relation Battles object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\BattlesQuery A secondary query class using the current class as primary query
     */
    public function useBattlesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBattles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Battles', '\Propel\PtuToolkit\BattlesQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Characters object
     *
     * @param \Propel\PtuToolkit\Characters|ObjectCollection $characters The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function filterByCharacters($characters, $comparison = null)
    {
        if ($characters instanceof \Propel\PtuToolkit\Characters) {
            return $this
                ->addUsingAlias(BattleEntriesTableMap::COL_CHARACTER_ID, $characters->getCharacterId(), $comparison);
        } elseif ($characters instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BattleEntriesTableMap::COL_CHARACTER_ID, $characters->toKeyValue('PrimaryKey', 'CharacterId'), $comparison);
        } else {
            throw new PropelException('filterByCharacters() only accepts arguments of type \Propel\PtuToolkit\Characters or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Characters relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function joinCharacters($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Characters');

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
            $this->addJoinObject($join, 'Characters');
        }

        return $this;
    }

    /**
     * Use the Characters relation Characters object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CharactersQuery A secondary query class using the current class as primary query
     */
    public function useCharactersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacters($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Characters', '\Propel\PtuToolkit\CharactersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBattleEntries $battleEntries Object to remove from the list of results
     *
     * @return $this|ChildBattleEntriesQuery The current query, for fluid interface
     */
    public function prune($battleEntries = null)
    {
        if ($battleEntries) {
            $this->addUsingAlias(BattleEntriesTableMap::COL_BATTLE_ENTRY_ID, $battleEntries->getBattleEntryId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the battle_entries table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BattleEntriesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BattleEntriesTableMap::clearInstancePool();
            BattleEntriesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BattleEntriesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BattleEntriesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BattleEntriesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BattleEntriesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BattleEntriesQuery
