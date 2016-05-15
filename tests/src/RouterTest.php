<?php

use AlecGunnar\HttpRouter\Router;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;
use GuzzleHttp\Psr7\Request;

class RouterTest extends PHPUnit_Framework_TestCase
{
    private $dummyHandler;

    public function __construct()
    {
        $this->dummyHandler = function() { };
    }

    private function getDummyRequest($method, $path)
    {
        return new Request($method, 'http://localhost:80' . $path);
    }

    public function testConstructorSetsCollection()
    {
        $given = $expected = new RouteCollection();

        $instance = new Router($given);

        $this->assertAttributeEquals($expected, 'collection', $instance);
    }

    public function testGetMatchCanMatchStaticRoutes()
    {
        $method = 'GET';
        $path = '/hello/world';
        $route = new Route([$method], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest($method, $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        $match = $instance->getMatch($request);

        $this->assertEquals($route, $match->getRoute());
    }

    public function testGetMatchCanMatchDynamicRoutes()
    {
        $method = 'GET';
        $param = 'to';
        $to = 'wolfgang';
        $path = '/hello/' . $to;
        $pattern = '/hello/' . $param . ':[a-z]+';
        $params = [$param => $to];
        $route = new Route([$method], new Resource($pattern), $this->dummyHandler);
        $request = $this->getDummyRequest($method, $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        $match = $instance->getMatch($request);

        $this->assertEquals($route, $match->getRoute());
        $this->assertEquals($params, $match->getParams());
    }

    public function testGetMatchWontMatchIfMethodIsNotValid()
    {
        $path = '/hello/world';
        $route = new Route(['GET'], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest('POST', $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        $this->assertFalse($instance->getMatch($request));
    }

    public function testGetMatchWontMatchIfSecureIsNotValid()
    {
        $path = '/hello/world';
        $route = new Route(['GET'], new Resource($path), $this->dummyHandler, true);
        $request = $this->getDummyRequest('GET', $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        $this->assertFalse($instance->getMatch($request));
    }
}
