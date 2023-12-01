<?php
namespace Cl\Proxiable\Subjectable;

use \Cl\Proxiable\Exception\ProxiableException;

trait SubjectableProxyMagicTrait
{
    /**
     * Self or Subject call
     *
     * @param string $method 
     * @param mixed  $parameters 
     * 
     * @return mixed
     * @throws ProxiableException
     */
    public function __call(string $method, array $parameters): mixed
    {
        try {
            match (true) {
                method_exists($this, $method) => $result = $this->$method(...$parameters),
                method_exists($this->getSubjectClass(), "__call") => $result = $this->getSubject()->__call($method, $parameters),
                default => $result = $this->getSubject()->$method(...$parameters)
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }

    /**
     * Self or Subject call
     *
     * @param string $method 
     * @param mixed  $parameters 
     * 
     * @return mixed
     * @throws ProxiableException
     */
    public static function __callStatic(string $method, array $parameters): mixed
    {
        echo static::class;
        var_dump($parameters);
        die('Call-static: '.$method . '-');
        try {
            match (method_exists(static::class, $method)) {
                true => $result = static::$method(...$parameters),
                default => $result = static::getSubjectClass()::$method(...$parameters)
            };
        } catch (\Throwable $e) {
            //throw new ProxiableException(new \stdClass(), $e);
        }
        return $result;
    }

    /**
     * Getter for Self or Subject property
     *
     * @param string $name 
     * 
     * @return mixed
     * @throws ProxiableException
     */
    public function __get(string $name): mixed
    {
        try {
            match (true) {
                property_exists($this, $name) => $value = $this->$name,
                method_exists($this->$this->getSubjectClass(), "__get") => $this->getSubject()->__get($name),
                default => $value = $this->getSubject()->$name
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $value;
    }

    /**
     * Setter for Self or Subject property
     *
     * @param string $name 
     * @param mixed  $value 
     * 
     * @return void
     * @throws ProxiableException
     */
    public function __set(string $name, mixed $value): void
    {
        try {
            match (true) {
                property_exists($this, $name) => $this->$name = $value,
                method_exists($this->getSubjectClass(), "__set") => $this->getSubject()->__set($name, $value),
                property_exists($this->getSubjectClass(), $name) => $this->getSubject()->$name = $value,
                default => null
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
    }

    public function __isset(string $name): bool
    {
        try {
            match (true) {
                isset($this->$name) => $result = isset($this->$name),
                method_exists($this->getSubjectClass(), "__isset") => $result = $this->getSubject()->__isset($name),
                default => $result = isset($this->getSubject()->$name)
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }

    public function __unset(string $name): void
    {
        try {
            match (true) {
                //isset($this->$name) => unset($this->$name),
                method_exists($this->getSubjectClass(), "__unset") => $this->getSubject()->__unset($name),
                isset($this->getSubject()->$name) => (function ($name) {
                    unset($this->getSubject()->$name);
                })($name),
                default => null
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
    }

    public function __sleep(): array
    { //@TODO serialize self
        try {
            $result = [];
            match (true) {
                method_exists($this->getSubjectClass(), "__sleep") => $result = $this->getSubject()->__sleep(),
                //@TODO
                //true => array_merge(["\0*\0subjectClass"], $result),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }

    public function __wakeup(): void
    { //@TODO unserialize self
        try {
            match (true) {
                method_exists($this->getSubjectClass(), "__wakeup") => $this->getSubject()->__wakeup(),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
    }
    
    public function __serialize(): array
    { //@TODO serialize self
        try {
            match (true) {
                method_exists($this->getSubjectClass(), "__serialize") => $result = $this->getSubject()->__serialize(),
                //@TODO
                //true => array_merge(["\0*\0subjectClass"], $result),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }

    public function __unserialize(array $data): void
    {
        try {
            match (true) {
                method_exists($this->getSubjectClass(), "__unserialize") => $this->getSubject()->__unserialize(),
                //@TODO
                //true => array_merge(["\0*\0subjectClass"], $result),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
    }

    public function __toString(): string
    {
        try {
            match (true) {
                method_exists($this->getSubjectClass(), "__toString") => $result = $this->getSubject()->__toString(),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }
    
    public function __invoke(): mixed
    {
        try {
            match (true) {
                method_exists($this->getSubject(), "__invoke") => $result = $this->getSubject()->__invoke(),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
        return $result;
    }
    
    // public static function __set_state(array $properties): object
    // {
    // }
    
    // public function __debugInfo(): array
    // {
    // }
    

    /**
     * Destructor
     */
    public function __destruct()
    {
        try {
            match (true) {
                //do not trigger __destruct() for non initialized subject
                $this->subject 
                && method_exists($this->getSubject(), "__destruct") => $this->getSubject()->__destruct(),
                default => true
            };
        } catch (\Throwable $e) {
            throw new ProxiableException($this, $e);
        }
    }
}