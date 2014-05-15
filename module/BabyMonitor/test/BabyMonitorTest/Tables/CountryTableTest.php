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

use BabyMonitor\Models\CountryModel;
use BabyMonitor\Tables\CountryTable;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class CountryTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'countryId'  => 61,
        'countryName'  => "Australia",
        'countryCode'  => "AUS"
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByCountryId()
    {
        $resultSet = new ResultSet();
        $record = new CountryModel();
        $record->exchangeArray($this->_recordData);
        $countryId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('countryId' => $countryId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockCountryTable = new CountryTable($mockTableGateway);

        $this->assertEquals($record, $mockCountryTable->fetchByCountryId($countryId));
    }

    public function testSaveWillInsertNewIfTheyDoNotAlreadyHaveAnId()
    {
        $country = new CountryModel();
        $recordData = $this->_recordData;
        unset($recordData['countryId']);
        $country->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'countryName'  => "Australia",
                'countryCode'  => "AUS",
            ));

        $countryTable = new CountryTable($mockTableGateway);
        $countryTable->save($country);
    }

    public function testSaveWillUpdateExistingIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $countryId = $recordData['countryId'];
        unset($recordData['countryId']);
        $country = new CountryModel();
        $country->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new CountryModel());
        $resultSet->initialize(array($country));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'countryName'  => "Australia",
            'countryCode'  => "AUS",
        ), array('countryId' => $countryId))->andReturn($this->_recordData);

        $countryTable = new CountryTable($mockTableGateway);
        $countryTable->save($country, $countryId);
    }

}