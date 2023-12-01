<?php

namespace Cl\Proxiable\Subjectable;

/**
 * @see SubjectableInterface
 */
trait SubjectableTrait
{

    use \Cl\Proxiable\ProxiableTrait;

    /**
     * @see \Cl\Proxiable\ProxiableInterface::proxify()
     */
    public static function proxify(mixed ...$parameters): SubjectableProxyInterface
    {
        return static::subjectify(...$parameters);
    }

    /**
     * @see SubjectableInterface::subjectify()
     */
    public static function subjectify(mixed ...$parameters)
        : SubjectableProxyInterface
    {
        return (function () use ($parameters): SubjectableProxyInterface {
            return
                new class (static::class, ...$parameters) extends SubjectableProxy {
                };
        })();
    }
}