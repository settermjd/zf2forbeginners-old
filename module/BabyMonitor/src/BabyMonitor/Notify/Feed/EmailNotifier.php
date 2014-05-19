<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This class allows for sending email notifications when a feed record's created, updated or deleted.
 *
 * @category   BabyMonitor
 * @package    Notify
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */

namespace BabyMonitor\Notify\Feed;

use BabyMonitor\Models\FeedModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Class EmailNotifier
 *
 * The class provides a simple way to notify a user via email after a feed record's been created, updated or deleted.
 *
 * @package BabyMonitor\Notify\Feed
 */
class EmailNotifier implements NotifyInterface
{
    /**
     * The email subject if nothing's provided
     */
    const DEFAULT_SUBJECT = 'Baby Monitor Feed Notification';

    /**
     * Notification states
     */
    const NOTIFY_CREATE = 'create';
    const NOTIFY_UPDATE = 'update';
    const NOTIFY_DELETE = 'delete';

    protected $_config;
    protected $_mailTransport;

    /**
     * @param array|\Traversable $emailConfig
     * @param \Zend\Mail\Transport\TransportInterface $mailTransport
     */
    public function __construct($emailConfig, TransportInterface $mailTransport)
    {
        if (empty($emailConfig)) {
            throw new EmailNotifierException('Missing notifier configuration data');
        }

        $this->_config = $emailConfig;
        $this->_mailTransport = $mailTransport;
    }

    /**
     * @param FeedModel $feed
     * @param string $notificationType
     * @return mixed
     */
    public function notify(FeedModel $feed, $notificationType)
    {
        if (empty($this->_config['subject'])) {
            $subject = self::DEFAULT_SUBJECT;
        } else {
            $subject = $this->_config['subject'];
        }

        $message = new Message();
        $message->setBody($this->getNotificationBody($feed, $notificationType))
                ->setSubject($subject)
                ->addFrom($this->_config['address']['from'])
                ->addTo($this->_config['address']['to']);

        return $this->_mailTransport->send($message);
    }

    /**
     * @param FeedModel $feed
     * @param string $notificationType
     * @return string
     */
    public function getNotificationBody(FeedModel $feed, $notificationType)
    {
        switch ($notificationType) {
            case (self::NOTIFY_UPDATE):
                $message = sprintf("Feed %d has been updated", $feed->feedId);
                break;

            case (self::NOTIFY_DELETE):
                $message = sprintf("Feed %d has been deleted", $feed->feedId);
                break;

            case (self::NOTIFY_CREATE):
            default:
               $message = sprintf("Feed has been created. Id is: %d", $feed->feedId);
                break;
        }

        return $message;
    }
}