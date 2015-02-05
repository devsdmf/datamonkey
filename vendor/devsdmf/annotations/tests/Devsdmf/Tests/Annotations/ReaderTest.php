<?php

namespace Devsdmf\Tests\Annotations;

use Devsdmf\Annotations\Reader;

/**
 * Class ReaderTest
 * @package Devsdmf\Tests\Annotations
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $reader = new Reader();
        $this->assertInstanceOf('\Devsdmf\Annotations\Reader',$reader);

        return $reader;
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetAnnotations($reader)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertNotNull($reader->getAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetAnnotation($reader)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertNotNull($reader->getAnnotation($reflector,'package'));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetClassAnnotations($reader)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertNotNull($reader->getClassAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetClassAnnotation($reader)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertNotNull($reader->getClassAnnotation($reflector,'package'));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetFunctionAnnotations($reader)
    {
        $reflector = new \ReflectionFunction('str_replace');
        $this->assertNotNull($reader->getFunctionAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetFunctionAnnotation($reader)
    {
        $reflector = new \ReflectionFunction('test_function');
        $this->assertNotNull($reader->getFunctionAnnotation($reflector,'name'));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetMethodAnnotations($reader)
    {
        $reflector = new \ReflectionMethod(__METHOD__);
        $this->assertNotNull($reader->getMethodAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetMethodAnnotation($reader)
    {
        $reflector = new \ReflectionMethod(__METHOD__);
        $this->assertNotNull($reader->getMethodAnnotation($reflector,'depends'));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetObjectAnnotations($reader)
    {
        $reflector = new \ReflectionObject($this);
        $this->assertNotNull($reader->getObjectAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetObjectAnnotation($reader)
    {
        $reflector = new \ReflectionObject($this);
        $this->assertNotNull($reader->getObjectAnnotation($reflector,'package'));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetPropertyAnnotations($reader)
    {
        $reflector = new \ReflectionProperty('CustomTestClass','name');
        $this->assertNotNull($reader->getPropertyAnnotations($reflector));
    }

    /**
     * @depends testInitialize
     * @param Reader $reader
     */
    public function testGetPropertyAnnotation($reader)
    {
        $reflector = new \ReflectionProperty('CustomTestClass','name');
        $this->assertNotNull($reader->getPropertyAnnotation($reflector,'var'));
    }
}
