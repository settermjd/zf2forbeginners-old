<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $serviceManager = $e->getApplication()->getServiceManager();
        $sem = $eventManager->getSharedManager();

        /*
         * Add a series of events covering the feed lifecycle
         */
        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Create',
            function($e) use($serviceManager) {

            }
        );

        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Update',
            function($e) use($serviceManager) {

            }
        );

        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Delete',
            function($e) use($serviceManager) {

            }
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
