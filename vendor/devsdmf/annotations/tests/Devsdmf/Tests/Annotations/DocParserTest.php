<?php

namespace Devsdmf\Tests\Annotations;

use Devsdmf\Annotations\Adapter\ReflectionClassAdapter;
use Devsdmf\Annotations\DocParser;

class DocParserTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $parser = new DocParser();
        $this->assertInstanceOf('\Devsdmf\Annotations\DocParser',$parser);

        return $parser;
    }

    /**
     * @depends testInitialize
     * @param DocParser $parser
     */
    public function testSetReflectorWithAutoDiscoverAdapter($parser)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertInstanceOf('\Devsdmf\Annotations\DocParser',$parser->setReflector($reflector));
    }

    /**
     * @depends testInitialize
     * @expectedException \Devsdmf\Annotations\Exception\AdapterNotFoundException
     * @param DocParser $parser
     */
    public function testSetReflectorWithAutoDiscoverAdapterFail($parser)
    {
        $reflector = new \ReflectionParameter('str_replace','search');
        $parser->setReflector($reflector);
    }

    /**
     * @depends testInitialize
     * @param DocParser $parser
     */
    public function testSetReflectorWithoutAutoDiscoverAdapter($parser)
    {
        $reflector = new \ReflectionClass($this);
        $this->assertInstanceOf('\Devsdmf\Annotations\DocParser',$parser->setReflector($reflector,false));
    }

    /**
     * @depends testInitialize
     * @param DocParser $parser
     */
    public function testSetAdapter($parser)
    {
        $adapter = new ReflectionClassAdapter();
        $this->assertInstanceOf('\Devsdmf\Annotations\DocParser',$parser->setAdapter($adapter));
    }

    /**
     * @depends testInitialize
     * @param DocParser $parser
     */
    public function testParseWithInput($parser)
    {
        $input = '/**
                   * @var1 value1
                   * @var2 value2
                   */';
        $result = $parser->parse($input);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('var1',$result);
        $this->assertArrayHasKey('var2',$result);
        $this->assertEquals($result['var1'],'value1');
        $this->assertEquals($result['var2'],'value2');
    }

    /**
     * @depends testInitialize
     * @depends testSetReflectorWithAutoDiscoverAdapter
     * @param DocParser $parser
     * @return DocParser
     */
    public function testParseWithReflector($parser)
    {
        $reflector = new \ReflectionMethod(__METHOD__);
        $parser->setReflector($reflector);
        $result = $parser->parse();
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('depends',$result);
        $this->assertEquals($result['depends'][0],'testInitialize');
        $this->assertEquals($result['depends'][1],'testSetReflectorWithAutoDiscoverAdapter');

        return $parser;
    }

    /**
     * @depends testParseWithReflector
     * @param DocParser $parser
     */
    public function testReset($parser)
    {
        $parser->reset();
        $this->assertNull($parser->getReflector());
        $this->assertNull($parser->getAdapter());
    }
}
