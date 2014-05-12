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

use BabyMonitor\Models\UserModel;
use PHPUnit_Framework_TestCase;

class UserModelTest extends PHPUnit_Framework_TestCase
{
    protected $userModel;
    protected $_testData;

    public function setUp()
    {
        $this->userModel = new UserModel();
        $this->_testData = array(
            'userId' => 21,
            'username'  => "matthew@maltblue.com",
            'firstName'  => "Matthew",
            'lastName'  => "Setter",
            'addressId'  => 21,
            'statusId'  => 14,
            'notes'  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius.",
        );
    }

    public function testEventTypeInitialRsvpListItem()
    {
        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->userModel->$property, "$property should initially be null");
        }
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $this->userModel->exchangeArray($this->_testData);

        foreach ($this->_testData as $property => $value) {
            $this->assertSame(
                $value,
                $this->userModel->$property,
                "$property was not set correctly"
            );
        }
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $this->userModel->exchangeArray(array());

        foreach (array_keys($this->_testData) as $property) {
            $this->assertNull($this->userModel->$property, "$property should have defaulted to null");
        }
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $this->userModel->exchangeArray($this->_testData);
        $copyArray = $this->userModel->getArrayCopy();

        foreach ($this->_testData as $property => $value) {
            $this->assertSame($value, $copyArray[$property], "$property was not set correctly");
        }
    }
}