<?php

namespace Propel\PtuToolkit\Base;

use \Exception;
use \PDO;
use Propel\PtuToolkit\Users as ChildUsers;
use Propel\PtuToolkit\UsersQuery as ChildUsersQuery;
use Propel\PtuToolkit\Map\UsersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method     ChildUsersQuery orderByFirebaseId($order = Criteria::ASC) Order by the firebase_id column
 * @method     ChildUsersQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUsersQuery orderByPeerId($order = Criteria::ASC) Order by the peer_id column
 * @method     ChildUsersQuery orderBySettings($order = Criteria::ASC) Order by the settings column
 *
 * @method     ChildUsersQuery groupByFirebaseId() Group by the firebase_id column
 * @method     ChildUsersQuery groupByUsername() Group by the username column
 * @method     ChildUsersQuery groupByPeerId() Group by the peer_id column
 * @method     ChildUsersQuery groupBySettings() Group by the settings column
 *
 * @method     ChildUsersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUsersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUsersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUsersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUsersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUsersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUsersQuery leftJoinCampaigns($relationAlias = null) Adds a LEFT JOIN clause to the query using the Campaigns relation
 * @method     ChildUsersQuery rightJoinCampaigns($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Campaigns relation
 * @method     ChildUsersQuery innerJoinCampaigns($relationAlias = null) Adds a INNER JOIN clause to the query using the Campaigns relation
 *
 * @method     ChildUsersQuery joinWithCampaigns($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Campaigns relation
 *
 * @method     ChildUsersQuery leftJoinWithCampaigns() Adds a LEFT JOIN clause and with to the query using the Campaigns relation
 * @method     ChildUsersQuery rightJoinWithCampaigns() Adds a RIGHT JOIN clause and with to the query using the Campaigns relation
 * @method     ChildUsersQuery innerJoinWithCampaigns() Adds a INNER JOIN clause and with to the query using the Campaigns relation
 *
 * @method     ChildUsersQuery leftJoinSessions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sessions relation
 * @method     ChildUsersQuery rightJoinSessions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sessions relation
 * @method     ChildUsersQuery innerJoinSessions($relationAlias = null) Adds a INNER JOIN clause to the query using the Sessions relation
 *
 * @method     ChildUsersQuery joinWithSessions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sessions relation
 *
 * @method     ChildUsersQuery leftJoinWithSessions() Adds a LEFT JOIN clause and with to the query using the Sessions relation
 * @method     ChildUsersQuery rightJoinWithSessions() Adds a RIGHT JOIN clause and with to the query using the Sessions relation
 * @method     ChildUsersQuery innerJoinWithSessions() Adds a INNER JOIN clause and with to the query using the Sessions relation
 *
 * @method     \Propel\PtuToolkit\CampaignsQuery|\Propel\PtuToolkit\SessionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUsers findOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query
 * @method     ChildUsers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUsers matching the query, or a new ChildUsers object populated from the query conditions when no match is found
 *
 * @method     ChildUsers findOneByFirebaseId(string $firebase_id) Return the first ChildUsers filtered by the firebase_id column
 * @method     ChildUsers findOneByUsername(string $username) Return the first ChildUsers filtered by the username column
 * @method     ChildUsers findOneByPeerId(string $peer_id) Return the first ChildUsers filtered by the peer_id column
 * @method     ChildUsers findOneBySettings(string $settings) Return the first ChildUsers filtered by the settings column *

 * @method     ChildUsers requirePk($key, ConnectionInterface $con = null) Return the ChildUsers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers requireOneByFirebaseId(string $firebase_id) Return the first ChildUsers filtered by the firebase_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByUsername(string $username) Return the first ChildUsers filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByPeerId(string $peer_id) Return the first ChildUsers filtered by the peer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneBySettings(string $settings) Return the first ChildUsers filtered by the settings column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUsers objects based on current ModelCriteria
 * @method     ChildUsers[]|ObjectCollection findByFirebaseId(string $firebase_id) Return ChildUsers objects filtered by the firebase_id column
 * @method     ChildUsers[]|ObjectCollection findByUsername(string $username) Return ChildUsers objects filtered by the username column
 * @method     ChildUsers[]|ObjectCollection findByPeerId(string $peer_id) Return ChildUsers objects filtered by the peer_id column
 * @method     ChildUsers[]|ObjectCollection findBySettings(string $settings) Return ChildUsers objects filtered by the settings column
 * @method     ChildUsers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UsersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\PtuToolkit\Base\UsersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\PtuToolkit\\Users', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUsersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUsersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUsersQuery) {
            return $criteria;
        }
        $query = new ChildUsersQuery();
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UsersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUsers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT firebase_id, username, peer_id, settings FROM users WHERE firebase_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildUsers $obj */
            $obj = new ChildUsers();
            $obj->hydrate($row);
            UsersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the firebase_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFirebaseId('fooValue');   // WHERE firebase_id = 'fooValue'
     * $query->filterByFirebaseId('%fooValue%', Criteria::LIKE); // WHERE firebase_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firebaseId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByFirebaseId($firebaseId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firebaseId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $firebaseId, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the peer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPeerId('fooValue');   // WHERE peer_id = 'fooValue'
     * $query->filterByPeerId('%fooValue%', Criteria::LIKE); // WHERE peer_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $peerId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPeerId($peerId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($peerId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_PEER_ID, $peerId, $comparison);
    }

    /**
     * Filter the query on the settings column
     *
     * @param     mixed $settings The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterBySettings($settings = null, $comparison = null)
    {

        return $this->addUsingAlias(UsersTableMap::COL_SETTINGS, $settings, $comparison);
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Campaigns object
     *
     * @param \Propel\PtuToolkit\Campaigns|ObjectCollection $campaigns the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByCampaigns($campaigns, $comparison = null)
    {
        if ($campaigns instanceof \Propel\PtuToolkit\Campaigns) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $campaigns->getUserFirebaseId(), $comparison);
        } elseif ($campaigns instanceof ObjectCollection) {
            return $this
                ->useCampaignsQuery()
                ->filterByPrimaryKeys($campaigns->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCampaigns() only accepts arguments of type \Propel\PtuToolkit\Campaigns or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Campaigns relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinCampaigns($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Campaigns');

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
            $this->addJoinObject($join, 'Campaigns');
        }

        return $this;
    }

    /**
     * Use the Campaigns relation Campaigns object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\CampaignsQuery A secondary query class using the current class as primary query
     */
    public function useCampaignsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCampaigns($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Campaigns', '\Propel\PtuToolkit\CampaignsQuery');
    }

    /**
     * Filter the query by a related \Propel\PtuToolkit\Sessions object
     *
     * @param \Propel\PtuToolkit\Sessions|ObjectCollection $sessions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterBySessions($sessions, $comparison = null)
    {
        if ($sessions instanceof \Propel\PtuToolkit\Sessions) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $sessions->getUserFirebaseId(), $comparison);
        } elseif ($sessions instanceof ObjectCollection) {
            return $this
                ->useSessionsQuery()
                ->filterByPrimaryKeys($sessions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySessions() only accepts arguments of type \Propel\PtuToolkit\Sessions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sessions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinSessions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sessions');

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
            $this->addJoinObject($join, 'Sessions');
        }

        return $this;
    }

    /**
     * Use the Sessions relation Sessions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\PtuToolkit\SessionsQuery A secondary query class using the current class as primary query
     */
    public function useSessionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSessions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sessions', '\Propel\PtuToolkit\SessionsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUsers $users Object to remove from the list of results
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function prune($users = null)
    {
        if ($users) {
            $this->addUsingAlias(UsersTableMap::COL_FIREBASE_ID, $users->getFirebaseId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UsersTableMap::clearInstancePool();
            UsersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UsersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UsersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UsersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UsersQuery
