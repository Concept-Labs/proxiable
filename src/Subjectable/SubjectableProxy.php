<?php
namespace Cl\Proxiable\Subjectable;

use Cl\Proxiable\ProxiableException;
use Cl\Proxiable\ProxiableInterface;
use Cl\Proxiable\ProxyInterface;
use Cl\Proxy\ProxyableInterface;

abstract class SubjectableProxy implements SubjectableProxyInterface
{
    /**
     * Magic methods trait
     */
    use SubjectableProxyMagicTrait;

    /**
     * Subject class
     *
     * @property string|null $subjectClass
     */
    protected ?string $subjectClass = null;

    /**
     * Subject Instance
     *
     * @property ?SubjectableInterface $subject
     */
    protected ?SubjectableInterface $subject = null;

    /**
     * Subject constructor parameters
     *
     * @var array|null
     */
    protected ?array $subjectConstructorParameterssubjectClass = null;

    /**
     * Proxy constructor
     *
     * @param string|\Stringable $subjectClass 
     * @param mixed              ...$parameters 
     */
    public function __construct(string $subjectClass, mixed ...$parameters)
    {
        $this->subjectClass = $subjectClass;
        $this->subjectConstructorParameterssubjectClass = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getSubjectClass(): string
    {
        return $this->subjectClass;
    }

    /**
     * @inheritDoc
     */
    public function getSubjectConstructorParameters(): array|null
    {
        return $this->subjectConstructorParameterssubjectClass;
    }

    /**
     * @inheritDoc
     */
    public function getSubject(): SubjectableInterface
    {
        if (!$this->subject instanceof SubjectableInterface) {
            try {
                $subjectClass = $this->getSubjectClass(); // :/
                $this->subject 
                = new $subjectClass(...$this->getSubjectConstructorParameters());
                die($this->getSubjectClass()." subject constructed");
            } catch (\Throwable $e) {
                throw new ProxiableException($this, $e);
            }
        }
        return $this->subject;
    }
}