<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class RouteFactory implements RouteFactoryInterface
{
    /**
     * @var string[]
     */
    const HTTP_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * @inheritDoc
     */
    public function match(array $methods, Resource $resource, callable $handler): Route
    {
        return new Route($methods, $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function get(Resource $resource, callable $handler): Route
    {
        return $this->match(['GET'], $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function post(Resource $resource, callable $handler): Route
    {
        return $this->match(['POST'], $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function put(Resource $resource, callable $handler): Route
    {
        return $this->match(['PUT'], $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function patch(Resource $resource, callable $handler): Route
    {
        return $this->match(['PATCH'], $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function delete(Resource $resource, callable $handler): Route
    {
        return $this->match(['DELETE'], $resource, $handler);
    }

    /**
     * @inheritDoc
     */
    public function any(Resource $resource, callable $handler): Route
    {
        return $this->match(Route::HTTP_METHODS, $resource, $handler);
    }
}
