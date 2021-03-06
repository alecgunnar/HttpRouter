<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

interface RouteFactoryInterface
{
    /**
     * Add a new get route.
     *
     * @param string[] $methods
     * @param resource $resource
     * @param callable $handler
     * @param array    $options
     * @param string   $name
     *
     * @return Route
     */
    public function getInstance(array $methods, Resource $resource, callable $handler): Route;

    /**
     * Add a new get route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function get(Resource $resource, callable $handler): Route;

    /**
     * Add a new post route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function post(Resource $resource, callable $handler): Route;

    /**
     * Add a new put route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function put(Resource $resource, callable $handler): Route;

    /**
     * Add a new patch route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function patch(Resource $resource, callable $handler): Route;

    /**
     * Add a new delete route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function delete(Resource $resource, callable $handler): Route;

    /**
     * Add a new connect route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function connect(Resource $resource, callable $handler): Route;

    /**
     * Add a new options route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function options(Resource $resource, callable $handler): Route;

    /**
     * Add a new head route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function head(Resource $resource, callable $handler): Route;

    /**
     * Add a new trace route.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function trace(Resource $resource, callable $handler): Route;

    /**
     * Add a new route to match any method.
     *
     * @param resource $resource
     * @param callable $handler
     * @param string   $name
     *
     * @return Route
     */
    public function any(Resource $resource, callable $handler): Route;
}
