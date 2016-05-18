<?php

namespace AlecGunnar\HttpRouter\Test\Factory\PrefixedRouteFactory;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Factory\ResourceFactory;

class ResourceFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testGetInstanceSetsPath()
    {
        $given = $expected = '/hello/world';

        $factory = new ResourceFactory();

        $instance = $factory->getInstance($given);

        $this->assertAttributeEquals($expected, 'path', $instance);
    }
}
