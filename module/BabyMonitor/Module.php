<?php

namespace BabyMonitor;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use ZendDiagnostics\Check\DirWritable;
use ZendDiagnostics\Check\ExtensionLoaded;
use ZendDiagnostics\Check\ProcessRunning;
use ZendDiagnostics\Check\PhpVersion;
use BabyMonitor\Notify\Feed\EmailNotifier;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $serviceManager = $e->getApplication()->getServiceManager();
        $sem = $eventManager->getSharedManager();

        /*
         * Add a series of events covering the feed lifecycle (create, modify, delete)
         */
        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Create',
            function($e) use($serviceManager) {
                $notifier = $serviceManager->get('BabyMonitor\Notify\Feed\EmailNotifier');
                $notifier->notify($e->getParams()['feedData'], EmailNotifier::NOTIFY_CREATE);
            }
        );

        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Modify',
            function($e) use($serviceManager) {
                $notifier = $serviceManager->get('BabyMonitor\Notify\Feed\EmailNotifier');
                $notifier->notify($e->getParams()['feedData'], EmailNotifier::NOTIFY_UPDATE);
            }
        );

        $sem->attach('BabyMonitor\Controller\FeedsController', 'Feed.Delete',
            function($e) use($serviceManager) {
                $notifier = $serviceManager->get('BabyMonitor\Notify\Feed\EmailNotifier');
                $notifier->notify($e->getParams()['feedData'], EmailNotifier::NOTIFY_DELETE);
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
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'BabyMonitor\Tables\UserTable' => 'BabyMonitor\Tables\Factories\UserTableFactory',
                'BabyMonitor\Tables\UserTableGateway' => 'BabyMonitor\Tables\Factories\UserTablegatewayFactory',
                'BabyMonitor\Tables\FeedTable' => 'BabyMonitor\Tables\Factories\FeedTableFactory',
                'BabyMonitor\Tables\FeedTableGateway' => 'BabyMonitor\Tables\Factories\FeedTablegatewayFactory',
                'BabyMonitor\Cache\Application' => 'BabyMonitor\Cache\CacheFactory',
                'BabyMonitor\Notify\Feed\EmailNotifier' => 'BabyMonitor\Notify\Feed\Factory\EmailNotifierFactory',
            )
        );
    }

    public function init(ModuleManager $manager)
    {
        $events = $manager->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controller->layout('layout/babymonitor');
        }, 100);
    }

    /**
     * Covers the specific diagnostic checks for the module.
     *
     * @return array
     */
    public function getDiagnostics()
    {
        return array(
            'Cache & Log Directories Available' => function() {
                $diagnostic = new DirWritable(array(
                    __DIR__ . '/../../data/cache',
                    __DIR__ . '/../../data/log'
                ));
                return $diagnostic->check();
            },
            'Check PHP extensions' => function(){
                $diagnostic = new ExtensionLoaded(array(
                    'json',
                    'pdo',
                    'pdo_pgsql',
                    'intl',
                    'session',
                    'pcre',
                    'zlib',
                    'Zend OPcache'
                ));
                return $diagnostic->check();
            },
            'Check Apache is running' => function(){
                $diagnostic = new ProcessRunning('apache2');
                return $diagnostic->check();
            },
            'Check PostgreSQL is running' => function(){
                $diagnostic = new ProcessRunning('postgresql');
                return $diagnostic->check();
            },
            'Check Memcached is running' => function(){
                $diagnostic = new ProcessRunning('beanstalkd');
                return $diagnostic->check();
            },
            'Check PHP Version' => function(){
                $diagnostic = new PhpVersion('5.3.0', '>=');
                return $diagnostic->check();
            }
        );
    }
}
