<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This class provides a cache service to the module.
 *
 * It will look for a key called 'cache' in the application config and if
 * found, will pass that to StorageFactory to attempt to create a new cache
 * object. If that fails, for whatever reason, it falls back to the memory
 * adapter.
 *
 * @category   BabyMonitory
 * @package    Cache
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @see        http://framework.zend.com/manual/2.0/en/modules/zend.cache.storage.adapter.html
 * @since      File available since Release/Tag: 0.0.4
 */

namespace BabyMonitor\Cache;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    Zend\Cache\Exception\ExtensionNotLoadedException,
    Zend\Cache\StorageFactory;

class CacheFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $cache = null;

        if (array_key_exists('cache', $config)) {
            try {
                $cache = StorageFactory::factory($config['cache']);
            } catch (ServiceNotCreatedException $e) {
                // add logging here.
                try {
                    $serviceLocator->get('EnliteMonologService')->addError($e->getMessage());
                } catch (\UnexpectedValueException $e) {
                    // unable to handle exception
                }
            } catch (ExtensionNotLoadedException $e) {
                try {
                    $serviceLocator->get('EnliteMonologService')->addError($e->getMessage());
                } catch (\UnexpectedValueException $e) {
                    // unable to handle exception
                }
            } catch (\Exception $e) {
                try {
                    $serviceLocator->get('EnliteMonologService')->addError($e->getMessage());
                } catch (\UnexpectedValueException $e) {
                    // unable to handle exception
                }
            }
        }

        /**
         * Couldn't load the desired cache adapter, so we're falling back to a memory adapter
         */
        if (is_null($cache)) {
            $cache = StorageFactory::factory(array(
                'adapter' => array(
                    'name' => 'memory',
                ),
            ));
        }

        return $cache;
    }
}