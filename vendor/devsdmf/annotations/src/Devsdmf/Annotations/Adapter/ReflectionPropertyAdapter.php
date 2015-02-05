<?php

namespace Devsdmf\Annotations\Adapter;

use Devsdmf\Annotations\Exception\InvalidReflectorException;

/**
 * Class ReflectionPropertyAdapter
 *
 * The adapter for ReflectionProperty instances
 *
 * @package Devsdmf\Annotations
 * @subpackage Adapter
 * @namespace Devsdmf\Annotations\Adapter
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
class ReflectionPropertyAdapter implements AdapterInterface
{
    /**
     * The Constructor
     */
    public function __construct(){}

    /**
     * {@inheritdoc}
     */
    public function getDocBlock($reflector)
    {
        if (!$reflector instanceof \ReflectionProperty) {
            throw new InvalidReflectorException(sprintf('Invalid reflector to $s, expected $s instance, $s given.',
                get_class($this),'ReflectionProperty',get_class($reflector)));
        }

        return $reflector->getDocComment();
    }
}
