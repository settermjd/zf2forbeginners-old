<?php
return array(
    'router' => array(
        'routes' => array(
            'feeds' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/feeds[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BabyMonitor\Controller\Feeds',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(

        ),
        'factories' => array(
            'BabyMonitor\Controller\Feeds'  => 'BabyMonitor\Controller\\Factory\FeedsControllerFactory',
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/babymonitor'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);