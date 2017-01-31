<?php

namespace Pizza;

return array(
    'controllers' => array(
        'factories' => array(
            'Topping\Controller\Topping' => 'Topping\Factory\ToppingControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'topping' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/topping[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Topping\Controller\Topping',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'topping' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        )
    )
);
