<?php

use AlecGunnar\HttpRouter\Entity\Match;
use AlecGunnar\HttpRouter\Entity\Route;

class MatchTest extends PHPUnit_Framework_TestCase
{
    private $dummyRoute;

    public function __construct()
    {
        $this->dummyRoute = new class extends Route {
            public function __construct() { }
        };
    }

    public function testConstructorSetsAttributes()
    {
        $route = new class extends Route {
            public function __construct() { }
        };
        $methodToo = false;
        $params = ['a' => 'b', 'c' => 'd'];

        $instance = new Match($route, $methodToo, $params);

        $this->assertAttributeEquals($route, 'route', $instance);
        $this->assertAttributeEquals($methodToo, 'methodToo', $instance);
        $this->assertAttributeEquals($params, 'params', $instance);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetRouteReturnsRoute()
    {
        $given = $expected = new class extends Route {
            public function __construct() { }
        };

        $instance = new Match($given);

        $this->assertEquals($expected, $instance->getRoute());
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetMethodTooReturnsMethodToo()
    {
        $given = $expected = true;

        $instance = new Match($this->dummyRoute, $given);

        $this->assertEquals($expected, $instance->getMethodToo());
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetPatamsReturnsParams()
    {
        $given = $expected = ['a' => 'b', 'c' => 'd'];

        $instance = new Match($this->dummyRoute, false, $given);

        $this->assertEquals($expected, $instance->getParams());
    }
}
