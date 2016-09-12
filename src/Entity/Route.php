<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Entity;

use InvalidArgumentException;

class Route
{
    /**
     * Allowed methods for this route.
     *
     * @var array
     */
    protected $methods;

    /**
     * The resource path to be matched.
     *
     * @var string
     */
    protected $resource;

    /**
     * Return value of this route.
     *
     * @var callable
     */
    protected $handler;

    /**
     * @var string[]
     */
    const HTTP_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD', 'TRACE', 'CONNECT'];

    /**
     * @param array    $methods
     * @param resource $resource
     * @param callable $handler
     */
    public function __construct(array $methods, Resource $resource, callable $handler)
    {
        $this->setMethods($methods);

        $this->resource = $resource;
        $this->handler = $handler;
    }

    public function setMethods(array $methods): Route
    {
        if (count($methods) < 1) {
            throw new InvalidArgumentException('At least one method must be supplied for the route.');
        }

        $this->methods = array_map(function ($method) {
            return strtoupper($method);
        }, $methods);

        return $this;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function setResource(Resource $resource): Route
    {
        $this->resource = $resource;

        return $this;
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function setHandler(callable $handler): Route
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandler(): callable
    {
        return $this->handler;
    }
}
