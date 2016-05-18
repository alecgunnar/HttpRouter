<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory;

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class PrefixedRouteFactory extends RouteFactory
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param string $prefix The prefix to be prepended to each route's resource
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @inheritDoc
     */
    public function match(array $methods, Resource $resource, callable $handler): Route
    {
        $resource->withPrefix($this->prefix);

        return new Route($methods, $resource, $handler);
    }
}
