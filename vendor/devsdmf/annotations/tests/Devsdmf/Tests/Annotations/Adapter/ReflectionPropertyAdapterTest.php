<?php

namespace Devsdmf\Tests\Annotations\Adapter;

use Devsdmf\Annotations\Adapter\ReflectionPropertyAdapter;

class ReflectionPropertyAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $adapter = new ReflectionPropertyAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\Adapter\ReflectionPropertyAdapter',$adapter);
        return $adapter;
    }

    /**
     * @depends testInitialize
     * @param ReflectionPropertyAdapter $adapter
     */
    public function testGetDocBlock($adapter)
    {
        $reflector = new \ReflectionProperty('ReflectionClass','name');
        $this->assertNotNull($adapter->getDocBlock($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\InvalidReflectorException
     * @param ReflectionPropertyAdapter $adapter
     */
    public function testGetDocBlockFail($adapter)
    {
        $adapter->getDocBlock(new \stdClass());
    }
}
