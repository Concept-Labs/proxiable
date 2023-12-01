<?php
namespace Cl\Proxiable;
use Cl\Traitable\TraitableInterface;

/**
 * Proxiable interface
 */
interface ProxiableInterface extends TraitableInterface
{
    

    /**
     * Proxify self
     *
     * @param mixed ...$parameters 
     * 
     * @return ProxyInterface
     */
    public static function proxify(mixed ...$parameters): ProxyInterface;
}