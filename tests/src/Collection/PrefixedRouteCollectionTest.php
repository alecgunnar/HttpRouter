<?php

use AlecGunnar\HttpRouter\Collection\PrefixedRouteCollection;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class PrefixedRouteCollectionTest extends PHPUnit_Framework_TestCase
{
    public function getDummyRoute()
    {
        return new class extends Route {
            public function __construct() { }
        };
    }

    public function testConstructorSetsPrefixAndDefaultValuesToAttributes()
    {
        $given = $expected = new Resource('/hello');
        $routes = [];
        $position = 0;

        $instance = new PrefixedRouteCollection($given);

        $this->assertAttributeEquals($expected, 'prefix', $instance);
        $this->assertAttributeEquals($routes, 'routes', $instance);
        $this->assertAttributeEquals($position, 'position', $instance);
    }

    public function testCollectionWithPrefixAppendsPrefixToRoute()
    {
        $prefix = new Resource('/hello');
        $path = new Resource('/to:*');
        $route = $this->getDummyRoute()->setResource($path);
        $expected = 'hello/to:*';

        $instance = new PrefixedRouteCollection($prefix);

        $instance->withRoute($route);

        $this->assertEquals($expected, $route->getResource()->getPath());
    }

    public function testRoutesInMergedCollectionReceivePrefix()
    {
        $collection = new RouteCollection();

        $route1 = $this->getDummyRoute()->setResource(new Resource('/world'));
        $name1 = 'test-dummy-route1';
        $route2 = $this->getDummyRoute()->setResource(new Resource('/sally'));
        $route3 = $this->getDummyRoute()->setResource(new Resource('/bob'));
        $prefix = new Resource('/hello');
        $expected = 'hello/world';

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
