<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'app' => array(
        'name' => 'Baby Management Application',
        'webmaster' => array(
            'name' => 'Matthew Setter',
            'email' => 'matthew@maltblue.com'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=zf24beginners;host=localhost'
    ),
);
