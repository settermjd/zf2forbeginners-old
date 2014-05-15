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

class AddressTypeModel
{
    public $addressTypeId;
    public $addressType;
    public $notes;

    public function exchangeArray($data)
    {
        $this->addressTypeId = (isset($data['addressTypeId'])) ? $data['addressTypeId'] : null;
        $this->addressType = (isset($data['addressType'])) ? $data['addressType'] : null;
        $this->notes = (isset($data['notes'])) ? $data['notes'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}