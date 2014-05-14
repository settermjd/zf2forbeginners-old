<?php

namespace BabyMonitor;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;
use ZendDiagnostics\Check\DirWritable;
use ZendDiagnostics\Check\ExtensionLoaded;
use ZendDiagnostics\Check\ProcessRunning;
use ZendDiagnostics\Check\PhpVersion;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'BabyMonitor\Tables\UserTable' => 'BabyMonitor\Tables\Factories\UserTableFactory',
                'BabyMonitor\Tables\UserTableGateway' => 'BabyMonitor\Tables\Factories\UserTablegatewayFactory',
                'BabyMonitor\Tables\FeedTable' => 'BabyMonitor\Tables\Factories\FeedTableFactory',
                'BabyMonitor\Tables\FeedTableGateway' => 'BabyMonitor\Tables\Factories\FeedTablegatewayFactory',
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
