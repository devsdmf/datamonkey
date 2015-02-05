<?php

namespace Devsdmf\Annotations;

/**
 * Class Annotation
 *
 * Simple class to provide an object implementation of an annotation context
 *
 * @package Devsdmf
 * @subpackage Annotations
 * @namespace Devsdmf\Annotations
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
class Annotation
{
    /**
     * The Constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
