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

use BabyMonitor\Models\AddressModel;
use PHPUnit_Framework_TestCase;

class AddressModelTest extends PHPUnit_Framework_TestCase
{
    protected $addressModel;
    protected $_testData;

    public function setUp()
    {
        $this->addressModel = new AddressModel();
        $this->_testData = array(
            'addressId' => 1,
            'addressTypeId'  => 1,
            'addressOne'  => "1 Queen St",
            'addressTwo'  => "",
            'city'  => "Brisbane",
            'state'  => "Qld",
            'postCode'  => "4000",
            'countryId'  => 61,
        );
    }

    public function testEventTypeInitialRsvpListItem()
    {
        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->addressModel->$property, "$property should initially be null");
        }
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $this->addressModel->exchangeArray($this->_testData);

        foreach ($this->_testData as $property => $value) {
            $this->assertSame(
                $value,
                $this->addressModel->$property,
                "$property was not set correctly"
            );
        }
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->addressModel->exchangeArray(array());

        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->addressModel->$property, "$property should have defaulted to null");
        }
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $this->addressModel->exchangeArray($this->_testData);
        $copyArray = $this->addressModel->getArrayCopy();

        foreach ($this->_testData as $property => $value) {
            $this->assertSame($value, $copyArray[$property], "$property was not set correctly");
        }
    }
}