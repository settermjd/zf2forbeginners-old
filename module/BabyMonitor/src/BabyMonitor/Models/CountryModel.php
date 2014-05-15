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

class CountryModel
{
    public $countryId;
    public $countryName;
    public $countryCode;

    public function exchangeArray($data)
    {
        $this->countryId = (isset($data['countryId'])) ? $data['countryId'] : null;
        $this->countryCode = (isset($data['countryCode'])) ? $data['countryCode'] : null;
        $this->countryName = (isset($data['countryName'])) ? $data['countryName'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}