<?php

namespace Devsdmf\Annotations;

/**
 * Interface ReaderInterface
 *
 * @package Devsdmf
 * @subpackage Annotations
 * @namespace Devsdmf\Annotations
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
interface ReaderInterface
{
    /**
     * Get annotations from any object that implements a Reflector interface
     *
     * @param \Reflector $reflector
     * @return Annotation
     */
    public function getAnnotations(\Reflector $reflector);

    /**
     * Get a specific annotation from any object that implements a Reflector interface
     *
     * @param \Reflector $reflector
     * @param string     $name
     * @return string|null
     */
    public function getAnnotation(\Reflector $reflector, $name);

    /**
     * Get annotations from an ReflectionClass instance
     *
     * @param \ReflectionClass $reflector
     * @return Annotation
     */
    public function getClassAnnotations(\ReflectionClass $reflector);

    /**
     * Get a specific annotation from an ReflectionClass instance
     *
     * @param \ReflectionClass $reflector
     * @param string           $name
     * @return string|null
     */
    public function getClassAnnotation(\ReflectionClass $reflector, $name);

    /**
     * Get annotations from an ReflectionFunction instance
     *
     * @param \ReflectionFunction $reflector
     * @return Annotation
     */
    public function getFunctionAnnotations(\ReflectionFunction $reflector);

    /**
     * Get a specific annotation from an ReflectionFunction instance
     *
     * @param \ReflectionFunction $reflector
     * @param string             $name
     * @return string|null
     */
    public function getFunctionAnnotation(\ReflectionFunction $reflector, $name);

    /**
     * Get annotations from an ReflectionMethod instance
     *
     * @param \ReflectionMethod $reflector
     * @return Annotation
     */
    public function getMethodAnnotations(\ReflectionMethod $reflector);

    /**
     * Get a specific annotation from an ReflectionMethod instance
     *
     * @param \ReflectionMethod $reflector
     * @param string            $name
     * @return string|null
     */
    public function getMethodAnnotation(\ReflectionMethod $reflector, $name);

    /**
     * Get annotations from an ReflectionObject instance
     *
     * @param \ReflectionObject $reflector
     * @return Annotation
     */
    public function getObjectAnnotations(\ReflectionObject $reflector);

    /**
     * Get a specific annotation from an ReflectionObject instance
     * @param \ReflectionObject $reflector
     * @param string            $name
     * @return string|null
     */
    public function getObjectAnnotation(\ReflectionObject $reflector, $name);

    /**
     * Get annotations from an ReflectionProperty instance
     *
     * @param \ReflectionProperty $reflector
     * @return Annotation
     */
    public function getPropertyAnnotations(\ReflectionProperty $reflector);

    /**
     * Get a specific annotation from an ReflectionProperty instance
     *
     * @param \ReflectionProperty $reflector
     * @param string              $name
     * @return string|null
     */
    public function getPropertyAnnotation(\ReflectionProperty $reflector, $name);
}
