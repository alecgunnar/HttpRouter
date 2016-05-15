<?php

use AlecGunnar\HttpRouter\Router;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Entity\Route;
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

        $matches = $instance->getMatches($request);

        $this->assertEquals($route, $matches[0]->getRoute());
    }
}
