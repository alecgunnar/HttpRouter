<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Collection;

use AlecGunnar\HttpRouter\Entity\Resource;
use AlecGunnar\HttpRouter\Entity\Route;
use InvalidArgumentException;

trait RouteCollectionTrait
{
    /**
     * The list of routes
     *
     * @var array
     */
    protected $routes = [];

    /**
     * @inheritDoc
     */
    public function withRoute(Route $route, string $name=null): RouteCollectionInterface
    {
        if (is_null($name)) {
            $this->routes[] = $route;
        } else {
            $this->routes[$name] = $route;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mergeCollection(RouteCollectionInterface $collection): RouteCollectionInterface
    {
        $this->routes = array_merge($this->routes, $collection->getRoutes(true));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRouteByName(string $name): Route
    {
        if (!isset($this->routes[$name])) {
            throw new InvalidArgumentException('A route named ' . $name . ' does not exist.');
        }

        return $this->routes[$name];
    }

    /**
     * @inheritDoc
     */
    public function getRoutes(bool $assoc=false): array
    {
        if ($assoc) {
            return $this->routes;
        }

        return array_values($this->routes);
    }
}
