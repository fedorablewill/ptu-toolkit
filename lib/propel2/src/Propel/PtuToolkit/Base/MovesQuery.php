<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\Moves as ChildMoves;
use Propel\PtuToolkit\MovesQuery as ChildMovesQuery;
use Propel\PtuToolkit\Map\MovesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moves' table.
 *
 *
 *
 * @method     ChildMovesQuery orderByMoveId($order = Criteria::ASC) Order by the move_id column
 * @method     ChildMovesQuery orderByPokedexId($order = Criteria::ASC) Order by the pokedex_id column
 * @method     ChildMovesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildMovesQuery orderByEffect($order = Criteria::ASC) Order by the effect column
 * @method     ChildMovesQuery orderByFreq($order = Criteria::ASC) Order by the freq column
 * @method     ChildMovesQuery orderByClass($order = Criteria::ASC) Order by the class column
 * @method     ChildMovesQuery orderByRange($order = Criteria::ASC) Order by the range column
 * @method     ChildMovesQuery orderByContestType($order = Criteria::ASC) Order by the contest_type column
 * @method     ChildMovesQuery orderByContestEffect($order = Criteria::ASC) Order by the contest_effect column
 * @method     ChildMovesQuery orderByCritsOn($order = Criteria::ASC) Order by the crits_on column
 * @method     ChildMovesQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildMovesQuery orderByTriggers($order = Criteria::ASC) Order by the triggers column
 *
 * @method     ChildMovesQuery groupByMoveId() Group by the move_id column
 * @method     ChildMovesQuery groupByPokedexId() Group by the pokedex_id column
 * @method     ChildMovesQuery groupByName() Group by the name column
 * @method     ChildMovesQuery groupByEffect() Group by the effect column
 * @method     ChildMovesQuery groupByFreq() Group by the freq column
 * @method     ChildMovesQuery groupByClass() Group by the class column
 * @method     ChildMovesQuery groupByRange() Group by the range column
 * @method     ChildMovesQuery groupByContestType() Group by the contest_type column
 * @method     ChildMovesQuery groupByContestEffect() Group by the contest_effect column
 * @method     ChildMovesQuery groupByCritsOn() Group by the crits_on column
 * @method     ChildMovesQuery groupByType() Group by the type column
 * @method     ChildMovesQuery groupByTriggers() Group by the triggers column
 *
 * @method     ChildMovesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMovesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMovesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMovesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMovesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMovesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMovesQuery leftJoinDataPokedex($relationAlias = null) Adds a LEFT JOIN clause to the query using the DataPokedex relation
 * @method     ChildMovesQuery rightJoinDataPokedex($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DataPokedex relation
 * @method     ChildMovesQuery innerJoinDataPokedex($relationAlias = null) Adds a INNER JOIN clause to the query using the DataPokedex relation
 *
 * @method     ChildMovesQuery joinWithDataPokedex($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DataPokedex relation
 *
 * @method     ChildMovesQuery leftJoinWithDataPokedex() Adds a LEFT JOIN clause and with to the query using the DataPokedex relation
 * @method     ChildMovesQuery rightJoinWithDataPokedex() Adds a RIGHT JOIN clause and with to the query using the DataPokedex relation
 * @method     ChildMovesQuery innerJoinWithDataPokedex() Adds a INNER JOIN clause and with to the query using the DataPokedex relation
 *
 * @method     ChildMovesQuery leftJoinCharacterMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the CharacterMoves relation
 * @method     ChildMovesQuery rightJoinCharacterMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CharacterMoves relation
 * @method     ChildMovesQuery innerJoinCharacterMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the CharacterMoves relation
 *
 * @method     ChildMovesQuery joinWithCharacterMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CharacterMoves relation
 *
 * @method     ChildMovesQuery leftJoinWithCharacterMoves() Adds a LEFT JOIN clause and with to the query using the CharacterMoves relation
 * @method     ChildMovesQuery rightJoinWithCharacterMoves() Adds a RIGHT JOIN clause and with to the query using the CharacterMoves relation
 * @method     ChildMovesQuery innerJoinWithCharacterMoves() Adds a INNER JOIN clause and with to the query using the CharacterMoves relation
 *
 * @method     ChildMovesQuery leftJoinPokedexMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the PokedexMoves relation
 * @method     ChildMovesQuery rightJoinPokedexMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PokedexMoves relation
 * @method     ChildMovesQuery innerJoinPokedexMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the PokedexMoves relation
 *
 * @method     ChildMovesQuery joinWithPokedexMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PokedexMoves relation
 *
 * @method     ChildMovesQuery leftJoinWithPokedexMoves() Adds a LEFT JOIN clause and with to the query using the PokedexMoves relation
 * @method     ChildMovesQuery rightJoinWithPokedexMoves() Adds a RIGHT JOIN clause and with to the query using the PokedexMoves relation
 * @method     ChildMovesQuery innerJoinWithPokedexMoves() Adds a INNER JOIN clause and with to the query using the PokedexMoves relation
 *
 * @method     \Propel\PtuToolkit\DataPokedexQuery|\Propel\PtuToolkit\CharacterMovesQuery|\Propel\PtuToolkit\PokedexMovesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMoves findOne(ConnectionInterface $con = null) Return the first ChildMoves matching the query
 * @method     ChildMoves findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMoves matching the query, or a new ChildMoves object populated from the query conditions when no match is found
 *
 * @method     ChildMoves findOneByMoveId(int $move_id) Return the first ChildMoves filtered by the move_id column
 * @method     ChildMoves findOneByPokedexId(int $pokedex_id) Return the first ChildMoves filtered by the pokedex_id column
 * @method     ChildMoves findOneByName(string $name) Return the first ChildMoves filtered by the name column
 * @method     ChildMoves findOneByEffect(string $effect) Return the first ChildMoves filtered by the effect column
 * @method     ChildMoves findOneByFreq(string $freq) Return the first ChildMoves filtered by the freq column
 * @method     ChildMoves findOneByClass(string $class) Return the first ChildMoves filtered by the class column
 * @method     ChildMoves findOneByRange(string $range) Return the first ChildMoves filtered by the range column
 * @method     ChildMoves findOneByContestType(string $contest_type) Return the first ChildMoves filtered by the contest_type column
 * @method     ChildMoves findOneByContestEffect(string $contest_effect) Return the first ChildMoves filtered by the contest_effect column
 * @method     ChildMoves findOneByCritsOn(int $crits_on) Return the first ChildMoves filtered by the crits_on column
 * @method     ChildMoves findOneByType(string $type) Return the first ChildMoves filtered by the type column
 * @method     ChildMoves findOneByTriggers(string $triggers) Return the first ChildMoves filtered by the triggers column *

 * @method     ChildMoves requirePk($key, ConnectionInterface $con = null) Return the ChildMoves by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOne(ConnectionInterface $con = null) Return the first ChildMoves matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMoves requireOneByMoveId(int $move_id) Return the first ChildMoves filtered by the move_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByPokedexId(int $pokedex_id) Return the first ChildMoves filtered by the pokedex_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByName(string $name) Return the first ChildMoves filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByEffect(string $effect) Return the first ChildMoves filtered by the effect column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByFreq(string $freq) Return the first ChildMoves filtered by the freq column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByClass(string $class) Return the first ChildMoves filtered by the class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByRange(string $range) Return the first ChildMoves filtered by the range column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByContestType(string $contest_type) Return the first ChildMoves filtered by the contest_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByContestEffect(string $contest_effect) Return the first ChildMoves filtered by the contest_effect column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByCritsOn(int $crits_on) Return the first ChildMoves filtered by the crits_on column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByType(string $type) Return the first ChildMoves filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMoves requireOneByTriggers(string $triggers) Return the first ChildMoves filtered by the triggers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMoves[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMoves objects based on current ModelCriteria
 * @method     ChildMoves[]|ObjectCollection findByMoveId(int $move_id) Return ChildMoves objects filtered by the move_id column
 * @method     ChildMoves[]|ObjectCollection findByPokedexId(int $pokedex_id) Return ChildMoves objects filtered by the pokedex_id column
 * @method     ChildMoves[]|ObjectCollection findByName(string $name) Return ChildMoves objects filtered by the name column
 * @method     ChildMoves[]|ObjectCollection findByEffect(string $effect) Return ChildMoves objects filtered by the effect column
 * @method     ChildMoves[]|ObjectCollection findByFreq(string $freq) Return ChildMoves objects filtered by the freq column
 * @method     ChildMoves[]|ObjectCollection findByClass(string $class) Return ChildMoves objects filtered by the class column
 * @method     ChildMoves[]|ObjectCollection findByRange(string $range) Return ChildMoves objects filtered by the range column
 * @method     ChildMoves[]|ObjectCollection findByContestType(string $contest_type) Return ChildMoves objects filtered by the contest_type column
 * @method     ChildMoves[]|ObjectCollection findByContestEffect(string $contest_effect) Return ChildMoves objects filtered by the contest_effect column
 * @method     ChildMoves[]|ObjectCollection findByCritsOn(int $crits_on) Return ChildMoves objects filtered by the crits_on column
 * @method     ChildMoves[]|ObjectCollection findByType(string $type) Return ChildMoves objects filtered by the type column
 * @method     ChildMoves[]|ObjectCollection findByTriggers(string $triggers) Return ChildMoves objects filtered by the triggers column
 * @method     ChildMoves[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MovesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\MovesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\Moves', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMovesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMovesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMovesQuery) {
            return $criteria;
        }
        $query = new ChildMovesQuery();
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
     * @return ChildMoves|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MovesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MovesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMoves A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT move_id, pokedex_id, name, effect, freq, class, range, contest_type, contest_effect, crits_on, type, triggers FROM moves WHERE move_id = :p0';
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
            /** @var ChildMoves $obj */
            $obj = new ChildMoves();
            $obj->hydrate($row);
            MovesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMoves|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the move_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMoveId(1234); // WHERE move_id = 1234
     * $query->filterByMoveId(array(12, 34)); // WHERE move_id IN (12, 34)
     * $query->filterByMoveId(array('min' => 12)); // WHERE move_id > 12
     * </code>
     *
     * @param     mixed $moveId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByMoveId($moveId = null, $comparison = null)
    {
        if (is_array($moveId)) {
            $useMinMax = false;
            if (isset($moveId['min'])) {
                $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $moveId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moveId['max'])) {
                $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $moveId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $moveId, $comparison);
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
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByPokedexId($pokedexId = null, $comparison = null)
    {
        if (is_array($pokedexId)) {
            $useMinMax = false;
            if (isset($pokedexId['min'])) {
                $this->addUsingAlias(MovesTableMap::COL_POKEDEX_ID, $pokedexId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexId['max'])) {
                $this->addUsingAlias(MovesTableMap::COL_POKEDEX_ID, $pokedexId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_POKEDEX_ID, $pokedexId, $comparison);
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
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the effect column
     *
     * Example usage:
     * <code>
     * $query->filterByEffect('fooValue');   // WHERE effect = 'fooValue'
     * $query->filterByEffect('%fooValue%', Criteria::LIKE); // WHERE effect LIKE '%fooValue%'
     * </code>
     *
     * @param     string $effect The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByEffect($effect = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($effect)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_EFFECT, $effect, $comparison);
    }

    /**
     * Filter the query on the freq column
     *
     * Example usage:
     * <code>
     * $query->filterByFreq('fooValue');   // WHERE freq = 'fooValue'
     * $query->filterByFreq('%fooValue%', Criteria::LIKE); // WHERE freq LIKE '%fooValue%'
     * </code>
     *
     * @param     string $freq The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByFreq($freq = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($freq)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_FREQ, $freq, $comparison);
    }

    /**
     * Filter the query on the class column
     *
     * Example usage:
     * <code>
     * $query->filterByClass('fooValue');   // WHERE class = 'fooValue'
     * $query->filterByClass('%fooValue%', Criteria::LIKE); // WHERE class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $class The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByClass($class = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($class)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_CLASS, $class, $comparison);
    }

    /**
     * Filter the query on the range column
     *
     * Example usage:
     * <code>
     * $query->filterByRange('fooValue');   // WHERE range = 'fooValue'
     * $query->filterByRange('%fooValue%', Criteria::LIKE); // WHERE range LIKE '%fooValue%'
     * </code>
     *
     * @param     string $range The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByRange($range = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($range)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_RANGE, $range, $comparison);
    }

    /**
     * Filter the query on the contest_type column
     *
     * Example usage:
     * <code>
     * $query->filterByContestType('fooValue');   // WHERE contest_type = 'fooValue'
     * $query->filterByContestType('%fooValue%', Criteria::LIKE); // WHERE contest_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contestType The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByContestType($contestType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contestType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_CONTEST_TYPE, $contestType, $comparison);
    }

    /**
     * Filter the query on the contest_effect column
     *
     * Example usage:
     * <code>
     * $query->filterByContestEffect('fooValue');   // WHERE contest_effect = 'fooValue'
     * $query->filterByContestEffect('%fooValue%', Criteria::LIKE); // WHERE contest_effect LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contestEffect The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByContestEffect($contestEffect = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contestEffect)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_CONTEST_EFFECT, $contestEffect, $comparison);
    }

    /**
     * Filter the query on the crits_on column
     *
     * Example usage:
     * <code>
     * $query->filterByCritsOn(1234); // WHERE crits_on = 1234
     * $query->filterByCritsOn(array(12, 34)); // WHERE crits_on IN (12, 34)
     * $query->filterByCritsOn(array('min' => 12)); // WHERE crits_on > 12
     * </code>
     *
     * @param     mixed $critsOn The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByCritsOn($critsOn = null, $comparison = null)
    {
        if (is_array($critsOn)) {
            $useMinMax = false;
            if (isset($critsOn['min'])) {
                $this->addUsingAlias(MovesTableMap::COL_CRITS_ON, $critsOn['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($critsOn['max'])) {
                $this->addUsingAlias(MovesTableMap::COL_CRITS_ON, $critsOn['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_CRITS_ON, $critsOn, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the triggers column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggers('fooValue');   // WHERE triggers = 'fooValue'
     * $query->filterByTriggers('%fooValue%', Criteria::LIKE); // WHERE triggers LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggers The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function filterByTriggers($triggers = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggers)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MovesTableMap::COL_TRIGGERS, $triggers, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\DataPokedex object
     *
     * @param \Propel\PtuToolkit\DataPokedex|ObjectCollection $dataPokedex The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMovesQuery The current query, for fluid interface
     */
    public function filterByDataPokedex($dataPokedex, $comparison = null)
    {
        if ($dataPokedex instanceof \Propel\PtuToolkit\DataPokedex) {
            return $this
                ->addUsingAlias(MovesTableMap::COL_POKEDEX_ID, $dataPokedex->getPokedexId(), $comparison);
        } elseif ($dataPokedex instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MovesTableMap::COL_POKEDEX_ID, $dataPokedex->toKeyValue('PrimaryKey', 'PokedexId'), $comparison);
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
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function joinDataPokedex($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useDataPokedexQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDataPokedex($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DataPokedex', '\Propel\PtuToolkit\DataPokedexQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\CharacterMoves object
     *
     * @param \Propel\PtuToolkit\CharacterMoves|ObjectCollection $characterMoves the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovesQuery The current query, for fluid interface
     */
    public function filterByCharacterMoves($characterMoves, $comparison = null)
    {
        if ($characterMoves instanceof \Propel\PtuToolkit\CharacterMoves) {
            return $this
                ->addUsingAlias(MovesTableMap::COL_MOVE_ID, $characterMoves->getMoveId(), $comparison);
        } elseif ($characterMoves instanceof ObjectCollection) {
            return $this
                ->useCharacterMovesQuery()
                ->filterByPrimaryKeys($characterMoves->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCharacterMoves() only accepts arguments of type \Propel\PtuToolkit\CharacterMoves or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CharacterMoves relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function joinCharacterMoves($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CharacterMoves');

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
            $this->addJoinObject($join, 'CharacterMoves');
        }

        return $this;
    }

    /**
     * Use the CharacterMoves relation CharacterMoves object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CharacterMovesQuery A secondary query class using the current class as primary query
     */
    public function useCharacterMovesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCharacterMoves($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CharacterMoves', '\Propel\PtuToolkit\CharacterMovesQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\PokedexMoves object
     *
     * @param \Propel\PtuToolkit\PokedexMoves|ObjectCollection $pokedexMoves the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMovesQuery The current query, for fluid interface
     */
    public function filterByPokedexMoves($pokedexMoves, $comparison = null)
    {
        if ($pokedexMoves instanceof \Propel\PtuToolkit\PokedexMoves) {
            return $this
                ->addUsingAlias(MovesTableMap::COL_MOVE_ID, $pokedexMoves->getMoveId(), $comparison);
        } elseif ($pokedexMoves instanceof ObjectCollection) {
            return $this
                ->usePokedexMovesQuery()
                ->filterByPrimaryKeys($pokedexMoves->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPokedexMoves() only accepts arguments of type \Propel\PtuToolkit\PokedexMoves or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PokedexMoves relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
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
     * @param   ChildMoves $moves Object to remove from the list of results
     *
     * @return $this|ChildMovesQuery The current query, for fluid interface
     */
    public function prune($moves = null)
    {
        if ($moves) {
            $this->addUsingAlias(MovesTableMap::COL_MOVE_ID, $moves->getMoveId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moves table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MovesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MovesTableMap::clearInstancePool();
            MovesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MovesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MovesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MovesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MovesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MovesQuery
