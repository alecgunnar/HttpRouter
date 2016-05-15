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
        return new Request($method, 'http://localhost' . $path);
    }

    public function testConstructorSetsCollection()
    {
        $given = $expected = new RouteCollection();

        $instance = new Router($given);

        $this->assertAttributeEquals($expected, 'collection', $instance);
    }

    public function testGetMatchesCanMatchStaticRoutes()
    {
        $method = 'GET';
        $path = '/hello/world';
        $route = new Route([$method], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest($method, $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        list($match) = $instance->getMatches($request);

        $this->assertEquals($route, $match->getRoute());
    }

    public function testGetMatchesCanMatchDynamicRoutes()
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

        list($match) = $instance->getMatches($request);

        $this->assertEquals($route, $match->getRoute());
        $this->assertEquals($params, $match->getParams());
    }

    /**
     * @depends testGetMatchesCanMatchStaticRoutes
     */
    public function testRouterSetsWhetherTheMethodMatches()
    {
        $path = '/hello/world';

        $route = new Route(['GET'], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest('GET', $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        list($match) = $instance->getMatches($request);

        $this->assertTrue($match->getMethodToo());
    }

    /**
     * @depends testGetMatchesCanMatchStaticRoutes
     */
    public function testRouterCanCheckMultiplePossibleMethods()
    {
        $path = '/hello/world';

        $route = new Route(['GET', 'POST', 'PUT', 'DELETE'], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest('POST', $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = new Router($collection);

        list($match) = $instance->getMatches($request);

        $this->assertTrue($match->getMethodToo());
    }
}
