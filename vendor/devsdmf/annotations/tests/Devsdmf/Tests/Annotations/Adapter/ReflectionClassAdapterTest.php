<?php

namespace Devsdmf\Tests\Annotations\Adapter;

use Devsdmf\Annotations\Adapter\ReflectionClassAdapter;

class ReflectionClassAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $adapter = new ReflectionClassAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\Adapter\ReflectionClassAdapter',$adapter);
        return $adapter;
    }

    /**
     * @depends testInitialize
     * @param ReflectionClassAdapter $adapter
     */
    public function testGetDocBlock($adapter)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertNotNull($adapter->getDocBlock($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\InvalidReflectorException
     * @param ReflectionClassAdapter $adapter
     */
    public function testGetDocBlockFail($adapter)
    {
        $adapter->getDocBlock(new \stdClass());
    }
}
