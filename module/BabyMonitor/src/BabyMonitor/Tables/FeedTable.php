<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 5.4
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Client/Author
 * @see        Enter if required
 * @since      File available since Release/Tag:
 */

namespace BabyMonitor\Tables;

use BabyMonitor\Models\FeedModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where as WherePredicate;
use Zend\Stdlib\ArrayObject;

class FeedTable
{
    const DATETIME_FORMAT = 'Y-m-d';

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchById($feedId)
    {
        if (!empty($feedId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array("feedId" => (int)$feedId));
            $results = $this->tableGateway->selectWith($select);

            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    /**
     * Attempts to delete a feed item
     *
     * @param $feedId
     * @return bool|int
     */
    public function delete($feedId)
    {
        if (!empty($feedId)) {
            return $this->tableGateway->delete(array(
                "feedId" => (int)$feedId
            ));
        }

        return false;
    }

    /**
     * Return X most recent feeds
     *
     * @param int $limit The limit of records returned. Defaults to 5
     * @return bool|null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchMostRecentFeeds($limit = 5)
    {
        if (!empty($limit)) {
            $select = $this->tableGateway->getSql()->select();
            $select->limit((int)$limit)
                   ->order('feedDate DESC, feedTime DESC');
            $results = $this->tableGateway->selectWith($select);

            return $results->buffer();
        }

        return false;
    }

    public function fetchByDateRange(\DateTime $startDate = null, \DateTime $endDate = null)
    {
        $select = $this->tableGateway->getSql()->select();
        $where = new WherePredicate();
        $whereClause = array();

        if (!is_null($startDate)) {
            $whereClause[] = $where->greaterThanOrEqualTo(
                'feedDate', $startDate->format(self::DATETIME_FORMAT)
            );
        }

        if (!is_null($endDate)) {
            $whereClause[] = $where->lessThanOrEqualTo(
                'feedDate', $endDate->format(self::DATETIME_FORMAT)
            );
        }

        $select->where($whereClause)->order("feedDate DESC, feedTime DESC");

        $results = $this->tableGateway->selectWith($select);

        return $results->buffer();
    }

    public function save(FeedModel $feed)
    {
        $data = array(
            'userId' => $feed->userId,
            'feedDate' => $feed->feedDate,
            'feedTime' => $feed->feedTime,
            'feedAmount' => $feed->feedAmount,
            'feedNotes' => $feed->feedNotes,
            'feedTemperature' => $feed->feedTemperature,
        );
        $feedId = (int)$feed->feedId;

        if ($feedId == 0) {
            if ($this->tableGateway->insert($data)) {
                return $this->tableGateway->getLastInsertValue();
            }
        } else {
            if ($retstat = $this->tableGateway->update($data, array('feedId' => $feedId))) {
                return $retstat;
            }
        }
    }
}
