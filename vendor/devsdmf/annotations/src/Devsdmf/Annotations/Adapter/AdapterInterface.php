<?php

namespace Devsdmf\Annotations\Adapter;

/**
 * Interface AdapterInterface
 *
 * @package Devsdmf\Annotations
 * @subpackage Adapter
 * @namespace Devsdmf\Annotations\Adapter
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
interface AdapterInterface
{
    /**
     * Get the DocBlock of the given reflector
     *
     * @param $reflector
     * @return string
     */
    public function getDocBlock($reflector);
}
