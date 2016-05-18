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

class PrefixedRouteCollection implements RouteCollectionInterface
{
    use RouteCollectionTrait;

    /**
     * The prefix for the routes in this collection
     *
     * @var Resource
     */
    protected $prefix;

    /**
     * @param Resource $prefix
     */
    public function __construct(Resource $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @inheritDoc
     */
    public function withRoute(Route $route, string $name=null): RouteCollectionInterface
    {
        $route->getResource()
            ->withPrefix($this->prefix->getPath());

        if ($name !== null) {
            $this->routes[$name] = $route;
        } else {
            $this->routes[] = $route;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mergeCollection(RouteCollectionInterface $collection): RouteCollectionInterface
    {
        $routes = $collection->getRoutes(true);

        foreach ($routes as $route) {
            $route->getResource()
                ->withPrefix($this->prefix->getPath());
        }

        $this->routes = array_merge($this->routes, $routes);

        return $this;
    }
}
