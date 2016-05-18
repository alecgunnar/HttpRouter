<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter;

use Psr\Http\Message\ServerRequestInterface;
use AlecGunnar\HttpRouter\Collection\RouteCollectionInterface;
use AlecGunnar\HttpRouter\Entity\Match;
use AlecGunnar\HttpRouter\Entity\Route;

class Router implements RouterInterface
{
    /**
     * The collection of routes to be scanned
     *
     * @var RouteCollectionInterface
     */
    protected $collection;

    /**
     * @param RouteCollectionInterface $collection The collection of routes to be used
     */
    public function __construct(RouteCollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function getMatch(ServerRequestInterface $request)
    {
        $matches = [];

        foreach ($this->collection->getRoutes() as $route) {
            if (!$this->checkHttpMethod($request, $route)) {
                continue;
            }

            $resource = $route->getResource();
            $match = null;

            if ($resource->isDynamic()) {
                $match = $this->checkDynamicRoute($request, $route);
            } else {
                $match = $this->checkStaticRoute($request, $route);
            }

            if ($match instanceof Match) {
                return $match;
            }
        }

        return false;
    }

    protected function checkHttpMethod(ServerRequestInterface $request, Route $route): bool
    {
        return in_array($request->getMethod(), $route->getMethods());
    }

    protected function checkStaticRoute(ServerRequestInterface $request, Route $route)
    {
        if ($route->getResource()->getPath() == $request->getUri()->getPath()) {
            return new Match($route);
        }
    }

    protected function checkDynamicRoute(ServerRequestInterface $request, Route $route)
    {
        $resource = $route->getResource();

        if (preg_match(
            '#' . $resource->getCompiledPath() . '#',
            $request->getUri()->getPath(),
            $params
        ) == count($resource->getParams())) {
            array_shift($params);
            return new Match($route, array_combine($resource->getParams(), $params));
        }
    }
}
