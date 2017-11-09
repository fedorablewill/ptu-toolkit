<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\CharacterMoves as ChildCharacterMoves;
use Propel\PtuToolkit\CharacterMovesQuery as ChildCharacterMovesQuery;
use Propel\PtuToolkit\Map\CharacterMovesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'character_moves' table.
 *
 *
 *
 * @method     ChildCharacterMovesQuery orderByCharacterMoveId($order = Criteria::ASC) Order by the character_move_id column
 * @method     ChildCharacterMovesQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildCharacterMovesQuery orderByMoveId($order = Criteria::ASC) Order by the move_id column
 * @method     ChildCharacterMovesQuery orderByMoveName($order = Criteria::ASC) Order by the move_name column
 *
 * @method     ChildCharacterMovesQuery groupByCharacterMoveId() Group by the character_move_id column
 * @method     ChildCharacterMovesQuery groupByCharacterId() Group by the character_id column
 * @method     ChildCharacterMovesQuery groupByMoveId() Group by the move_id column
 * @method     ChildCharacterMovesQuery groupByMoveName() Group by the move_name column
 *
 * @method     ChildCharacterMovesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCharacterMovesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCharacterMovesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCharacterMovesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCharacterMovesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCharacterMovesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCharacterMovesQuery leftJoinCharacters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Characters relation
 * @method     ChildCharacterMovesQuery rightJoinCharacters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Characters relation
 * @method     ChildCharacterMovesQuery innerJoinCharacters($relationAlias = null) Adds a INNER JOIN clause to the query using the Characters relation
 *
 * @method     ChildCharacterMovesQuery joinWithCharacters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Characters relation
 *
 * @method     ChildCharacterMovesQuery leftJoinWithCharacters() Adds a LEFT JOIN clause and with to the query using the Characters relation
 * @method     ChildCharacterMovesQuery rightJoinWithCharacters() Adds a RIGHT JOIN clause and with to the query using the Characters relation
 * @method     ChildCharacterMovesQuery innerJoinWithCharacters() Adds a INNER JOIN clause and with to the query using the Characters relation
 *
 * @method     ChildCharacterMovesQuery leftJoinMoves($relationAlias = null) Adds a LEFT JOIN clause to the query using the Moves relation
 * @method     ChildCharacterMovesQuery rightJoinMoves($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Moves relation
 * @method     ChildCharacterMovesQuery innerJoinMoves($relationAlias = null) Adds a INNER JOIN clause to the query using the Moves relation
 *
 * @method     ChildCharacterMovesQuery joinWithMoves($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Moves relation
 *
 * @method     ChildCharacterMovesQuery leftJoinWithMoves() Adds a LEFT JOIN clause and with to the query using the Moves relation
 * @method     ChildCharacterMovesQuery rightJoinWithMoves() Adds a RIGHT JOIN clause and with to the query using the Moves relation
 * @method     ChildCharacterMovesQuery innerJoinWithMoves() Adds a INNER JOIN clause and with to the query using the Moves relation
 *
 * @method     \Propel\PtuToolkit\CharactersQuery|\Propel\PtuToolkit\MovesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCharacterMoves findOne(ConnectionInterface $con = null) Return the first ChildCharacterMoves matching the query
 * @method     ChildCharacterMoves findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCharacterMoves matching the query, or a new ChildCharacterMoves object populated from the query conditions when no match is found
 *
 * @method     ChildCharacterMoves findOneByCharacterMoveId(int $character_move_id) Return the first ChildCharacterMoves filtered by the character_move_id column
 * @method     ChildCharacterMoves findOneByCharacterId(int $character_id) Return the first ChildCharacterMoves filtered by the character_id column
 * @method     ChildCharacterMoves findOneByMoveId(int $move_id) Return the first ChildCharacterMoves filtered by the move_id column
 * @method     ChildCharacterMoves findOneByMoveName(string $move_name) Return the first ChildCharacterMoves filtered by the move_name column *

 * @method     ChildCharacterMoves requirePk($key, ConnectionInterface $con = null) Return the ChildCharacterMoves by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterMoves requireOne(ConnectionInterface $con = null) Return the first ChildCharacterMoves matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacterMoves requireOneByCharacterMoveId(int $character_move_id) Return the first ChildCharacterMoves filtered by the character_move_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterMoves requireOneByCharacterId(int $character_id) Return the first ChildCharacterMoves filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterMoves requireOneByMoveId(int $move_id) Return the first ChildCharacterMoves filtered by the move_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterMoves requireOneByMoveName(string $move_name) Return the first ChildCharacterMoves filtered by the move_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacterMoves[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCharacterMoves objects based on current ModelCriteria
 * @method     ChildCharacterMoves[]|ObjectCollection findByCharacterMoveId(int $character_move_id) Return ChildCharacterMoves objects filtered by the character_move_id column
 * @method     ChildCharacterMoves[]|ObjectCollection findByCharacterId(int $character_id) Return ChildCharacterMoves objects filtered by the character_id column
 * @method     ChildCharacterMoves[]|ObjectCollection findByMoveId(int $move_id) Return ChildCharacterMoves objects filtered by the move_id column
 * @method     ChildCharacterMoves[]|ObjectCollection findByMoveName(string $move_name) Return ChildCharacterMoves objects filtered by the move_name column
 * @method     ChildCharacterMoves[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CharacterMovesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\CharacterMovesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\CharacterMoves', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCharacterMovesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCharacterMovesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCharacterMovesQuery) {
            return $criteria;
        }
        $query = new ChildCharacterMovesQuery();
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
     * @return ChildCharacterMoves|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CharacterMovesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CharacterMovesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCharacterMoves A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT character_move_id, character_id, move_id, move_name FROM character_moves WHERE character_move_id = :p0';
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
            /** @var ChildCharacterMoves $obj */
            $obj = new ChildCharacterMoves();
            $obj->hydrate($row);
            CharacterMovesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCharacterMoves|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the character_move_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterMoveId(1234); // WHERE character_move_id = 1234
     * $query->filterByCharacterMoveId(array(12, 34)); // WHERE character_move_id IN (12, 34)
     * $query->filterByCharacterMoveId(array('min' => 12)); // WHERE character_move_id > 12
     * </code>
     *
     * @param     mixed $characterMoveId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByCharacterMoveId($characterMoveId = null, $comparison = null)
    {
        if (is_array($characterMoveId)) {
            $useMinMax = false;
            if (isset($characterMoveId['min'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $characterMoveId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterMoveId['max'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $characterMoveId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $characterMoveId, $comparison);
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
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_ID, $characterId, $comparison);
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
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByMoveId($moveId = null, $comparison = null)
    {
        if (is_array($moveId)) {
            $useMinMax = false;
            if (isset($moveId['min'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_MOVE_ID, $moveId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moveId['max'])) {
                $this->addUsingAlias(CharacterMovesTableMap::COL_MOVE_ID, $moveId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterMovesTableMap::COL_MOVE_ID, $moveId, $comparison);
    }

    /**
     * Filter the query on the move_name column
     *
     * Example usage:
     * <code>
     * $query->filterByMoveName('fooValue');   // WHERE move_name = 'fooValue'
     * $query->filterByMoveName('%fooValue%', Criteria::LIKE); // WHERE move_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $moveName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByMoveName($moveName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($moveName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterMovesTableMap::COL_MOVE_NAME, $moveName, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Characters object
     *
     * @param \Propel\PtuToolkit\Characters|ObjectCollection $characters The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByCharacters($characters, $comparison = null)
    {
        if ($characters instanceof \Propel\PtuToolkit\Characters) {
            return $this
                ->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_ID, $characters->getCharacterId(), $comparison);
        } elseif ($characters instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_ID, $characters->toKeyValue('PrimaryKey', 'CharacterId'), $comparison);
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
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
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
     * Filter the query by a related \Propel\PtuToolkit\Moves object
     *
     * @param \Propel\PtuToolkit\Moves|ObjectCollection $moves The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function filterByMoves($moves, $comparison = null)
    {
        if ($moves instanceof \Propel\PtuToolkit\Moves) {
            return $this
                ->addUsingAlias(CharacterMovesTableMap::COL_MOVE_ID, $moves->getMoveId(), $comparison);
        } elseif ($moves instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CharacterMovesTableMap::COL_MOVE_ID, $moves->toKeyValue('PrimaryKey', 'MoveId'), $comparison);
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
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function joinMoves($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useMovesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMoves($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Moves', '\Propel\PtuToolkit\MovesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCharacterMoves $characterMoves Object to remove from the list of results
     *
     * @return $this|ChildCharacterMovesQuery The current query, for fluid interface
     */
    public function prune($characterMoves = null)
    {
        if ($characterMoves) {
            $this->addUsingAlias(CharacterMovesTableMap::COL_CHARACTER_MOVE_ID, $characterMoves->getCharacterMoveId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the character_moves table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterMovesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CharacterMovesTableMap::clearInstancePool();
            CharacterMovesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterMovesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CharacterMovesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CharacterMovesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CharacterMovesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CharacterMovesQuery
