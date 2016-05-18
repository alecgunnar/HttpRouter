<?php

namespace AlecGunnar\HttpRouter\Test\Entity;

use PHPUnit_Framework_TestCase;
use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class RouteTest extends PHPUnit_Framework_TestCase
{
    private $dummyResource;
    private $dummyHandler;

    public function __construct()
    {
        $this->dummyResource = new Resource('/');
        $this->dummyHandler = function () { };
    }

    public function testConstructorSetsAttributes()
    {
        $methods = ['GET', 'POST'];
        $resource = new Resource('/hello/world');
        $handler = function () { };

        $instance = new Route($methods, $resource, $handler);

        $this->assertAttributeEquals($methods, 'methods', $instance);
        $this->assertAttributeEquals($resource, 'resource', $instance);
        $this->assertAttributeEquals($handler, 'handler', $instance);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsExceptionIfNoMethodsAreProvided()
    {
        new Route([], $this->dummyResource, $this->dummyHandler);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMethodsThrowsExceptionIfNoMethodsAreProvided()
    {
        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler);

        $instance->setMethods([]);
    }

    public function testConstructorUppercasesMethods()
    {
        $given = ['get', 'pUt', 'posT', 'DeletE'];
        $expected = ['GET', 'PUT', 'POST', 'DELETE'];

        $instance = new Route($given, $this->dummyResource, $this->dummyHandler);

        $this->assertAttributeEquals($expected, 'methods', $instance);
    }

    public function testSetMethodsUppercasesMethodsAndReturnsSelf()
    {
        $given = ['get', 'pUt', 'posT', 'DeletE'];
        $expected = ['GET', 'PUT', 'POST', 'DELETE'];

        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler);

        $ret = $instance->setMethods($given);

        $this->assertAttributeEquals($expected, 'methods', $instance);
        $this->assertEquals($instance, $ret);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetMethodsReturnsListOfMethods()
    {
        $given = $expected = ['GET', 'POST'];

        $instance = new Route($given, $this->dummyResource, $this->dummyHandler);

        $this->assertEquals($expected, $instance->getMethods());
    }

    public function testSetResourceSetsAttributeAndReturnsSelf()
    {
        $given = $expected = new Resource('/hello');

        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler);

        $ret = $instance->setResource($given);

        $this->assertAttributeEquals($expected, 'resource', $instance);
        $this->assertEquals($instance, $ret);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetResourceReturnsResource()
    {
        $given = $expected = new Resource('/hello');

        $instance = new Route(['GET'], $given, $this->dummyHandler);

        $this->assertEquals($expected, $instance->getResource());
    }

    public function testSetHandlerSetsHandlerAndReturnsSelf()
    {
        $given = $expected = function () { };

        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler);

        $ret = $instance->setHandler($given);

        $this->assertAttributeEquals($expected, 'handler', $instance);
        $this->assertEquals($instance, $ret);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetHandlerReturnsHandler()
    {
        $given = $expected = function () { };

        $instance = new Route(['GET'], $this->dummyResource, $given);

        $this->assertEquals($expected, $instance->getHandler());
    }
}
