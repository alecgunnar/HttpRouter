<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

interface RouteFactoryInterface
{
    /**
     * Add a new get route
     *
     * @param string[] $methods
     * @param Resource $resource
     * @param callable $handler
     * @param array $options
     * @param string $name
     * @return Route
     */
    public function getInstance(array $methods, Resource $resource, callable $handler): Route;

    /**
     * Add a new get route
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function get(Resource $resource, callable $handler): Route;

    /**
     * Add a new post route
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function post(Resource $resource, callable $handler): Route;

    /**
     * Add a new put route
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function put(Resource $resource, callable $handler): Route;

    /**
     * Add a new patch route
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function patch(Resource $resource, callable $handler): Route;

    /**
     * Add a new delete route
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function delete(Resource $resource, callable $handler): Route;

    /**
     * Add a new route to match any method
     *
     * @param Resource $resource
     * @param callable $handler
     * @param string $name
     * @return Route
     */
    public function any(Resource $resource, callable $handler): Route;
}
