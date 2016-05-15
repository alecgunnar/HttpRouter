<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter;

use Psr\Http\Message\RequestInterface;
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
    private $collection;

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
    public function getMatches(RequestInterface $request): array
    {
        $matches = [];

        foreach ($this->collection->getRoutes() as $route) {
            $methodMatched = $this->checkMethod($request, $route);

            $resource = $route->getResource();

            if ($resource->isDynamic()) {
                if (preg_match_all(
                    $resource->getCompiledPath(),
                    $request->getUri()->getPath(),
                    $params
                ) == count($resource->getParams())) {
                    $matches[] = new Match($route, $methodMatched, array_combine($resource->getParams(), $params));
                }
            } else {
                if ($resource->getPath() == $request->getUri()->getPath()) {
                    $matches[] = new Match($route, $methodMatched);
                }
            }
        }

        return $matches;
    }

    private function checkMethod(RequestInterface $request, Route $route): bool
    {
        return in_array($request->getMethod(), $route->getMethods());
    }
}
