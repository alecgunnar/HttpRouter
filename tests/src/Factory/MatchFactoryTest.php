<?php

namespace AlecGunnar\HttpRouter\Test\Factory\PrefixedRouteFactory;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Factory\MatchFactory;
use AlecGunnar\HttpRouter\Entity\Route;

class MatchFactoryTest extends PHPUnit_Framework_TestCase
{
    protected function getDummyRoute()
    {
        return new class extends Route
 {
     public function __construct()
     {
     }
 };
    }

    public function testGetInstanceSetsRoute()
    {
        $given = $expected = $this->getDummyRoute();

        $factory = new MatchFactory();

        $instance = $factory->getInstance($given);

        $this->assertAttributeEquals($expected, 'route', $instance);
    }

    public function testGetInstanceSetsParams()
    {
        $route = $this->getDummyRoute();
        $given = $expected = ['key' => 'value', 'name' => 'value2'];

        $factory = new MatchFactory();

        $instance = $factory->getInstance($route, $given);

        $this->assertAttributeEquals($expected, 'params', $instance);
    }
}
