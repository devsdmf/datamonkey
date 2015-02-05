<?php

namespace Devsdmf\Tests\Annotations;

use Devsdmf\Annotations\Annotation;

class AnnotationTest extends \PHPUnit_Framework_TestCase
{

    public function setUp(){}

    public function testInitialize()
    {
        $annotation = new Annotation(array());
        $this->assertInstanceOf('\Devsdmf\Annotations\Annotation',$annotation);

        return $annotation;
    }

    /**
     * @depends testInitialize
     * @param Annotation $annotation
     */
    public function testSetGetAnnotation($annotation)
    {
        $annotation->name = 'value';
        $this->assertEquals('value',$annotation->name);
    }
}
