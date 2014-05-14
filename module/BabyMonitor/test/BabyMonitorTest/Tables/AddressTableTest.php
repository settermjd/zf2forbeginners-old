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

namespace BabyMonitor\test\BabyMonitorTest\Tables;

use BabyMonitor\Models\AddressModel,
    BabyMonitor\Tables\AddressTable;
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Select;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class AddressTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'addressId' => 1,
        'addressTypeId'  => 1,
        'addressOne'  => "1 Queen St",
        'addressTwo'  => "",
        'city'  => "Brisbane",
        'state'  => "Qld",
        'postCode'  => "4000",
        'countryId'  => 61,
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByAddressId()
    {
        $resultSet = new ResultSet();
        $record = new AddressModel();
        $record->exchangeArray($this->_recordData);
        $addressId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('addressId' => $addressId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockAddressTable = new AddressTable($mockTableGateway);

        $this->assertEquals($record, $mockAddressTable->fetchByAddressId($addressId));
    }

    public function testSaveAddressWillInsertNewAddresssIfTheyDoNotAlreadyHaveAnId()
    {
        $address = new AddressModel();
        $recordData = $this->_recordData;
        unset($recordData['addressId']);
        $address->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'addressTypeId'  => 1,
                'addressOne'  => "1 Queen St",
                'addressTwo'  => "",
                'city'  => "Brisbane",
                'state'  => "Qld",
                'postCode'  => "4000",
                'countryId'  => 61,
            ));

        $addressTable = new AddressTable($mockTableGateway);
        $addressTable->save($address);
    }

    public function testSaveAddressWillUpdateExistingAddresssIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $addressId = $recordData['addressId'];
        unset($recordData['addressId']);
        $address = new AddressModel();
        $address->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new AddressModel());
        $resultSet->initialize(array($address));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'addressTypeId'  => 1,
            'addressOne'  => "1 Queen St",
            'addressTwo'  => "",
            'city'  => "Brisbane",
            'state'  => "Qld",
            'postCode'  => "4000",
            'countryId'  => 61,
        ), array('addressId' => $addressId))->andReturn($this->_recordData);

        $addressTable = new AddressTable($mockTableGateway);
        $addressTable->save($address, $addressId);
    }

}