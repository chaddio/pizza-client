<?php

namespace Application\Log;

use Zend\Log\LoggerInterface;

trait LoggerTrait
{
    /**
     * @var LoggerInterface|null
     */
    protected $logger = null;
    
    
    public function log($message = null, $devLog = true)
    {
        if($devLog===false)
            return;
        
        if(is_null($this->logger) || !$this->logger instanceof LoggerInterface)
            return;
        
        if (trim($message)=='')
            return;

        $this->logger->info($message);
    }
    
    /**
     * Set logger object
     *
     * @param LoggerInterface|null $logger
     * @return mixed
     */
    public function setLogger($logger)
    {
        if ($logger instanceof LoggerInterface) {
            $this->logger = $logger;
        }
    
        return $this;
    }
    
    /**
     * Get logger object
     *
     * @return null|LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
    
}