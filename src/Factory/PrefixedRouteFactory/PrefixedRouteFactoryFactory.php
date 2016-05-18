<?php
/**
 * HTTP Routing Library
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory;

use AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory;

class PrefixedRouteFactoryFactory implements PrefixedRouteFactoryFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getInstance(string $prefix): PrefixedRouteFactory
    {
        return new PrefixedRouteFactory($prefix);
    }
}
