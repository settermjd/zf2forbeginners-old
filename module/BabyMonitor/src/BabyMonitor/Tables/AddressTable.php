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

use BabyMonitor\Models\AddressModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\ArrayObject;

class AddressTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchByAddressId($addressId)
    {
        if (!empty($addressId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array("addressId" => (int)$addressId));
            $results = $this->tableGateway->selectWith($select);

            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    public function save(AddressModel $address)
    {
        $data = array(
            'addressTypeId'  => $address->addressTypeId,
            'addressOne'  => $address->addressOne,
            'addressTwo'  => $address->addressTwo,
            'city'  => $address->city,
            'state'  => $address->state,
            'postCode'  => $address->postCode,
            'countryId'  => $address->countryId,
        );
        $addressId = (int)$address->addressId;

        if ($addressId == 0) {
            if ($this->tableGateway->insert($data)) {
                return $this->tableGateway->getLastInsertValue();
            }
        } else {
            if ($retstat = $this->tableGateway->update($data, array('addressId' => $addressId))) {
                return $retstat;
            }
        }
    }
}