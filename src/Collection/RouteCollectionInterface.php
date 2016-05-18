<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Collection;

use AlecGunnar\HttpRouter\Entity\Route;

interface RouteCollectionInterface
{
    /**
     * Add a route to the collection.
     *
     * @param Route  $route The route entity to be added
     * @param string $name  An optional name for the route
     *
     * @return RouteCollectionInterface
     */
    public function withRoute(Route $route, string $name = null): RouteCollectionInterface;

    /**
     * Add a collection of routes to this collection.
     *
     * @param RouteCollectionInterface $collection
     *
     * @return RouteCollectionInterface
     */
    public function mergeCollection(RouteCollectionInterface $collection): RouteCollectionInterface;

    /**
     * Returns a named route.
     *
     * @throws InvalidArgumentException
     *
     * @param string $name The name to be searched for
     *
     * @return Route
     */
    public function getRouteByName(string $name): Route;

    /**
     * Returns the list of routes.
     *
     * @param bool $assoc=false Return the associative array of routes
     *
     * @return array
     */
    public function getRoutes(bool $assoc = false): array;
}
