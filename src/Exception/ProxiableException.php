<?php

namespace Cl\Proxiable\Exception;
use Cl\Proxiable\ProxyInterface;

class ProxiableException extends \RuntimeException
{
    /**
     * Constructor
     *
     * @param ProxyInterface $proxy 
     * @param \Throwable     $e 
     */
    public function __construct(ProxyInterface $proxy, \Throwable $e, ?string $additionalMessage = null)
    {
        parent::__construct(
            "Proxied class '{$proxy->getSubjectClass()}': {$additionalMessage}; {$e->getMessage()}",
            $e->getCode(),
            $e->getPrevious()
        );
    }
}