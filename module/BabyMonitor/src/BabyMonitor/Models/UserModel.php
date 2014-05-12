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

namespace BabyMonitor\Models;

class UserModel
{
    public $userId;
    public $username;
    public $firstName;
    public $lastName;
    public $addressId;
    public $statusId;
    public $notes;

    public function exchangeArray($data)
    {
        $this->userId = (isset($data['userId'])) ? $data['userId'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->firstName = (isset($data['firstName'])) ? $data['firstName'] : null;
        $this->lastName = (isset($data['lastName'])) ? $data['lastName'] : null;
        $this->addressId = (isset($data['addressId'])) ? $data['addressId'] : null;
        $this->statusId = (isset($data['statusId'])) ? $data['statusId'] : null;
        $this->notes = (isset($data['notes'])) ? $data['notes'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}