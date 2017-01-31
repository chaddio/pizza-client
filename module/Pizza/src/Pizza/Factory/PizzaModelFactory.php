<?php

namespace Pizza\Factory;

use Application\Factory\FactoryDependencyTrait;
use Pizza\Model\PizzaModel;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PizzaModelFactory implements FactoryInterface
{
    use FactoryDependencyTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->initialize($serviceLocator);

        $model = new PizzaModel($serviceLocator,$this->logger);
        return $model;
    }
}