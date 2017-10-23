<?php

namespace PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use PtuToolkit\CharacterAbilities as ChildCharacterAbilities;
use PtuToolkit\CharacterAbilitiesQuery as ChildCharacterAbilitiesQuery;
use PtuToolkit\Map\CharacterAbilitiesTableMap;

/**
 * Base class that represents a query for the 'character_abilities' table.
 *
 *
 *
 * @method     ChildCharacterAbilitiesQuery orderByCharacterAbilityId($order = Criteria::ASC) Order by the character_ability_id column
 * @method     ChildCharacterAbilitiesQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildCharacterAbilitiesQuery orderByAbilityId($order = Criteria::ASC) Order by the ability_id column
 * @method     ChildCharacterAbilitiesQuery orderByAbilityName($order = Criteria::ASC) Order by the ability_name column
 *
 * @method     ChildCharacterAbilitiesQuery groupByCharacterAbilityId() Group by the character_ability_id column
 * @method     ChildCharacterAbilitiesQuery groupByCharacterId() Group by the character_id column
 * @method     ChildCharacterAbilitiesQuery groupByAbilityId() Group by the ability_id column
 * @method     ChildCharacterAbilitiesQuery groupByAbilityName() Group by the ability_name column
 *
 * @method     ChildCharacterAbilitiesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCharacterAbilitiesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCharacterAbilitiesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCharacterAbilitiesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCharacterAbilitiesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCharacterAbilitiesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCharacterAbilitiesQuery leftJoinCharacters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Characters relation
 * @method     ChildCharacterAbilitiesQuery rightJoinCharacters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Characters relation
 * @method     ChildCharacterAbilitiesQuery innerJoinCharacters($relationAlias = null) Adds a INNER JOIN clause to the query using the Characters relation
 *
 * @method     ChildCharacterAbilitiesQuery joinWithCharacters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Characters relation
 *
 * @method     ChildCharacterAbilitiesQuery leftJoinWithCharacters() Adds a LEFT JOIN clause and with to the query using the Characters relation
 * @method     ChildCharacterAbilitiesQuery rightJoinWithCharacters() Adds a RIGHT JOIN clause and with to the query using the Characters relation
 * @method     ChildCharacterAbilitiesQuery innerJoinWithCharacters() Adds a INNER JOIN clause and with to the query using the Characters relation
 *
 * @method     \PtuToolkit\CharactersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCharacterAbilities findOne(ConnectionInterface $con = null) Return the first ChildCharacterAbilities matching the query
 * @method     ChildCharacterAbilities findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCharacterAbilities matching the query, or a new ChildCharacterAbilities object populated from the query conditions when no match is found
 *
 * @method     ChildCharacterAbilities findOneByCharacterAbilityId(int $character_ability_id) Return the first ChildCharacterAbilities filtered by the character_ability_id column
 * @method     ChildCharacterAbilities findOneByCharacterId(int $character_id) Return the first ChildCharacterAbilities filtered by the character_id column
 * @method     ChildCharacterAbilities findOneByAbilityId(int $ability_id) Return the first ChildCharacterAbilities filtered by the ability_id column
 * @method     ChildCharacterAbilities findOneByAbilityName(string $ability_name) Return the first ChildCharacterAbilities filtered by the ability_name column *

 * @method     ChildCharacterAbilities requirePk($key, ConnectionInterface $con = null) Return the ChildCharacterAbilities by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterAbilities requireOne(ConnectionInterface $con = null) Return the first ChildCharacterAbilities matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacterAbilities requireOneByCharacterAbilityId(int $character_ability_id) Return the first ChildCharacterAbilities filtered by the character_ability_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterAbilities requireOneByCharacterId(int $character_id) Return the first ChildCharacterAbilities filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterAbilities requireOneByAbilityId(int $ability_id) Return the first ChildCharacterAbilities filtered by the ability_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCharacterAbilities requireOneByAbilityName(string $ability_name) Return the first ChildCharacterAbilities filtered by the ability_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCharacterAbilities[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCharacterAbilities objects based on current ModelCriteria
 * @method     ChildCharacterAbilities[]|ObjectCollection findByCharacterAbilityId(int $character_ability_id) Return ChildCharacterAbilities objects filtered by the character_ability_id column
 * @method     ChildCharacterAbilities[]|ObjectCollection findByCharacterId(int $character_id) Return ChildCharacterAbilities objects filtered by the character_id column
 * @method     ChildCharacterAbilities[]|ObjectCollection findByAbilityId(int $ability_id) Return ChildCharacterAbilities objects filtered by the ability_id column
 * @method     ChildCharacterAbilities[]|ObjectCollection findByAbilityName(string $ability_name) Return ChildCharacterAbilities objects filtered by the ability_name column
 * @method     ChildCharacterAbilities[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CharacterAbilitiesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PtuToolkit\Base\CharacterAbilitiesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PtuToolkit\\CharacterAbilities', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCharacterAbilitiesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCharacterAbilitiesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCharacterAbilitiesQuery) {
            return $criteria;
        }
        $query = new ChildCharacterAbilitiesQuery();
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
     * @return ChildCharacterAbilities|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CharacterAbilitiesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CharacterAbilitiesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCharacterAbilities A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT character_ability_id, character_id, ability_id, ability_name FROM character_abilities WHERE character_ability_id = :p0';
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
            /** @var ChildCharacterAbilities $obj */
            $obj = new ChildCharacterAbilities();
            $obj->hydrate($row);
            CharacterAbilitiesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCharacterAbilities|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the character_ability_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterAbilityId(1234); // WHERE character_ability_id = 1234
     * $query->filterByCharacterAbilityId(array(12, 34)); // WHERE character_ability_id IN (12, 34)
     * $query->filterByCharacterAbilityId(array('min' => 12)); // WHERE character_ability_id > 12
     * </code>
     *
     * @param     mixed $characterAbilityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByCharacterAbilityId($characterAbilityId = null, $comparison = null)
    {
        if (is_array($characterAbilityId)) {
            $useMinMax = false;
            if (isset($characterAbilityId['min'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $characterAbilityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterAbilityId['max'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $characterAbilityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $characterAbilityId, $comparison);
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
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the ability_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAbilityId(1234); // WHERE ability_id = 1234
     * $query->filterByAbilityId(array(12, 34)); // WHERE ability_id IN (12, 34)
     * $query->filterByAbilityId(array('min' => 12)); // WHERE ability_id > 12
     * </code>
     *
     * @param     mixed $abilityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByAbilityId($abilityId = null, $comparison = null)
    {
        if (is_array($abilityId)) {
            $useMinMax = false;
            if (isset($abilityId['min'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_ABILITY_ID, $abilityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($abilityId['max'])) {
                $this->addUsingAlias(CharacterAbilitiesTableMap::COL_ABILITY_ID, $abilityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_ABILITY_ID, $abilityId, $comparison);
    }

    /**
     * Filter the query on the ability_name column
     *
     * Example usage:
     * <code>
     * $query->filterByAbilityName('fooValue');   // WHERE ability_name = 'fooValue'
     * $query->filterByAbilityName('%fooValue%', Criteria::LIKE); // WHERE ability_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $abilityName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByAbilityName($abilityName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($abilityName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CharacterAbilitiesTableMap::COL_ABILITY_NAME, $abilityName, $comparison);
    }

    /**
     * Filter the query by a related \PtuToolkit\Characters object
     *
     * @param \PtuToolkit\Characters|ObjectCollection $characters The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function filterByCharacters($characters, $comparison = null)
    {
        if ($characters instanceof \PtuToolkit\Characters) {
            return $this
                ->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ID, $characters->getCharacterId(), $comparison);
        } elseif ($characters instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ID, $characters->toKeyValue('PrimaryKey', 'CharacterId'), $comparison);
        } else {
            throw new PropelException('filterByCharacters() only accepts arguments of type \PtuToolkit\Characters or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Characters relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
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
     * @return \PtuToolkit\CharactersQuery A secondary query class using the current class as primary query
     */
    public function useCharactersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacters($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Characters', '\PtuToolkit\CharactersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCharacterAbilities $characterAbilities Object to remove from the list of results
     *
     * @return $this|ChildCharacterAbilitiesQuery The current query, for fluid interface
     */
    public function prune($characterAbilities = null)
    {
        if ($characterAbilities) {
            $this->addUsingAlias(CharacterAbilitiesTableMap::COL_CHARACTER_ABILITY_ID, $characterAbilities->getCharacterAbilityId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the character_abilities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterAbilitiesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CharacterAbilitiesTableMap::clearInstancePool();
            CharacterAbilitiesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterAbilitiesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CharacterAbilitiesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CharacterAbilitiesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CharacterAbilitiesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CharacterAbilitiesQuery
