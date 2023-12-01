<?php
namespace Cl\Proxiable;

interface ProxyInterface
{
    /**
     * Get Subject
     *
     * @return ProxiableInterface
     * @throws ProxiableException
     */
    public function getSubject(): ProxiableInterface;

    /**
     * Get Subject Class
     *
     * @return string
     */
    public function getSubjectClass(): string;

    /**
     * Get subject constructor parameters
     *
     * @return array|null
     */
    public function getSubjectConstructorParameters(): array|null;
}