<?php
namespace Cl\Proxiable\Subjectable;

use Cl\Proxiable\ProxiableInterface;



interface SubjectableInterface extends ProxiableInterface
{
    /**
     * Get Subjectable Proxy
     *
     * @param mixed ...$parameters 
     * 
     * @return SubjectableProxyInterface
     */
    public static function subjectify(mixed ...$parameters);
}