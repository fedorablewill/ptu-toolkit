<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\PokedexMoves as ChildPokedexMoves;
use Propel\PtuToolkit\PokedexMovesQuery as ChildPokedexMovesQuery;
use Propel\PtuToolkit\Map\PokedexMovesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pokedex_moves' table.
 *
 *
 *
 * @method     ChildPokedexMovesQuery orderByPokedexMoveId($order = Criteria::ASC) Order by the pokedex_move_id column
 * @method     ChildPokedexMovesQuery orderByPokedexNo($order = Criteria::ASC) Order by the pokedex_no column
 * @method     ChildPokedexMovesQuery orderByPokedexId($order = Criteria::ASC) Order by the pokedex_id column
 * @method     ChildPokedexMovesQuery orderByMoveId($order = Criteria::ASC) Order by the move_id column
 * @method     ChildPokedexMovesQuery orderByLevelLearned($order = Criteria::ASC) Order by the level_learned column
 * @method     ChildPokedexMovesQuery orderByTechnicalMachineId($order = Criteria::ASC) Order by the tm_id column
 * @method     ChildPokedexMovesQuery orderByNatural($order = Criteria::ASC) Order by the is_natural column
 * @method     ChildPokedexMovesQuery orderByEggMove($order = Criteria::ASC) Order by the is_egg_move column
 *
 * @method     ChildPokedexMovesQuery groupByPokedexMoveId() Group by the pokedex_move_id column
 * @method     ChildPokedexMovesQuery groupByPokedexNo() Group by the pokedex_no column
 * @method     ChildPokedexMovesQuery groupByPokedexId() Group by the pokedex_id column
 * @method     ChildPokedexMovesQuery groupByMoveId() Group by the move_id column
 * @method     ChildPokedexMovesQuery groupByLevelLearned() Group by the level_learned column
 * @method     ChildPokedexMovesQuery groupByTechnicalMachineId() Group by the tm_id column
 * @method     ChildPokedexMovesQuery groupByNatural() Group by the is_natural column
 * @method     ChildPokedexMovesQuery groupByEggMove() Group by the is_egg_move column
 *
 * @method     ChildPokedexMovesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPokedexMovesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPokedexMovesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPokedexMovesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPokedexMovesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPokedexMovesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPokedexMovesQuery leftJoinDataPokedexEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the DataPokedexEntry relation
 * @method     ChildPokedexMovesQuery rightJoinDataPokedexEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DataPokedexEntry relation
 * @method     ChildPokedexMovesQuery innerJoinDataPokedexEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the DataPokedexEntry relation
 *
 * @method     ChildPokedexMovesQuery joinWithDataPokedexEntry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DataPokedexEntry relation
 *
 * @method     ChildPokedexMovesQuery leftJoinWithDataPokedexEntry() Adds a LEFT JOIN clause and with to the query using the DataPokedexEntry relation
 * @method     ChildPokedexMovesQuery rightJoinWithDataPokedexEntry() Adds a RIGHT JOIN clause and with to the query using the DataPokedexEntry relation
 * @method     ChildPokedexMovesQuery innerJoinWithDataPokedexEntry() Adds a INNER JOIN clause and with to the query using the DataPokedexEntry relation
 *
 * @method     ChildPokedexMovesQuery leftJoinMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the Moves relation
 * @method     ChildPokedexMovesQuery rightJoinMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Moves relation
 * @method     ChildPokedexMovesQuery innerJoinMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the Moves relation
 *
 * @method     ChildPokedexMovesQuery joinWithMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Moves relation
 *
 * @method     ChildPokedexMovesQuery leftJoinWithMoves() Adds a LEFT JOIN clause and with to the query using the Moves relation
 * @method     ChildPokedexMovesQuery rightJoinWithMoves() Adds a RIGHT JOIN clause and with to the query using the Moves relation
 * @method     ChildPokedexMovesQuery innerJoinWithMoves() Adds a INNER JOIN clause and with to the query using the Moves relation
 *
 * @method     \Propel\PtuToolkit\DataPokedexEntryQuery|\Propel\PtuToolkit\MovesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPokedexMoves findOne(ConnectionInterface $con = null) Return the first ChildPokedexMoves matching the query
 * @method     ChildPokedexMoves findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPokedexMoves matching the query, or a new ChildPokedexMoves object populated from the query conditions when no match is found
 *
 * @method     ChildPokedexMoves findOneByPokedexMoveId(int $pokedex_move_id) Return the first ChildPokedexMoves filtered by the pokedex_move_id column
 * @method     ChildPokedexMoves findOneByPokedexNo(string $pokedex_no) Return the first ChildPokedexMoves filtered by the pokedex_no column
 * @method     ChildPokedexMoves findOneByPokedexId(int $pokedex_id) Return the first ChildPokedexMoves filtered by the pokedex_id column
 * @method     ChildPokedexMoves findOneByMoveId(int $move_id) Return the first ChildPokedexMoves filtered by the move_id column
 * @method     ChildPokedexMoves findOneByLevelLearned(int $level_learned) Return the first ChildPokedexMoves filtered by the level_learned column
 * @method     ChildPokedexMoves findOneByTechnicalMachineId(int $tm_id) Return the first ChildPokedexMoves filtered by the tm_id column
 * @method     ChildPokedexMoves findOneByNatural(boolean $is_natural) Return the first ChildPokedexMoves filtered by the is_natural column
 * @method     ChildPokedexMoves findOneByEggMove(boolean $is_egg_move) Return the first ChildPokedexMoves filtered by the is_egg_move column *

 * @method     ChildPokedexMoves requirePk($key, ConnectionInterface $con = null) Return the ChildPokedexMoves by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOne(ConnectionInterface $con = null) Return the first ChildPokedexMoves matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPokedexMoves requireOneByPokedexMoveId(int $pokedex_move_id) Return the first ChildPokedexMoves filtered by the pokedex_move_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByPokedexNo(string $pokedex_no) Return the first ChildPokedexMoves filtered by the pokedex_no column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByPokedexId(int $pokedex_id) Return the first ChildPokedexMoves filtered by the pokedex_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByMoveId(int $move_id) Return the first ChildPokedexMoves filtered by the move_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByLevelLearned(int $level_learned) Return the first ChildPokedexMoves filtered by the level_learned column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByTechnicalMachineId(int $tm_id) Return the first ChildPokedexMoves filtered by the tm_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByNatural(boolean $is_natural) Return the first ChildPokedexMoves filtered by the is_natural column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPokedexMoves requireOneByEggMove(boolean $is_egg_move) Return the first ChildPokedexMoves filtered by the is_egg_move column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPokedexMoves[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPokedexMoves objects based on current ModelCriteria
 * @method     ChildPokedexMoves[]|ObjectCollection findByPokedexMoveId(int $pokedex_move_id) Return ChildPokedexMoves objects filtered by the pokedex_move_id column
 * @method     ChildPokedexMoves[]|ObjectCollection findByPokedexNo(string $pokedex_no) Return ChildPokedexMoves objects filtered by the pokedex_no column
 * @method     ChildPokedexMoves[]|ObjectCollection findByPokedexId(int $pokedex_id) Return ChildPokedexMoves objects filtered by the pokedex_id column
 * @method     ChildPokedexMoves[]|ObjectCollection findByMoveId(int $move_id) Return ChildPokedexMoves objects filtered by the move_id column
 * @method     ChildPokedexMoves[]|ObjectCollection findByLevelLearned(int $level_learned) Return ChildPokedexMoves objects filtered by the level_learned column
 * @method     ChildPokedexMoves[]|ObjectCollection findByTechnicalMachineId(int $tm_id) Return ChildPokedexMoves objects filtered by the tm_id column
 * @method     ChildPokedexMoves[]|ObjectCollection findByNatural(boolean $is_natural) Return ChildPokedexMoves objects filtered by the is_natural column
 * @method     ChildPokedexMoves[]|ObjectCollection findByEggMove(boolean $is_egg_move) Return ChildPokedexMoves objects filtered by the is_egg_move column
 * @method     ChildPokedexMoves[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PokedexMovesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\PokedexMovesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\PokedexMoves', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPokedexMovesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPokedexMovesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPokedexMovesQuery) {
            return $criteria;
        }
        $query = new ChildPokedexMovesQuery();
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
     * @return ChildPokedexMoves|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PokedexMovesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PokedexMovesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPokedexMoves A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT pokedex_move_id, pokedex_no, pokedex_id, move_id, level_learned, tm_id, is_natural, is_egg_move FROM pokedex_moves WHERE pokedex_move_id = :p0';
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
            /** @var ChildPokedexMoves $obj */
            $obj = new ChildPokedexMoves();
            $obj->hydrate($row);
            PokedexMovesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPokedexMoves|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the pokedex_move_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPokedexMoveId(1234); // WHERE pokedex_move_id = 1234
     * $query->filterByPokedexMoveId(array(12, 34)); // WHERE pokedex_move_id IN (12, 34)
     * $query->filterByPokedexMoveId(array('min' => 12)); // WHERE pokedex_move_id > 12
     * </code>
     *
     * @param     mixed $pokedexMoveId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByPokedexMoveId($pokedexMoveId = null, $comparison = null)
    {
        if (is_array($pokedexMoveId)) {
            $useMinMax = false;
            if (isset($pokedexMoveId['min'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $pokedexMoveId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexMoveId['max'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $pokedexMoveId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $pokedexMoveId, $comparison);
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
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByPokedexNo($pokedexNo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pokedexNo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_NO, $pokedexNo, $comparison);
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
     * @see       filterByDataPokedexEntry()
     *
     * @param     mixed $pokedexId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByPokedexId($pokedexId = null, $comparison = null)
    {
        if (is_array($pokedexId)) {
            $useMinMax = false;
            if (isset($pokedexId['min'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_ID, $pokedexId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pokedexId['max'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_ID, $pokedexId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_ID, $pokedexId, $comparison);
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
     * @see       filterByMoves()
     *
     * @param     mixed $moveId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByMoveId($moveId = null, $comparison = null)
    {
        if (is_array($moveId)) {
            $useMinMax = false;
            if (isset($moveId['min'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_MOVE_ID, $moveId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moveId['max'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_MOVE_ID, $moveId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_MOVE_ID, $moveId, $comparison);
    }

    /**
     * Filter the query on the level_learned column
     *
     * Example usage:
     * <code>
     * $query->filterByLevelLearned(1234); // WHERE level_learned = 1234
     * $query->filterByLevelLearned(array(12, 34)); // WHERE level_learned IN (12, 34)
     * $query->filterByLevelLearned(array('min' => 12)); // WHERE level_learned > 12
     * </code>
     *
     * @param     mixed $levelLearned The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByLevelLearned($levelLearned = null, $comparison = null)
    {
        if (is_array($levelLearned)) {
            $useMinMax = false;
            if (isset($levelLearned['min'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_LEVEL_LEARNED, $levelLearned['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($levelLearned['max'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_LEVEL_LEARNED, $levelLearned['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_LEVEL_LEARNED, $levelLearned, $comparison);
    }

    /**
     * Filter the query on the tm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTechnicalMachineId(1234); // WHERE tm_id = 1234
     * $query->filterByTechnicalMachineId(array(12, 34)); // WHERE tm_id IN (12, 34)
     * $query->filterByTechnicalMachineId(array('min' => 12)); // WHERE tm_id > 12
     * </code>
     *
     * @param     mixed $technicalMachineId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByTechnicalMachineId($technicalMachineId = null, $comparison = null)
    {
        if (is_array($technicalMachineId)) {
            $useMinMax = false;
            if (isset($technicalMachineId['min'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_TM_ID, $technicalMachineId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($technicalMachineId['max'])) {
                $this->addUsingAlias(PokedexMovesTableMap::COL_TM_ID, $technicalMachineId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_TM_ID, $technicalMachineId, $comparison);
    }

    /**
     * Filter the query on the is_natural column
     *
     * Example usage:
     * <code>
     * $query->filterByNatural(true); // WHERE is_natural = true
     * $query->filterByNatural('yes'); // WHERE is_natural = true
     * </code>
     *
     * @param     boolean|string $natural The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByNatural($natural = null, $comparison = null)
    {
        if (is_string($natural)) {
            $natural = in_array(strtolower($natural), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_IS_NATURAL, $natural, $comparison);
    }

    /**
     * Filter the query on the is_egg_move column
     *
     * Example usage:
     * <code>
     * $query->filterByEggMove(true); // WHERE is_egg_move = true
     * $query->filterByEggMove('yes'); // WHERE is_egg_move = true
     * </code>
     *
     * @param     boolean|string $eggMove The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByEggMove($eggMove = null, $comparison = null)
    {
        if (is_string($eggMove)) {
            $eggMove = in_array(strtolower($eggMove), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PokedexMovesTableMap::COL_IS_EGG_MOVE, $eggMove, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\DataPokedexEntry object
     *
     * @param \Propel\PtuToolkit\DataPokedexEntry $dataPokedexEntry The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByDataPokedexEntry($dataPokedexEntry, $comparison = null)
    {
        if ($dataPokedexEntry instanceof \Propel\PtuToolkit\DataPokedexEntry) {
            return $this
                ->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_ID, $dataPokedexEntry->getPokedexId(), $comparison)
                ->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_NO, $dataPokedexEntry->getPokedexNo(), $comparison);
        } else {
            throw new PropelException('filterByDataPokedexEntry() only accepts arguments of type \Propel\PtuToolkit\DataPokedexEntry');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DataPokedexEntry relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function joinDataPokedexEntry($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useDataPokedexEntryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDataPokedexEntry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DataPokedexEntry', '\Propel\PtuToolkit\DataPokedexEntryQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Moves object
     *
     * @param \Propel\PtuToolkit\Moves|ObjectCollection $moves The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function filterByMoves($moves, $comparison = null)
    {
        if ($moves instanceof \Propel\PtuToolkit\Moves) {
            return $this
                ->addUsingAlias(PokedexMovesTableMap::COL_MOVE_ID, $moves->getMoveId(), $comparison);
        } elseif ($moves instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PokedexMovesTableMap::COL_MOVE_ID, $moves->toKeyValue('PrimaryKey', 'MoveId'), $comparison);
        } else {
            throw new PropelException('filterByMoves() only accepts arguments of type \Propel\PtuToolkit\Moves or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Moves relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function joinMoves($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Moves');

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
            $this->addJoinObject($join, 'Moves');
        }

        return $this;
    }

    /**
     * Use the Moves relation Moves object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\MovesQuery A secondary query class using the current class as primary query
     */
    public function useMovesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMoves($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Moves', '\Propel\PtuToolkit\MovesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPokedexMoves $pokedexMoves Object to remove from the list of results
     *
     * @return $this|ChildPokedexMovesQuery The current query, for fluid interface
     */
    public function prune($pokedexMoves = null)
    {
        if ($pokedexMoves) {
            $this->addUsingAlias(PokedexMovesTableMap::COL_POKEDEX_MOVE_ID, $pokedexMoves->getPokedexMoveId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pokedex_moves table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PokedexMovesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PokedexMovesTableMap::clearInstancePool();
            PokedexMovesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PokedexMovesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PokedexMovesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PokedexMovesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PokedexMovesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PokedexMovesQuery
