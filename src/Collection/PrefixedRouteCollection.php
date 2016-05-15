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

class PrefixedRouteCollection extends RouteCollection
{
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

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function withRoute(Route $route, string $name=null): RouteCollectionInterface
    {
        $route->getResource()
            ->withPrefix($this->prefix->getPath());

        return parent::withRoute($route, $name);
    }

    /**
     * @inheritDoc
     */
    public function mergeCollection(RouteCollectionInterface $collection): RouteCollectionInterface
    {
        foreach ($collection->getRoutes() as $route) {
            $route->getResource()
                ->withPrefix($this->prefix->getPath());
        }

        return parent::mergeCollection($collection);
    }
}
