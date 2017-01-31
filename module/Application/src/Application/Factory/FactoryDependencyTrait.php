<?php
namespace Application\Factory;

use Application\Log\LoggerTrait;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

trait FactoryDependencyTrait 
{
    use LoggerTrait;
    use ServiceLocatorAwareTrait;

    protected $cache;

    public function initialize(ServiceLocatorInterface $serviceLocator)
    {

        if ($serviceLocator instanceof AbstractPluginManager) {
            $this->serviceLocator = $serviceLocator->getServiceLocator();
        } else {
            $this->serviceLocator = $serviceLocator;
        }

        if ($this->serviceLocator->has('ZendLog')) {
            $this->logger = $this->serviceLocator->get('ZendLog');
        }

        $cache = array();

        if ($this->serviceLocator->has('Cache\Persistence')) {
            $cache['persistent'] = $this->serviceLocator->get('Cache\Persistence');
        }

        if ($this->serviceLocator->has('Cache\Transient')) {
            $cache['transient'] = $this->serviceLocator->get('Cache\Transient');
        }

        $this->cache = array_key_exists('persistent', $cache) ? $cache['persistent'] : null;

        return $this;
    }
}
