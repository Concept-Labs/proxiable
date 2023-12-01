<?php

namespace Cl\Proxiable\Extendable;

use Cl\Proxiable\ProxiableException;

trait ExtendableTrait
{

    use \Cl\Proxiable\ProxiableTrait;

    public static function proxify(...$args)
    {
        if (!class_alias(static::class, 'Proxiable', false)) {
            //@TODO
//            throw new ProxiableException("Unable to add class alias");
        }
        $___proxy = new class (static::class, ...$args) extends \Proxiable /*implements ProxiedInterface*/{
            use ExtendableProxyTrait;

            private function ___hasParentConstructor()
            {
                // if ((new \ReflectionMethod($this->___subjectClass, parent::class))->isPublic()) {
                //     return true;
                // }
                try {
                    if ((new \ReflectionMethod($this->___subjectClass, '__construct'))->isConstructor()) {
                        return true;
                    }
                } catch (\ReflectionException $e) {
                    //has no constructor
                }
                return false;
            }
        };
        //class_alias(static::class, null);
        return $___proxy;
    }
}