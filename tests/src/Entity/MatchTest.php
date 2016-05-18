<?php

namespace AlecGunnar\HttpRouter\Test\Entity;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Entity\Match;
use AlecGunnar\HttpRouter\Entity\Route;

class MatchTest extends PHPUnit_Framework_TestCase
{
    private $dummyRoute;

    public function __construct()
    {
        $this->dummyRoute = new class extends Route
 {
     public function __construct()
     {
     }
 };
    }

    public function testConstructorSetsAttributes()
    {
        $route = new class extends Route
 {
     public function __construct()
     {
     }
 };
        $params = ['a' => 'b', 'c' => 'd'];

        $instance = new Match($route, $params);

        $this->assertAttributeEquals($route, 'route', $instance);
        $this->assertAttributeEquals($params, 'params', $instance);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetRouteReturnsRoute()
    {
        $given = $expected = new class extends Route
 {
     public function __construct()
     {
     }
 };

        $instance = new Match($given);

        $this->assertEquals($expected, $instance->getRoute());
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetPatamsReturnsParams()
    {
        $given = $expected = ['a' => 'b', 'c' => 'd'];

        $instance = new Match($this->dummyRoute, $given);

        $this->assertEquals($expected, $instance->getParams());
    }
}
