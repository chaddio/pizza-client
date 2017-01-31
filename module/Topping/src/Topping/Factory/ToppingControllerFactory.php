<?php

namespace Topping\Factory;

use Application\Factory\FactoryDependencyTrait;
use Topping\Controller\ToppingController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ToppingControllerFactory implements FactoryInterface
{
    use FactoryDependencyTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->initialize($serviceLocator);

        $controller = new ToppingController($serviceLocator, $this->logger);
        return $controller;
    }
}