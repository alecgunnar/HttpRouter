<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class RouteFactory implements RouteFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getInstance(array $methods, Resource $resource, callable $handler): Route
    {
        return new Route($methods, $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['GET'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function post(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['POST'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function put(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['PUT'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function patch(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['PATCH'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['DELETE'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['CONNECT'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function options(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['OPTIONS'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function head(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['HEAD'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function trace(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(['TRACE'], $resource, $handler);
    }

    /**
     * {@inheritdoc}
     */
    public function any(Resource $resource, callable $handler): Route
    {
        return $this->getInstance(Route::HTTP_METHODS, $resource, $handler);
    }
}
