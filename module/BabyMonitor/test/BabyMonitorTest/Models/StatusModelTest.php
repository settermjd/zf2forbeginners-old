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

namespace BabyMonitor\test\BabyMonitorTest\Models;

use BabyMonitor\Models\StatusModel;
use PHPUnit_Framework_TestCase;

class StatusModelTest extends PHPUnit_Framework_TestCase
{
    protected $statusModel;
    protected $_testData;

    public function setUp()
    {
        $this->statusModel = new StatusModel();
        $this->_testData = array(
            'statusId' => 1,
            'status'  => "Active",
        );
    }

    public function testEventTypeInitialRsvpListItem()
    {
        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->statusModel->$property, "$property should initially be null");
        }
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $this->statusModel->exchangeArray($this->_testData);

        foreach ($this->_testData as $property => $value) {
            $this->assertSame(
                $value,
                $this->statusModel->$property,
                "$property was not set correctly"
            );
        }
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->statusModel->exchangeArray(array());

        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->statusModel->$property, "$property should have defaulted to null");
        }
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $this->statusModel->exchangeArray($this->_testData);
        $copyArray = $this->statusModel->getArrayCopy();

        foreach ($this->_testData as $property => $value) {
            $this->assertSame($value, $copyArray[$property], "$property was not set correctly");
        }
    }
}