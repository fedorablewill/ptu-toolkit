<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\Campaigns as ChildCampaigns;
use Propel\PtuToolkit\CampaignsQuery as ChildCampaignsQuery;
use Propel\PtuToolkit\Map\CampaignsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'campaigns' table.
 *
 *
 *
 * @method     ChildCampaignsQuery orderByCampaignId($order = Criteria::ASC) Order by the campaign_id column
 * @method     ChildCampaignsQuery orderByUserFirebaseId($order = Criteria::ASC) Order by the user_firebase_id column
 * @method     ChildCampaignsQuery orderByCampaignName($order = Criteria::ASC) Order by the campaign_name column
 * @method     ChildCampaignsQuery orderByCampaignData($order = Criteria::ASC) Order by the campaign_data column
 *
 * @method     ChildCampaignsQuery groupByCampaignId() Group by the campaign_id column
 * @method     ChildCampaignsQuery groupByUserFirebaseId() Group by the user_firebase_id column
 * @method     ChildCampaignsQuery groupByCampaignName() Group by the campaign_name column
 * @method     ChildCampaignsQuery groupByCampaignData() Group by the campaign_data column
 *
 * @method     ChildCampaignsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCampaignsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCampaignsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCampaignsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCampaignsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCampaignsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCampaignsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildCampaignsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildCampaignsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildCampaignsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildCampaignsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildCampaignsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildCampaignsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildCampaignsQuery leftJoinBattles($relationAlias = null) Adds a LEFT JOIN clause to the query using the Battles relation
 * @method     ChildCampaignsQuery rightJoinBattles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Battles relation
 * @method     ChildCampaignsQuery innerJoinBattles($relationAlias = null) Adds a INNER JOIN clause to the query using the Battles relation
 *
 * @method     ChildCampaignsQuery joinWithBattles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Battles relation
 *
 * @method     ChildCampaignsQuery leftJoinWithBattles() Adds a LEFT JOIN clause and with to the query using the Battles relation
 * @method     ChildCampaignsQuery rightJoinWithBattles() Adds a RIGHT JOIN clause and with to the query using the Battles relation
 * @method     ChildCampaignsQuery innerJoinWithBattles() Adds a INNER JOIN clause and with to the query using the Battles relation
 *
 * @method     ChildCampaignsQuery leftJoinCharacters($relationAlias = null) Adds a LEFT JOIN clause to the query using the Characters relation
 * @method     ChildCampaignsQuery rightJoinCharacters($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Characters relation
 * @method     ChildCampaignsQuery innerJoinCharacters($relationAlias = null) Adds a INNER JOIN clause to the query using the Characters relation
 *
 * @method     ChildCampaignsQuery joinWithCharacters($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Characters relation
 *
 * @method     ChildCampaignsQuery leftJoinWithCharacters() Adds a LEFT JOIN clause and with to the query using the Characters relation
 * @method     ChildCampaignsQuery rightJoinWithCharacters() Adds a RIGHT JOIN clause and with to the query using the Characters relation
 * @method     ChildCampaignsQuery innerJoinWithCharacters() Adds a INNER JOIN clause and with to the query using the Characters relation
 *
 * @method     \Propel\PtuToolkit\UsersQuery|\Propel\PtuToolkit\BattlesQuery|\Propel\PtuToolkit\CharactersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCampaigns findOne(ConnectionInterface $con = null) Return the first ChildCampaigns matching the query
 * @method     ChildCampaigns findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCampaigns matching the query, or a new ChildCampaigns object populated from the query conditions when no match is found
 *
 * @method     ChildCampaigns findOneByCampaignId(int $campaign_id) Return the first ChildCampaigns filtered by the campaign_id column
 * @method     ChildCampaigns findOneByUserFirebaseId(string $user_firebase_id) Return the first ChildCampaigns filtered by the user_firebase_id column
 * @method     ChildCampaigns findOneByCampaignName(string $campaign_name) Return the first ChildCampaigns filtered by the campaign_name column
 * @method     ChildCampaigns findOneByCampaignData(string $campaign_data) Return the first ChildCampaigns filtered by the campaign_data column *

 * @method     ChildCampaigns requirePk($key, ConnectionInterface $con = null) Return the ChildCampaigns by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaigns requireOne(ConnectionInterface $con = null) Return the first ChildCampaigns matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCampaigns requireOneByCampaignId(int $campaign_id) Return the first ChildCampaigns filtered by the campaign_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaigns requireOneByUserFirebaseId(string $user_firebase_id) Return the first ChildCampaigns filtered by the user_firebase_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaigns requireOneByCampaignName(string $campaign_name) Return the first ChildCampaigns filtered by the campaign_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaigns requireOneByCampaignData(string $campaign_data) Return the first ChildCampaigns filtered by the campaign_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCampaigns[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCampaigns objects based on current ModelCriteria
 * @method     ChildCampaigns[]|ObjectCollection findByCampaignId(int $campaign_id) Return ChildCampaigns objects filtered by the campaign_id column
 * @method     ChildCampaigns[]|ObjectCollection findByUserFirebaseId(string $user_firebase_id) Return ChildCampaigns objects filtered by the user_firebase_id column
 * @method     ChildCampaigns[]|ObjectCollection findByCampaignName(string $campaign_name) Return ChildCampaigns objects filtered by the campaign_name column
 * @method     ChildCampaigns[]|ObjectCollection findByCampaignData(string $campaign_data) Return ChildCampaigns objects filtered by the campaign_data column
 * @method     ChildCampaigns[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CampaignsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\CampaignsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\Campaigns', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCampaignsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCampaignsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCampaignsQuery) {
            return $criteria;
        }
        $query = new ChildCampaignsQuery();
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
     * @return ChildCampaigns|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CampaignsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CampaignsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCampaigns A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT campaign_id, user_firebase_id, campaign_name, campaign_data FROM campaigns WHERE campaign_id = :p0';
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
            /** @var ChildCampaigns $obj */
            $obj = new ChildCampaigns();
            $obj->hydrate($row);
            CampaignsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCampaigns|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the campaign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCampaignId(1234); // WHERE campaign_id = 1234
     * $query->filterByCampaignId(array(12, 34)); // WHERE campaign_id IN (12, 34)
     * $query->filterByCampaignId(array('min' => 12)); // WHERE campaign_id > 12
     * </code>
     *
     * @param     mixed $campaignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByCampaignId($campaignId = null, $comparison = null)
    {
        if (is_array($campaignId)) {
            $useMinMax = false;
            if (isset($campaignId['min'])) {
                $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $campaignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($campaignId['max'])) {
                $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $campaignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $campaignId, $comparison);
    }

    /**
     * Filter the query on the user_firebase_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserFirebaseId('fooValue');   // WHERE user_firebase_id = 'fooValue'
     * $query->filterByUserFirebaseId('%fooValue%', Criteria::LIKE); // WHERE user_firebase_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userFirebaseId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByUserFirebaseId($userFirebaseId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userFirebaseId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignsTableMap::COL_USER_FIREBASE_ID, $userFirebaseId, $comparison);
    }

    /**
     * Filter the query on the campaign_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCampaignName('fooValue');   // WHERE campaign_name = 'fooValue'
     * $query->filterByCampaignName('%fooValue%', Criteria::LIKE); // WHERE campaign_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $campaignName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByCampaignName($campaignName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($campaignName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_NAME, $campaignName, $comparison);
    }

    /**
     * Filter the query on the campaign_data column
     *
     * @param     mixed $campaignData The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByCampaignData($campaignData = null, $comparison = null)
    {

        return $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_DATA, $campaignData, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Users object
     *
     * @param \Propel\PtuToolkit\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Propel\PtuToolkit\Users) {
            return $this
                ->addUsingAlias(CampaignsTableMap::COL_USER_FIREBASE_ID, $users->getFirebaseId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CampaignsTableMap::COL_USER_FIREBASE_ID, $users->toKeyValue('PrimaryKey', 'FirebaseId'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Propel\PtuToolkit\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\Propel\PtuToolkit\UsersQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Battles object
     *
     * @param \Propel\PtuToolkit\Battles|ObjectCollection $battles the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByBattles($battles, $comparison = null)
    {
        if ($battles instanceof \Propel\PtuToolkit\Battles) {
            return $this
                ->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $battles->getCampaignId(), $comparison);
        } elseif ($battles instanceof ObjectCollection) {
            return $this
                ->useBattlesQuery()
                ->filterByPrimaryKeys($battles->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
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
     * @param \Propel\PtuToolkit\Characters|ObjectCollection $characters the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCampaignsQuery The current query, for fluid interface
     */
    public function filterByCharacters($characters, $comparison = null)
    {
        if ($characters instanceof \Propel\PtuToolkit\Characters) {
            return $this
                ->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $characters->getCampaignId(), $comparison);
        } elseif ($characters instanceof ObjectCollection) {
            return $this
                ->useCharactersQuery()
                ->filterByPrimaryKeys($characters->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
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
     * @param   ChildCampaigns $campaigns Object to remove from the list of results
     *
     * @return $this|ChildCampaignsQuery The current query, for fluid interface
     */
    public function prune($campaigns = null)
    {
        if ($campaigns) {
            $this->addUsingAlias(CampaignsTableMap::COL_CAMPAIGN_ID, $campaigns->getCampaignId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the campaigns table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CampaignsTableMap::clearInstancePool();
            CampaignsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CampaignsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CampaignsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CampaignsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CampaignsQuery
