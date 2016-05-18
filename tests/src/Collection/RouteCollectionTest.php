<?php

namespace AlecGunnar\HttpRouter\Test\Collection;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Entity\Route;

class RouteCollectionTest extends PHPUnit_Framework_TestCase
{
    public function getInstance()
    {
        return new RouteCollection();
    }

    public function getDummyRoute()
    {
        return new class extends Route {
            public function __construct() { }
        };
    }

    public function testWithRouteAddsRouteToListAndReturnsSelf()
    {
        $given = $this->getDummyRoute();
        $expected = [$given];

        $instance = $this->getInstance();

        $ret = $instance->withRoute($given);

        $this->assertAttributeEquals($expected, 'routes', $instance);
        $this->assertEquals($instance, $ret);
    }

    public function testWithRouteAddsNameWhenSupplied()
    {
        $name = 'test-route';
        $route = $this->getDummyRoute();
        $expected = [$name => $route];

        $instance = $this->getInstance();

        $instance->withRoute($route, $name);

        $this->assertAttributeEquals($expected, 'routes', $instance);
    }

    public function testWithRouteOverridesRouteWithSameName()
    {
        $route1 = $this->getDummyRoute();
        $route2 = $this->getDummyRoute();
        $name = 'test-dummy-route';
        $expected = [$name => $route2];

        $instance = $this->getInstance();

        $instance->withRoute($route1, $name);
        $instance->withRoute($route2, $name);

        $this->assertAttributeEquals($expected, 'routes', $instance);
    }

    public function testGetRouteByNameReturnsTheRouteWhenItExists()
    {
        $route = $this->getDummyRoute();
        $name = 'test-route';

        $instance = $this->getInstance();

        $instance->withRoute($route, $name);

        $this->assertEquals($route, $instance->getRouteByName($name));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetRouteByNameThrowsExceptionWhenItDoesNotExist()
    {
        $instance = $this->getInstance();

        $instance->getRouteByName('test-route');
    }

    /**
     * @depends testWithRouteAddsRouteToListAndReturnsSelf
     */
    public function testGetRoutesReturnsAllRoutesAsIndexedArrayByDefault()
    {
        $route1 = $this->getDummyRoute()->setMethods(['GET']);
        $route2 = $this->getDummyRoute()->setMethods(['POST']);
        $expected = [$route1, $route2];

        $instance = $this->getInstance();

        $instance->withRoute($route1)
            ->withRoute($route2, 'named-route');

        $this->assertEquals($expected, $instance->getRoutes());
    }

    /**
     * @depends testWithRouteAddsRouteToListAndReturnsSelf
     */
    public function testGetRoutesReturnsAllRoutesWithTheirNamesWhenToldTo()
    {
        $route1 = $this->getDummyRoute()->setMethods(['GET']);
        $route2 = $this->getDummyRoute()->setMethods(['POST']);
        $name = 'named-route';
        $expected = [$route1, $name => $route2];

        $instance = $this->getInstance();

        $instance->withRoute($route1)
            ->withRoute($route2, $name);

        $this->assertEquals($expected, $instance->getRoutes(true));
    }

    /**
     * @depends testGetRoutesReturnsAllRoutesWithTheirNamesWhenToldTo
     */
    public function testMergeCollectionMergesRoutes()
    {
        $collection = $this->getInstance();

        $route1 = $this->getDummyRoute();
        $name1 = 'test-dummy-route1';
        $route2 = $this->getDummyRoute();
        $route3 = $this->getDummyRoute();
        $name3 = 'test-dummy-route3';
        $route4 = $this->getDummyRoute();
        $expected = [
            $name1 => $route1,
            $route2,
            $name3 => $route3,
            $route4
        ];

        $collection->withRoute($route1, $name1)
            ->withRoute($route2);

        $instance = $this->getInstance();

        $instance->withRoute($route3, $name3)
            ->withRoute($route4)
            ->mergeCollection($collection);

        $this->assertAttributeEquals($expected, 'routes', $instance);
    }

    /**
     * @depends testGetRoutesReturnsAllRoutesWithTheirNamesWhenToldTo
     */
    public function testMergeCollectionWillOverrideRoutesWithSameName()
    {
        $collection = $this->getInstance();

        $route1 = $this->getDummyRoute();
        $name1 = 'test-dummy-route1';
        $route2 = $this->getDummyRoute();
        $route3 = $this->getDummyRoute();
        $name3 = $name1;
        $route4 = $this->getDummyRoute();
        $expected = [
            $name1 => $route3,
            $route2,
            $route4
        ];

        $collection->withRoute($route1, $name1)
            ->withRoute($route2);

        $instance = $this->getInstance();

        $instance->withRoute($route3, $name3)
            ->withRoute($route4)
            ->mergeCollection($collection);

        $this->assertAttributeEquals($expected, 'routes', $instance);
    }
}
