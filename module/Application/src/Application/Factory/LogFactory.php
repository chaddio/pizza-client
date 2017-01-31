<?php

namespace Application\Factory;

use Zend\Log\Logger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogFactory implements FactoryInterface
{
    
    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return type
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        $options = [
            'writers' => [
                'stream' => [
                    'name' => 'stream',
                    'options' => [
                        'stream' => APPLICATION_PATH . '/data/logs/app.log',
                    ] 
                ] 
            ] 
        ];
        
        $log = new Logger($options);
        
        return $log;
    }
}
