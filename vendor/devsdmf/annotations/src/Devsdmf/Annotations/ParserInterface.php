<?php

namespace Devsdmf\Annotations;

use Devsdmf\Annotations\Adapter\AdapterInterface;

/**
 * Interface ParserInterface
 *
 * @package Devsdmf
 * @subpackage Annotations
 * @namespace Devsdmf\Annotations
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
interface ParserInterface
{
    /**
     * Set the reflector
     *
     * @param \Reflector $reflector
     * @param bool       $adapterDiscover
     * @return DocParser
     */
    public function setReflector(\Reflector $reflector, $adapterDiscover = true);

    /**
     * Get the current reflector
     *
     * @return \Reflector
     */
    public function getReflector();

    /**
     * Set an adapter
     *
     * @param AdapterInterface $adapter
     * @return DocParser
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * Get the current adapter
     *
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * Parse the DocBlock
     *
     * @param string $input
     * @param string $delimiter
     * @return array
     */
    public function parse($input = null, $delimiter = ' ');
}
