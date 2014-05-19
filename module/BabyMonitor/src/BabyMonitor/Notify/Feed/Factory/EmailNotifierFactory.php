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

namespace BabyMonitor\Notify\Feed\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\Cache\Exception\ExtensionNotLoadedException;
use BabyMonitor\Notify\Feed\EmailNotifier;

class EmailNotifierFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $emailConfig = '';

        if (array_key_exists('notification', $config)) {
            $emailConfig = $config['notification'];
        }
        $mailTransport = $serviceLocator->get('SlmMail\Mail\Transport\MandrillTransport');

        $notifier = new EmailNotifier($emailConfig, $mailTransport);

        return $notifier;
    }
}