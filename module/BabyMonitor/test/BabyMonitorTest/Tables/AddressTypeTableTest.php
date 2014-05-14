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

use BabyMonitor\Models\AddressTypeModel,
    BabyMonitor\Tables\AddressTypeTable;
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Select;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class AddressTypeTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'addressTypeId'  => 1,
        'addressType'  => "Residential",
        'notes'  => "",
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByAddressId()
    {
        $resultSet = new ResultSet();
        $record = new AddressTypeModel();
        $record->exchangeArray($this->_recordData);
        $addressTypeId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('addressTypeId' => $addressTypeId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockAddressTypeTable = new AddressTypeTable($mockTableGateway);

        $this->assertEquals($record, $mockAddressTypeTable->fetchByAddressTypeId($addressTypeId));
    }

    public function testSaveAddressWillInsertNewAddresssIfTheyDoNotAlreadyHaveAnId()
    {
        $address = new AddressTypeModel();
        $recordData = $this->_recordData;
        unset($recordData['addressTypeId']);
        $address->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'addressType'  => "Residential",
                'notes'  => "",
            ));

        $addressTable = new AddressTypeTable($mockTableGateway);
        $addressTable->save($address);
    }

    public function testSaveAddressWillUpdateExistingAddresssIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $addressTypeId = $recordData['addressTypeId'];
        unset($recordData['addressTypeId']);
        $address = new AddressTypeModel();
        $address->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new AddressTypeModel());
        $resultSet->initialize(array($address));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'addressType'  => "Residential",
            'notes'  => "",
        ), array('addressTypeId' => $addressTypeId))->andReturn($this->_recordData);

        $addressTable = new AddressTypeTable($mockTableGateway);
        $addressTable->save($address, $addressTypeId);
    }

}