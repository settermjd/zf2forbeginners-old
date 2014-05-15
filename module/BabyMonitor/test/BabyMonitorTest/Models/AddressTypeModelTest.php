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

use BabyMonitor\Models\AddressTypeModel;
use PHPUnit_Framework_TestCase;

class AddressTypeModelTest extends PHPUnit_Framework_TestCase
{
    protected $addressTypeModel;
    protected $_testData;

    public function setUp()
    {
        $this->addressTypeModel = new AddressTypeModel();
        $this->_testData = array(
            'addressTypeId' => 1,
            'addressType'  => "Residential",
            'notes'  => "",
        );
    }

    public function testEventTypeInitialRsvpListItem()
    {
        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->addressTypeModel->$property, "$property should initially be null");
        }
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $this->addressTypeModel->exchangeArray($this->_testData);

        foreach ($this->_testData as $property => $value) {
            $this->assertSame(
                $value,
                $this->addressTypeModel->$property,
                "$property was not set correctly"
            );
        }
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->addressTypeModel->exchangeArray(array());

        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->addressTypeModel->$property, "$property should have defaulted to null");
        }
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $this->addressTypeModel->exchangeArray($this->_testData);
        $copyArray = $this->addressTypeModel->getArrayCopy();

        foreach ($this->_testData as $property => $value) {
            $this->assertSame($value, $copyArray[$property], "$property was not set correctly");
        }
    }
}