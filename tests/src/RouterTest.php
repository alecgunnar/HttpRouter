<?php

namespace AlecGunnar\HttpRouter\Test;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Router;
use AlecGunnar\HttpRouter\Collection\RouteCollection;
use AlecGunnar\HttpRouter\Factory\MatchFactory;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;
use AlecGunnar\HttpRouter\Entity\Match;
use GuzzleHttp\Psr7\ServerRequest;

class RouterTest extends PHPUnit_Framework_TestCase
{
    private $dummyHandler;

    public function __construct()
    {
        $this->dummyHandler = function() { };
    }

    protected function getInstance($collection, $matchFactory=null)
    {
        return new Router($collection, $matchFactory ?? new MatchFactory());
    }

    private function getDummyRequest($method, $path)
    {
        return new ServerRequest($method, 'http://localhost:80' . $path);
    }

    public function testConstructorSetsCollection()
    {
        $given = $expected = new RouteCollection();

        $instance = $this->getInstance($given);

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

        $matchFactory = $this->getMockBuilder(MatchFactory::class)
            ->getMock();

        $matchFactory->expects($this->once())
            ->method('getInstance')
            ->with($route)
            ->will($this->returnValue(new Match($route)));

        $instance = $this->getInstance($collection, $matchFactory);

        $match = $instance->getMatch($request);
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

        $matchFactory = $this->getMockBuilder(MatchFactory::class)
            ->getMock();

        $matchFactory->expects($this->once())
            ->method('getInstance')
            ->with($route, $params)
            ->will($this->returnValue(new Match($route, $params)));

        $instance = $this->getInstance($collection, $matchFactory);

        $match = $instance->getMatch($request);
    }

    public function testGetMatchWontMatchIfMethodIsNotValid()
    {
        $path = '/hello/world';
        $route = new Route(['GET'], new Resource($path), $this->dummyHandler);
        $request = $this->getDummyRequest('POST', $path);

        $collection = new RouteCollection();
        $collection->withRoute($route);

        $instance = $this->getInstance($collection);

        $this->assertFalse($instance->getMatch($request));
    }
}
