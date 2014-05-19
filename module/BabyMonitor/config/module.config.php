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
            'login' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'BabyMonitor\Controller\Auth',
                        'action'     => 'login',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'BabyMonitor\Controller\Auth'  => 'BabyMonitor\Controller\AuthController',
        ),
        'factories' => array(
            'BabyMonitor\Controller\Feeds'  => 'BabyMonitor\Controller\Factory\FeedsControllerFactory',
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/babymonitor'    => __DIR__ . '/../view/layout/layout.phtml',
            'layout/login'          => __DIR__ . '/../view/layout/login-layout.phtml',
            'babymonitor/feeds/paginator/default'   => __DIR__ . '/../view/baby-monitor/feeds/partials/pagination.phtml',
            'babymonitor/feeds/results/default'     => __DIR__ . '/../view/baby-monitor/feeds/partials/feed-results.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'noFeedsAvailable' => 'BabyMonitor\View\Helper\NoFeedsAvailable',
        )
    ),
);