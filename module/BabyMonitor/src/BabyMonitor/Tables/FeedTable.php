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
use Zend\Stdlib\ArrayObject;

class FeedTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchByUserId($feedId)
    {
        if (!empty($feedId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array("UserId" => (int)$feedId));
            $results = $this->tableGateway->selectWith($select);

            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    /**
     * Return X most recent feeds
     * 
     * @param $limit
     * @return bool|null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function fetchMostRecentFeeds($limit)
    {
        if (!empty($limit)) {
            $select = $this->tableGateway->getSql()->select();
            $select->limit((int)$limit)
                   ->order('feedDateTime DESC');
            $results = $this->tableGateway->selectWith($select);

            return $results;
        }

        return false;
    }

    public function save(FeedModel $feed)
    {
        $data = array(
            'userId' => $feed->userId,
            'feedDateTime' => $feed->feedDateTime,
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