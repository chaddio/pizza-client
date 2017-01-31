<?php

namespace Application\Factory;

use Application\Factory\FactoryDependencyTrait;
use Application\Service\PizzaApiService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PizzaApiServiceFactory implements FactoryInterface
{
    use FactoryDependencyTrait;
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->initialize($serviceLocator);
        
        return new PizzaApiService($serviceLocator, $this->logger);
    }
}