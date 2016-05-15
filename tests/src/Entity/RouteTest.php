<?php

use AlecGunnar\HttpRouter\Entity\Route;
use AlecGunnar\HttpRouter\Entity\Resource;

class RouteTeach extends PHPUnit_Framework_TestCase
{
    private $dummyResource;
    private $dummyHandler;

    public function __construct()
    {
        $this->dummyResource = new Resource('/');
        $this->dummyHandler = function() { };
    }

    public function testConstructorSetsAttributes()
    {
        $methods = ['GET', 'POST'];
        $resource = new Resource('/hello/world');
        $handler = function() { };
        $secure = false; // Should default to false

        $instance = new Route($methods, $resource, $handler);

        $this->assertAttributeEquals($methods, 'methods', $instance);
        $this->assertAttributeEquals($resource, 'resource', $instance);
        $this->assertAttributeEquals($handler, 'handler', $instance);
        $this->assertAttributeEquals($secure, 'secure', $instance);
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

    public function testSetSecureSetsSecureAndReturnsSelf()
    {
        $given = $expected = true;

        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler);

        $ret = $instance->setSecure($given);

        $this->assertAttributeEquals($expected, 'secure', $instance);
        $this->assertEquals($instance, $ret);
    }

    /**
     * @depends testConstructorSetsAttributes
     */
    public function testGetSecureReturnsOptions()
    {
        $given = $expected = true;

        $instance = new Route(['GET'], $this->dummyResource, $this->dummyHandler, $given);

        $this->assertEquals($expected, $instance->getSecure());
    }

    private function runTestsOnFactoryGeneratedRoute($route, $methods, $path, $handler, $secure)
    {
        $this->assertAttributeEquals($methods, 'methods', $route);
        $this->assertAttributeInstanceOf('AlecGunnar\HttpRouter\Entity\Resource', 'resource', $route);
        $this->assertAttributeEquals($handler, 'handler', $route);
        $this->assertAttributeEquals($secure, 'secure', $route);

        $resource = $route->getResource();

        $this->assertAttributeEquals($path, 'path', $resource);
    }

    public function testMatchCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $methods = Route::HTTP_METHODS;
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::match($methods, $path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, $methods, $path, $handler, $secure);
    }

    public function testGetCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::get($path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, ['GET'], $path, $handler, $secure);
    }

    public function testPutCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::put($path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PUT'], $path, $handler, $secure);
    }

    public function testPostCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::post($path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, ['POST'], $path, $handler, $secure);
    }

    public function testPatchCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::patch($path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, ['PATCH'], $path, $handler, $secure);
    }

    public function testDeleteCreatesNewRouteUsingArgumentsAndReturnsIt()
    {
        $path = 'hello/world';
        $handler = function() { };
        $secure = true;

        $route = Route::delete($path, $handler, $secure);

        $this->runTestsOnFactoryGeneratedRoute($route, ['DELETE'], $path, $handler, $secure);
    }
}
