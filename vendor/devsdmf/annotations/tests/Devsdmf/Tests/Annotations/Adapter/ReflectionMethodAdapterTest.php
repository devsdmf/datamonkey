<?php

namespace Devsdmf\Tests\Annotations\Adapter;

use Devsdmf\Annotations\Adapter\ReflectionMethodAdapter;

class ReflectionMethodAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $adapter = new ReflectionMethodAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\Adapter\ReflectionMethodAdapter',$adapter);
        return $adapter;
    }

    /**
     * @depends testInitialize
     * @param ReflectionMethodAdapter $adapter
     */
    public function testGetDocBlock($adapter)
    {
        $reflector = new \ReflectionMethod(__METHOD__);
        $this->assertNotNull($adapter->getDocBlock($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\InvalidReflectorException
     * @param ReflectionMethodAdapter $adapter
     */
    public function testGetDocBlockFail($adapter)
    {
        $adapter->getDocBlock(new \stdClass());
    }
}
