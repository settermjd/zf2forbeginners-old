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

namespace BabyMonitor\test\BabyMonitorTest\Notify;

use BabyMonitor\Models\FeedModel;
use PHPUnit_Framework_TestCase;
use BabyMonitor\Notify\Feed\EmailNotifier;
use BabyMonitor\Notify\Feed\EmailNotifierException;
use \Mockery as m;
use SlmMail\Mail\Transport\HttpTransport;
use Zend\Mail\Message;

class EmailNotifierTest extends PHPUnit_Framework_TestCase
{
    public $notifier;
    public $defaultFeedData;
    public $defaultConfigData;

    public function setUp()
    {
        $this->defaultFeedData = array(
            'feedId'=> 21,
            'feedDate' => '2014-01-01',
            'feedTime' => '19:00:00',
            'feedAmount' => 200.09,
            'feedTemperature' => 21.09,
            'feedNotes' => 'asdfsadfsfsad',
        );
        $this->defaultConfigData = array(
            'address' => array(
                'to' => 'matthew@maltblue.com',
                'from' => 'matthew@maltblue.com'
            ),
            'subject' => 'Baby Monitor Feed Notification'
        );
    }

    public function tearDown()
    {
        m::close();
    }

    public function testImplementsCorrectClass()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);

        $this->assertInstanceOf(
            '\BabyMonitor\Notify\Feed\EmailNotifier',
            $this->notifier,
            "Doesn't implement correct class"
        );
    }

    public function testMessageHasCorrectProperties()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);
        $feed = new FeedModel();
        $feed->exchangeArray($this->defaultFeedData);

        $message = new Message();
        $message->setBody($this->notifier->getNotificationBody($feed, EmailNotifier::NOTIFY_UPDATE))
                ->setSubject($this->defaultConfigData['subject'])
                ->addFrom($this->defaultConfigData['address']['from'])
                ->addTo($this->defaultConfigData['address']['to']);

        $service->expects($this->once())
                ->method('send')
                ->with($this->equalTo($message));

        $this->notifier->notify($feed, EmailNotifier::NOTIFY_UPDATE);
    }

    public function testMessageHasCorrectSubjectWhenNoneProvided()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);
        $feed = new FeedModel();
        $feed->exchangeArray($this->defaultFeedData);

        $message = new Message();
        $message->setBody($this->notifier->getNotificationBody($feed, EmailNotifier::NOTIFY_UPDATE))
            ->setSubject(EmailNotifier::DEFAULT_SUBJECT)
            ->addFrom($this->defaultConfigData['address']['from'])
            ->addTo($this->defaultConfigData['address']['to']);

        $service->expects($this->once())
            ->method('send')
            ->with($this->equalTo($message));

        $this->notifier->notify($feed, EmailNotifier::NOTIFY_UPDATE);
    }

    public function testCanGetNotificationBodyForValidUpdate()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);
        $feed = new FeedModel();
        $feed->exchangeArray($this->defaultFeedData);

        $this->assertSame(
            sprintf('Feed %d has been updated', $this->defaultFeedData['feedId']),
            $this->notifier->getNotificationBody($feed, EmailNotifier::NOTIFY_UPDATE),
            'Returned notification body was not correctly generated'
        );
    }

    public function testCanGetNotificationBodyForValidCreation()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);
        $feed = new FeedModel();
        $feed->exchangeArray($this->defaultFeedData);

        $this->assertSame(
            sprintf('Feed has been created. Id is: %d', $this->defaultFeedData['feedId']),
            $this->notifier->getNotificationBody($feed, EmailNotifier::NOTIFY_CREATE),
            'Returned notification body was not correctly generated'
        );
    }

    public function testCanGetNotificationBodyForValidDeletion()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier($this->defaultConfigData, $transport);
        $feed = new FeedModel();
        $feed->exchangeArray($this->defaultFeedData);

        $this->assertSame(
            sprintf('Feed %d has been deleted', $this->defaultFeedData['feedId']),
            $this->notifier->getNotificationBody($feed, EmailNotifier::NOTIFY_DELETE),
            'Returned notification body was not correctly generated'
        );
    }

    /**
     * @expectedException \BabyMonitor\Notify\Feed\EmailNotifierException
     * @expectedExceptionMessage Missing notifier configuration data
     */
    public function testExceptionIsThrownIfConfigDataIsEmpty()
    {
        $service   = $this->getMock('SlmMail\Service\MandrillService', array(), array('my-secret-key'));
        $transport = new HttpTransport($service);
        $this->notifier = new EmailNotifier(array(), $transport);
    }
}