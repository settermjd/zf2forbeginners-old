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

class AddressModel
{
    public $addressId;
    public $addressTypeId;
    public $addressOne;
    public $addressTwo;
    public $city;
    public $state;
    public $postCode;
    public $countryId;

    public function exchangeArray($data)
    {
        $this->addressId = (isset($data['addressId'])) ? $data['addressId'] : null;
        $this->addressTypeId = (isset($data['addressTypeId'])) ? $data['addressTypeId'] : null;
        $this->addressOne = (isset($data['addressOne'])) ? $data['addressOne'] : null;
        $this->addressTwo = (isset($data['addressTwo'])) ? $data['addressTwo'] : null;
        $this->city = (isset($data['city'])) ? $data['city'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
        $this->postCode = (isset($data['postCode'])) ? $data['postCode'] : null;
        $this->countryId = (isset($data['countryId'])) ? $data['countryId'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}