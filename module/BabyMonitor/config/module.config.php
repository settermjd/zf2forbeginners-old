<?php

return array(
    'router' => array(
        'routes' => array(
            'feeds' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/feeds',
                    'defaults' => array(
                        '__NAMESPACE__' => 'BabyMonitor\Controller',
                        'controller'    => 'Feeds',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'search' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/search[/:startDate][/:endDate]',
                            'constraints' => array(
                                'startDate' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                                'endDate'   => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
                            ),
                            'defaults' => array(
                                'action'    => 'search',
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/delete[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'delete',
                            )
                        ),
                        'may_terminate' => true,
                    ),
                    'manage' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/manage[/:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'manage',
                            )
                        ),
                        'may_terminate' => true,
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
            'babymonitor/feeds/messages/default'    => __DIR__ . '/../view/baby-monitor/feeds/partials/flash-messenger.phtml',
            'babymonitor/feeds/results/search/default'     => __DIR__ . '/../view/baby-monitor/feeds/partials/feed-search-results-default.phtml',
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