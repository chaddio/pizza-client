<?php

namespace Pizza;

return array(
    'controllers' => array(
        'factories' => array(
            'Pizza\Controller\Pizza' => 'Pizza\Factory\PizzaControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'pizza' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/pizza[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Pizza\Controller\Pizza',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'pizza' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'PizzaModel' => 'Pizza\Factory\PizzaModelFactory',
        )
    )
);
