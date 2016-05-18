<?php

namespace AlecGunnar\HttpRouter\Test\Collection;

use AlecGunnar\HttpRouter\Collection\RouteCollection;

class RouteCollectionTest extends SharedRouteCollectionTests
{
    public function getInstance()
    {
        return new RouteCollection();
    }
}
