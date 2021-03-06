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

use BabyMonitor\Models\CountryModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\ArrayObject;

class CountryTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchByCountryId($countryId)
    {
        if (!empty($countryId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array("countryId" => (int)$countryId));
            $results = $this->tableGateway->selectWith($select);

            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    public function save(CountryModel $country)
    {
        $data = array(
            'countryName'  => $country->countryName,
            'countryCode'  => $country->countryCode,
        );
        $countryId = (int)$country->countryId;

        if ($countryId == 0) {
            if ($this->tableGateway->insert($data)) {
                return $this->tableGateway->getLastInsertValue();
            }
        } else {
            if ($retstat = $this->tableGateway->update($data, array('countryId' => $countryId))) {
                return $retstat;
            }
        }
    }
}