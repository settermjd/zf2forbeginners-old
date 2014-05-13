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

class FeedModel
{
    public $userId;
    public $feedId;
    public $feedDateTime;
    public $feedAmount;
    public $feedTemperature;
    public $feedNotes;

    public function exchangeArray($data)
    {
        $this->userId = (isset($data['userId'])) ? $data['userId'] : null;
        $this->feedId = (isset($data['feedId'])) ? $data['feedId'] : null;
        $this->feedDateTime = (isset($data['feedDateTime'])) ? $data['feedDateTime'] : null;
        $this->feedAmount = (isset($data['feedAmount'])) ? $data['feedAmount'] : null;
        $this->feedTemperature = (isset($data['feedTemperature'])) ? $data['feedTemperature'] : null;
        $this->feedNotes = (isset($data['feedNotes'])) ? $data['feedNotes'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}