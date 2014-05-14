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

use BabyMonitor\Models\CountryModel;
use PHPUnit_Framework_TestCase;

class CountryModelTest extends PHPUnit_Framework_TestCase
{
    protected $countryModel;
    protected $_testData;

    public function setUp()
    {
        $this->countryModel = new CountryModel();
        $this->_testData = array(
            'countryId' => 1,
            'countryName'  => "Australia",
            'countryCode'  => "AUS",
        );
    }

    public function testEventTypeInitialRsvpListItem()
    {
        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->countryModel->$property, "$property should initially be null");
        }
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $this->countryModel->exchangeArray($this->_testData);

        foreach ($this->_testData as $property => $value) {
            $this->assertSame(
                $value,
                $this->countryModel->$property,
                "$property was not set correctly"
            );
        }
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->countryModel->exchangeArray(array());

        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->countryModel->$property, "$property should have defaulted to null");
        }
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $this->countryModel->exchangeArray($this->_testData);
        $copyArray = $this->countryModel->getArrayCopy();

        foreach ($this->_testData as $property => $value) {
            $this->assertSame($value, $copyArray[$property], "$property was not set correctly");
        }
    }
}