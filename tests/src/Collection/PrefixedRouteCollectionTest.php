<?php

namespace AlecGunnar\HttpRouter\Test\Collection;

use AlecGunnar\HttpRouter\Collection\PrefixedRouteCollection;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class PrefixedRouteCollectionTest extends SharedRouteCollectionTests
{
    public function getInstance(string $prefix=null)
    {
        return new PrefixedRouteCollection(new Resource($prefix ?? '/'));
    }

    public function getDummyRoute(string $path=null)
    {
        return parent::getDummyRoute()->setResource(new Resource($path ?? '/'));
    }

    public function testWithRouteAddsPrefixToRoute()
    {
        $prefix = '/hello';
        $path = '/world';
        $route = $this->getDummyRoute($path);
        $expected = '/hello/world';

        $instance = $this->getInstance($prefix);
        $instance->withRoute($route);

        $this->assertEquals($expected, $route->getResource()->getPath());
    }

    public function testMergeCollectionMergesRoutes()
    {
        $collection = new RouteCollection();

        $route1 = $this->getDummyRoute()->setResource(new Resource('/world'));
        $name1 = 'test-dummy-route1';
        $route2 = $this->getDummyRoute()->setResource(new Resource('/sally'));
        $route3 = $this->getDummyRoute()->setResource(new Resource('/bob'));
        $prefix = new Resource('/hello');
        $expected = '/hello/world';

        $collection->withRoute($route1, $name1);

        $instance = new PrefixedRouteCollection($prefix);

        $instance->withRoute($route2)
            ->withRoute($route3)
            ->mergeCollection($collection);

        $this->assertEquals(
            $expected,
            $instance->getRouteByName($name1)
                ->getResource()
                ->getPath()
        );
    }
}
