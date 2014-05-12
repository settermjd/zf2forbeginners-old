<?php

namespace BabyMonitor;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
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
                    'apc',
                    'memcached'
                ));
                return $diagnostic->check();
            },
            'Check Apache is running' => function(){
                $diagnostic = new ProcessRunning('httpd');
                return $diagnostic->check();
            },
            'Check PostgreSQL is running' => function(){
                $diagnostic = new ProcessRunning('postgresql');
                return $diagnostic->check();
            },
            'Check Memcached is running' => function(){
                $diagnostic = new ProcessRunning('memcached');
                return $diagnostic->check();
            },
            'Check PHP Version' => function(){
                $diagnostic = new PhpVersion('5.3.0', '>=');
                return $diagnostic->check();
            }
        );
    }
}
