<?php

namespace AlecGunnar\HttpRouter\Test\Factory;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class PrefixedRouteFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $path = '/world';
    protected $prefix = '/hello';

    protected function getInstance()
    {
        return new PrefixedRouteFactory($this->prefix);
    }

    protected function runTestsOnFactoryGeneratedRoute($route, $methods, $resource, $handler)
    {
        $this->assertAttributeEquals($methods, 'methods', $route);
        $this->assertAttributeEquals($resource, 'resource', $route);
        $this->assertAttributeEquals($handler, 'handler', $route);

        $this->assertEquals($this->prefix . $this->path, $resource->getPath());
    }

    public function testGetInstanceCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $methods = Route::HTTP_METHODS;
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->getInstance($methods, $resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, $methods, $resource, $handler);
    }

    public function testGetCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->get($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['GET'], $resource, $handler);
    }

    public function testPutCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->put($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PUT'], $resource, $handler);
    }

    public function testPostCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->post($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['POST'], $resource, $handler);
    }

    public function testPatchCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->patch($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PATCH'], $resource, $handler);
    }

    public function testDeleteCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->delete($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, ['DELETE'], $resource, $handler);
    }

    public function testAnyCreatesNewRouteUsingArgumentsPrependsPrefixAndReturnsIt()
    {
        $resource = new Resource($this->path);
        $handler = function() { };

        $factory = $this->getInstance();

        $route = $factory->any($resource, $handler);

        $this->runTestsOnFactoryGeneratedRoute($route, Route::HTTP_METHODS, $resource, $handler);
    }
}