<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Entity;

use InvalidArgumentException;

class Route
{
    /**
     * Allowed methods for this route
     *
     * @var array
     */
    private $methods;

    /**
     * The resource path to be matched
     *
     * @var string
     */
    private $resource;

    /**
     * Return value of this route
     *
     * @var callable
     */
    private $handler;

    /**
     * Does this route require HTTPS
     *
     * @var bool
     */
    private $secure;

    /**
     * @var string[]
     */
    const HTTP_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * @param array $methods
     * @param Resource $resource
     * @param callable $handler
     * @param bool $secure=false
     */
    public function __construct(array $methods, Resource $resource, callable $handler, bool $secure=false)
    {
        $this->setMethods($methods);

        $this->resource = $resource;
        $this->handler = $handler;
        $this->secure = $secure;
    }

    public function setMethods(array $methods): Route
    {
        if (count($methods) < 1) {
            throw new InvalidArgumentException('At least one method must be supplied for the route.');
        }

        $this->methods = array_map(function($method) {
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

    public function setSecure(bool $secure): Route
    {
        $this->secure = $secure;
        return $this;
    }

    public function getSecure(): bool
    {
        return $this->secure;
    }

    /**
     * Add a new get route
     *
     * @param string[] $methods
     * @param string $path
     * @param callable $handler
     * @param array $options
     * @param string $name
     * @return Route
     */
    public static function match(array $methods, string $path, callable $handler, bool $secure=false): Route
    {
        $resource = new Resource($path);
        return new self($methods, $resource, $handler, $secure);
    }

    /**
     * Add a new get route
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function get(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(['GET'], $resource, $handler, $secure);
    }

    /**
     * Add a new post route
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function post(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(['POST'], $resource, $handler, $secure);
    }

    /**
     * Add a new put route
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function put(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(['PUT'], $resource, $handler, $secure);
    }

    /**
     * Add a new patch route
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function patch(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(['PATCH'], $resource, $handler, $secure);
    }

    /**
     * Add a new delete route
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function delete(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(['DELETE'], $resource, $handler, $secure);
    }

    /**
     * Add a new route to match any method
     *
     * @param string $resource
     * @param callable $handler
     * @param bool $secure
     * @param string $name
     * @return Route
     */
    public static function any(string $resource, callable $handler, bool $secure=false): Route
    {
        return self::match(self::HTTP_METHODS, $resource, $handler, $secure);
    }
}
