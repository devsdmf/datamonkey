<?php

namespace Devsdmf\Annotations;

/**
 * Class Reader
 *
 * Read annotations from Reflector implementations
 *
 * @package Devsdmf
 * @subpackage Annotations
 * @namespace Devsdmf\Annotations
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
class Reader implements ReaderInterface
{

    /**
     * @var ParserInterface
     */
    private $parser = null;

    public function __construct(ParserInterface $parser = null)
    {
        if (!is_null($parser)) {
            $this->parser = $parser;
        } else {
            $this->parser = new DocParser();
        }
    }

    public function getAnnotations(\Reflector $reflector)
    {
        $this->parser->setReflector($reflector);

        $annotations = $this->parser->parse();

        $annotation = new Annotation($annotations);

        return $annotation;
    }

    public function getAnnotation(\Reflector $reflector, $name)
    {
        $annotation = $this->getAnnotations($reflector);

        if (isset($annotation->$name)) {
            return $annotation->$name;
        } else {
            return null;
        }
    }

    public function getClassAnnotations(\ReflectionClass $reflector)
    {
        return $this->getAnnotations($reflector);
    }

    public function getClassAnnotation(\ReflectionClass $reflector, $name)
    {
        return $this->getAnnotation($reflector,$name);
    }

    public function getFunctionAnnotations(\ReflectionFunction $reflector)
    {
        return $this->getAnnotations($reflector);
    }

    public function getFunctionAnnotation(\ReflectionFunction $reflector, $name)
    {
        return $this->getAnnotation($reflector,$name);
    }

    public function getMethodAnnotations(\ReflectionMethod $reflector)
    {
        return $this->getAnnotations($reflector);
    }

    public function getMethodAnnotation(\ReflectionMethod $reflector, $name)
    {
        return $this->getAnnotation($reflector,$name);
    }

    public function getObjectAnnotations(\ReflectionObject $reflector)
    {
        return $this->getAnnotations($reflector);
    }

    public function getObjectAnnotation(\ReflectionObject $reflector, $name)
    {
        return $this->getAnnotation($reflector,$name);
    }

    public function getPropertyAnnotations(\ReflectionProperty $reflector)
    {
        return $this->getAnnotations($reflector);
    }

    public function getPropertyAnnotation(\ReflectionProperty $reflector, $name)
    {
        return $this->getAnnotation($reflector,$name);
    }
}
