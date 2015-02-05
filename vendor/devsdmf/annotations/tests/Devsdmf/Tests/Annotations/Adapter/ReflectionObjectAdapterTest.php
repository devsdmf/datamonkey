<?php

namespace Devsdmf\Tests\Annotations\Adapter;

use Devsdmf\Annotations\Adapter\ReflectionObjectAdapter;

class ReflectionObjectAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $adapter = new ReflectionObjectAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\Adapter\ReflectionObjectAdapter',$adapter);
        return $adapter;
    }

    /**
     * @depends testInitialize
     * @param ReflectionObjectAdapter $adapter
     */
    public function testGetDocBlock($adapter)
    {
        $reflector = new \ReflectionObject($this);
        $this->assertNotNull($adapter->getDocBlock($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\InvalidReflectorException
     * @param ReflectionObjectAdapter $adapter
     */
    public function testGetDocBlockFail($adapter)
    {
        $adapter->getDocBlock(new \stdClass());
    }
}
