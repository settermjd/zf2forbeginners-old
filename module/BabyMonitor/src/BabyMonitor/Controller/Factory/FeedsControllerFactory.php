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

namespace BabyMonitor\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Cache\Exception\ExtensionNotLoadedException,
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    BabyMonitor\Controller\FeedsController;

class FeedsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm   = $serviceLocator->getServiceLocator();
        $userTable = $sm->get('BabyMonitor\Tables\UserTable');
        $feedTable = $sm->get('BabyMonitor\Tables\FeedTable');
        $cache = $sm->get('BabyMonitor\Cache\Application');
        $controller = new FeedsController($userTable, $feedTable, $cache);

        return $controller;
    }
}