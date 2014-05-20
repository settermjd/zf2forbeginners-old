<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Initialises the FeedsController using the FactoryInterface
 *
 * @category   BabyMonitor
 * @package    Controller\Factory
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */

namespace BabyMonitor\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
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