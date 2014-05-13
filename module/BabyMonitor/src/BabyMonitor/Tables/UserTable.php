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

use BabyMonitor\Models\UserModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\ArrayObject;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchByUserId($userId)
    {
        if (!empty($userId)) {
            $select = $this->tableGateway->getSql()->select();
            $select->where(array("UserId" => (int)$userId));
            $results = $this->tableGateway->selectWith($select);

            if ($results->count() == 1) {
                return $results->current();
            }
        }

        return false;
    }

    public function saveUser(UserModel $user)
    {
        $data = array(
            'Username' => $user->username,
            'FirstName' => $user->firstName,
            'LastName' => $user->lastName,
            'AddressId' => $user->addressId,
            'StatusId' => $user->statusId,
            'Notes' => $user->notes,
        );

        $userId = (int)$user->userId;

        if ($userId == 0) {
            if ($this->tableGateway->insert($data)) {
                return $this->tableGateway->getLastInsertValue();
            }
        } else {
            if ($retstat = $this->tableGateway->update($data, array('UserId' => $userId))) {
                return $retstat;
            }
        }
    }
}