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

use BabyMonitor\Models\StatusModel;
use BabyMonitor\Tables\StatusTable;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class StatusTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'statusId'  => 1,
        'status'  => "Active"
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByAddressId()
    {
        $resultSet = new ResultSet();
        $record = new StatusModel();
        $record->exchangeArray($this->_recordData);
        $statusId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('statusId' => $statusId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockStatusTable = new StatusTable($mockTableGateway);

        $this->assertEquals($record, $mockStatusTable->fetchByStatusId($statusId));
    }

    public function testSaveWillInsertNewIfTheyDoNotAlreadyHaveAnId()
    {
        $status = new StatusModel();
        $recordData = $this->_recordData;
        unset($recordData['statusId']);
        $status->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'status'  => "Active",
            ));

        $statusTable = new StatusTable($mockTableGateway);
        $statusTable->save($status);
    }

    public function testSaveWillUpdateExistingIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $statusId = $recordData['statusId'];
        unset($recordData['statusId']);
        $status = new StatusModel();
        $status->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new StatusModel());
        $resultSet->initialize(array($status));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'status'  => "Active",
        ), array('statusId' => $statusId))->andReturn($this->_recordData);

        $statusTable = new StatusTable($mockTableGateway);
        $statusTable->save($status, $statusId);
    }

}