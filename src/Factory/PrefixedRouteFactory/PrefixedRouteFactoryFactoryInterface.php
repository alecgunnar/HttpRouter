<?php
/**
 * HTTP Routing Library.
 *
 * @author Alec Carpenter <alecgunnar@gmail.com>
 */

namespace AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory;

use AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory;

interface PrefixedRouteFactoryFactoryInterface
{
    /**
     * @param string $prefix
     */
    public function getInstance(string $prefix): PrefixedRouteFactory;
}
