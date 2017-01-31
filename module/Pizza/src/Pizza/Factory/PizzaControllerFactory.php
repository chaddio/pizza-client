<?php

namespace Pizza\Factory;

use Application\Factory\FactoryDependencyTrait;
use Pizza\Controller\PizzaController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PizzaControllerFactory implements FactoryInterface
{
    use FactoryDependencyTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->initialize($serviceLocator);

        $controller = new PizzaController($serviceLocator, $this->logger);
        return $controller;
    }
}