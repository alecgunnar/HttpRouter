<?php

use AlecGunnar\HttpRouter\Entity\Resource;

class ResourceTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorTrimsPath()
    {
        $given = '/hello/world/';
        $expected = 'hello/world';

        $instance = new Resource($given);

        $this->assertAttributeEquals($expected, 'path', $instance);
    }

    public function testSetPathTrimsPath()
    {
        $given = '/hello/world/';
        $expected = 'hello/world';

        $instance = new Resource('/');

        $instance->setPath($given);

        $this->assertAttributeEquals($expected, 'path', $instance);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorThrowsExcecptionWhenEmptyPathProvided()
    {
        new Resource('');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPathThrowsExcecptionWhenEmptyPathProvided()
    {
        (new Resource('/hello'))->setPath('');
    }

    public function testConstructorCompilesPathWithoutDynamicParts()
    {
        $given = '/hello/world/';
        $expected = '^hello/world$';

        $instance = new Resource($given);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testSetPathCompilesPathWithoutDynamicParts()
    {
        $given = '/hello/world/';
        $expected = '^hello/world$';

        $instance = new Resource('/');

        $instance->setPath($given);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testConstructorCompilesPathWithDynamicParts()
    {
        $given = '/hello/name:[A-Za-z]+';
        $expected = '^hello/([A-Za-z]+)$';

        $instance = new Resource($given);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testSetPathCompilesPathWithDynamicParts()
    {
        $given = '/hello/name:[A-Za-z]+';
        $expected = '^hello/([A-Za-z]+)$';

        $instance = new Resource('/');

        $instance->setPath($given);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testWithPrefixPrependsToPath()
    {
        $suffix = '/world';
        $prefix = '/hello';
        $expected = 'hello/world';

        $instance = new Resource($suffix);

        $instance->withPrefix($prefix);

        $this->assertAttributeEquals($expected, 'path', $instance);
    }

    public function testWithPrefixRecompilesPath()
    {
        $suffix = '/world';
        $prefix = '/hello';
        $expected = '^hello/world$';

        $instance = new Resource($suffix);

        $instance->withPrefix($prefix);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testWithPrefixCompilesDynamicPrefix()
    {
        $suffix = '/from:[A-Z]+';
        $prefix = '/hello/to:[A-Z]+';
        $expected = '^hello/([A-Z]+)/([A-Z]+)$';

        $instance = new Resource($suffix);

        $instance->withPrefix($prefix);

        $this->assertAttributeEquals($expected, 'compiled', $instance);
    }

    public function testConstructorCollectsDynamicParamNames()
    {
        $given = '/hello/to:*/from:*';
        $expected = ['to', 'from'];

        $instance = new Resource($given);

        $this->assertAttributeEquals($expected, 'params', $instance);
    }

    public function testSetPathCollectsDynamicParamNames()
    {
        $given = '/hello/to:*/from:*';
        $expected = ['to', 'from'];

        $instance = new Resource('/');

        $instance->setPath($given);

        $this->assertAttributeEquals($expected, 'params', $instance);
    }

    public function testWithPrefixCollectsDynamicParamNamesFromPrefixAndAppendsThem()
    {
        $prefix = '/hello/to:*';
        $suffix = '/from:*';
        $expected = ['to', 'from'];

        $instance = new Resource($suffix);

        $instance->withPrefix($prefix);

        $this->assertAttributeEquals($expected, 'params', $instance);
    }

    public function testSetPathResetsCollectionOfParams()
    {
        $initial = '/hello/to:*';
        $override = '/bye/from:*';
        $expected = ['from'];

        $instance = new Resource($initial);

        $instance->setPath($override);

        $this->assertAttributeEquals($expected, 'params', $instance);
    }

    public function testIsDynamicRecognizesDynamicPaths()
    {
        $dynamic = '/hello/to:*';

        $instance = new Resource($dynamic);

        $this->assertTrue($instance->isDynamic());
    }

    /**
     * @depends testConstructorTrimsPath
     */
    public function testGetPathReturnsTrimmedPath()
    {
        $given = '/hello/world/';
        $expected = 'hello/world';

        $instance = new Resource($given);

        $this->assertEquals($expected, $instance->getPath());
    }

    /**
     * @depends testConstructorCompilesPathWithoutDynamicParts
     */
    public function testGetCompiledPathReturnsCompiledPath()
    {
        $given = '/hello/world';
        $expected = '^hello/world$';

        $instance = new Resource($given);

        $this->assertEquals($expected, $instance->getCompiledPath());
    }

    /**
     * @depends testSetPathCollectsDynamicParamNames
     */
    public function testGetParamsReturnsCollectionOfDynamicParamNames()
    {
        $given = '/hello/to:*/from:*';
        $expected = ['to', 'from'];

        $instance = new Resource($given);

        $this->assertEquals($expected, $instance->getParams());
    }
}
