<?php

namespace Devsdmf\Tests\Annotations\Adapter;

use Devsdmf\Annotations\Adapter\ReflectionFunctionAdapter;

class ReflectionFunctionAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $adapter = new ReflectionFunctionAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\Adapter\ReflectionFunctionAdapter',$adapter);
        return $adapter;
    }

    /**
     * @depends testInitialize
     * @param ReflectionFunctionAdapter $adapter
     */
    public function testGetDocBlock($adapter)
    {
        $reflector = new \ReflectionFunction('str_replace');
        $this->assertNotNull($adapter->getDocBlock($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\InvalidReflectorException
     * @param ReflectionFunctionAdapter $adapter
     */
    public function testGetDocBlockFail($adapter)
    {
        $adapter->getDocBlock(new \stdClass());
    }
}
