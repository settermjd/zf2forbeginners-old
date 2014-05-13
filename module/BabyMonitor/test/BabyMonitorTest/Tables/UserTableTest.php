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

use BabyMonitor\Models\UserModel,
    BabyMonitor\Tables\UserTable;
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Select;
use PHPUnit_Framework_TestCase;
use \Mockery as m;

class UserTableTest extends PHPUnit_Framework_TestCase
{
    protected $traceError = true;

    protected $_recordData =  array(
        'userId' => 21,
        'username'  => "matthew@maltblue.com",
        'firstName'  => "Matthew",
        'lastName'  => "Setter",
        'addressId'  => 21,
        'statusId'  => 14,
        'notes'  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius.",
    );

    public function tearDown()
    {
        m::close();
    }

    public function testFetchByUserId()
    {
        $resultSet = new ResultSet();
        $record = new UserModel();
        $record->exchangeArray($this->_recordData);
        $userId = 21;
        $resultSet->initialize(array($record));

        $mockSql = \Mockery::mock('Zend\Db\Sql\Select');
        $mockSql->shouldReceive('select')->andReturn($mockSql);
        $mockSql->shouldReceive('where')->with(array('UserId' => $userId))->times(1)->andReturn($mockSql);

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('getSql')->andReturn($mockSql);
        $mockTableGateway->shouldReceive('selectWith')->times(1)->with($mockSql)->andReturn($resultSet);

        $mockUserTable = new UserTable($mockTableGateway);

        $this->assertEquals($record, $mockUserTable->fetchByUserId($userId));
    }

    public function testSaveUserWillInsertNewUsersIfTheyDoNotAlreadyHaveAnId()
    {
        $user = new UserModel();
        $recordData = $this->_recordData;
        unset($recordData['userId']);
        $user->exchangeArray($recordData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
            ->method('insert')
            ->with(array(
                'Username'  => "matthew@maltblue.com",
                'FirstName'  => "Matthew",
                'LastName'  => "Setter",
                'AddressId'  => 21,
                'StatusId'  => 14,
                'Notes'  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius."
            ));

        $userTable = new UserTable($mockTableGateway);
        $userTable->saveUser($user);
    }

    public function testSaveUserWillUpdateExistingUsersIfTheyAlreadyHaveAnId()
    {
        $recordData = $this->_recordData;
        $userId = $recordData['userId'];
        unset($recordData['userId']);
        $user = new UserModel();
        $user->exchangeArray($this->_recordData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new UserModel());
        $resultSet->initialize(array($user));

        $mockTableGateway = \Mockery::mock('Zend\Db\TableGateway\TableGateway');
        $mockTableGateway->shouldReceive('update')->with(array(
            'Username'  => "matthew@maltblue.com",
            'FirstName'  => "Matthew",
            'LastName'  => "Setter",
            'AddressId'  => 21,
            'StatusId'  => 14,
            'Notes'  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis vitae nisi eget suscipit. Suspendisse condimentum sapien purus, eu porta dolor elementum vel. Praesent quis nunc dolor. Phasellus in luctus lorem, a tempus velit. Proin varius magna urna, id accumsan ante eleifend eleifend. Nullam id nulla ligula. Praesent id felis vel felis tempor vestibulum. Nulla pretium, tortor eu placerat suscipit, purus ipsum aliquet eros, non dictum mi odio in odio. Morbi ac porta enim. In non purus at dui consequat rhoncus. Nullam libero nisl, rutrum non mi vel, molestie gravida lectus. Sed laoreet vitae sem at tincidunt. Etiam volutpat nunc ut nunc fringilla, at imperdiet urna congue. Sed lacinia sit amet leo id vehicula. Aenean interdum purus id gravida varius."
        ), array('UserId' => $userId))->andReturn($this->_recordData);

        $userTable = new UserTable($mockTableGateway);
        $userTable->saveUser($user, $userId);
    }

}