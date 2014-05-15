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

use BabyMonitor\Models\FeedModel,
    BabyMonitor\Tables\FeedTable;
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Where;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class FeedTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'userId' => 21,
        'feedId'  => 12,
        'feedDateTime'  => "2012-01-01 12:00:00",
        'feedAmount'  => 21.04,
        'feedTemperature'  => 14,
        'feedNotes' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius.",
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByUserId()
    {
        $resultSet = new ResultSet();
        $record = new FeedModel();
        $record->exchangeArray($this->_recordData);
        $userId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('UserId' => $userId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockFeedTable = new FeedTable($mockTableGateway);

        $this->assertEquals($record, $mockFeedTable->fetchByUserId($userId));
    }

    public function testFetchMostRecentFeeds()
    {
        $resultSet = new ResultSet();
        $record = new FeedModel();
        $record->exchangeArray($this->_recordData);
        $limit = 5;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('limit')->with($limit)->times(1)->andReturn($mockSql);
        $mockSql->shouldReceive('order')->times(1)->with("feedDateTime DESC")->andReturn($resultSet);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockFeedTable = new FeedTable($mockTableGateway);

        $this->assertEquals($resultSet, $mockFeedTable->fetchMostRecentFeeds($limit));
    }

    public function testFetchByDateRangeCanSearchBetweenDates()
    {
        $resultSet = new ResultSet();
        $record = new FeedModel();
        $record->exchangeArray($this->_recordData);
        $where = new Where();

        $resultSet->initialize(array($record));
        $startDate = new \DateTime('2000-01-01');
        $endDate = new \DateTime('2000-01-10');

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array(
            $where->greaterThanOrEqualTo(
                'feedDateTime', $startDate->format(FeedTable::DATETIME_FORMAT)
            ),
            $where->lessThanOrEqualTo(
                'feedDateTime', $endDate->format(FeedTable::DATETIME_FORMAT)
            )
        ))->times(1)->andReturn($mockSql);
        $mockSql->shouldReceive('order')->times(1)->with("feedDateTime DESC")->andReturn($resultSet);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockFeedTable = new FeedTable($mockTableGateway);

        $this->assertEquals($resultSet, $mockFeedTable->fetchByDateRange($startDate, $endDate));
    }

    public function testFetchByDateRangeCanSearchUpToADate()
    {
        $resultSet = new ResultSet();
        $record = new FeedModel();
        $record->exchangeArray($this->_recordData);
        $where = new Where();

        $resultSet->initialize(array($record));
        $endDate = new \DateTime('2000-01-01');

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array(
            $where->lessThanOrEqualTo(
                'feedDateTime', $endDate->format(FeedTable::DATETIME_FORMAT)
            )
        ))->times(1)->andReturn($mockSql);
        $mockSql->shouldReceive('order')->times(1)->with("feedDateTime DESC")->andReturn($resultSet);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockFeedTable = new FeedTable($mockTableGateway);

        $this->assertEquals($resultSet, $mockFeedTable->fetchByDateRange(null, $endDate));
    }

    public function testFetchByDateRangeCanSearchAfterToADate()
    {
        $resultSet = new ResultSet();
        $record = new FeedModel();
        $record->exchangeArray($this->_recordData);
        $where = new Where();

        $resultSet->initialize(array($record));
        $startDate = new \DateTime('2000-01-01');

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array(
            $where->greaterThanOrEqualTo(
                'feedDateTime', $startDate->format(FeedTable::DATETIME_FORMAT)
            )
        ))->times(1)->andReturn($mockSql);
        $mockSql->shouldReceive('order')->times(1)->with("feedDateTime DESC")->andReturn($resultSet);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockFeedTable = new FeedTable($mockTableGateway);

        $this->assertEquals($resultSet, $mockFeedTable->fetchByDateRange($startDate));
    }

    public function testSaveWillInsertIfRecordHasNoFeedId()
    {
        $feed = new FeedModel();
        $recordData = $this->_recordData;
        unset($recordData['feedId']);
        $feed->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'userId' => 21,
                'feedDateTime'  => "2012-01-01 12:00:00",
                'feedAmount'  => 21.04,
                'feedTemperature'  => 14,
                'feedNotes' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius."));

        $feedTable = new FeedTable($mockTableGateway);
        $feedTable->save($feed);
    }

    public function testSaveUserWillUpdateExistingUsersIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $feedId = $recordData['feedId'];
        $feed = new FeedModel();
        $feed->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new FeedModel());
        $resultSet->initialize(array($feed));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'userId' => 21,
            'feedDateTime'  => "2012-01-01 12:00:00",
            'feedAmount'  => 21.04,
            'feedTemperature'  => 14,
            'feedNotes' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius."), array('feedId' => $feedId))->andReturn($this->_recordData);

        $feedTable = new FeedTable($mockTableGateway);
        $feedTable->save($feed, $feedId);
    }

}