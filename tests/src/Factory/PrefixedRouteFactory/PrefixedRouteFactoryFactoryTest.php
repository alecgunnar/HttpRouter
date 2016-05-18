<?php

namespace AlecGunnar\HttpRouter\Test\Factory\PrefixedRouteFactory;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Factory\PrefixedRouteFactory\PrefixedRouteFactoryFactory;

class PrefixedRouteFactoryFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFactorySetsPrefix()
    {
        $given = $expected = '/hello';

        $factory = new PrefixedRouteFactoryFactory();
        $instance = $factory->getInstance($given);

        $this->assertAttributeEquals($expected, 'prefix', $instance);
    }
}