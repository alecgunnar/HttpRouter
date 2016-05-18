<?php

namespace AlecGunnar\HttpRouter\Test\Factory;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Factory\RouteFactory;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class RouteFactoryTest extends PHPUnit_Framework_TestCase
{
    protected function runTestsOnFactoryGeneratedRoute($route, $methods, $resource, $handler)
    {
        $this->assertAttributeEquals($methods, 'methods', $route);
        $this->assertAttributeEquals($resource, 'resource', $route);
        $this->assertAttributeEquals($handler, 'handler', $route);
    }

    public function testGetInstanceCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $methods = RouteFactory::HTTP_METHODS;
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->getInstance($methods, $resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, $methods, $resource, $handler);
    }

    public function testGetCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->get($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['GET'], $resource, $handler);
    }

    public function testPutCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->put($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PUT'], $resource, $handler);
    }

    public function testPostCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->post($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['POST'], $resource, $handler);
    }

    public function testPatchCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->patch($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PATCH'], $resource, $handler);
    }

    public function testDeleteCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->delete($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['DELETE'], $resource, $handler);
    }

    public function testAnyCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $resource = new Resource('/hello/world');
        $handler = function() { };

        $factory = new RouteFactory();

        $route = $factory->any($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, RouteFactory::HTTP_METHODS, $resource, $handler);
    }
}