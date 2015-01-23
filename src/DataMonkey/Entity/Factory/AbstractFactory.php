<?php

namespace DataMonkey\Entity\Factory;

/**
 * Class AbstractFactory
 *
 * @package DataMonkey\Entity\Factory
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
abstract class AbstractFactory
{
    /**
     * Create an component object
     *
     * @param  mixed $options
     * @return mixed
     */
    abstract public function create($options = null);
}
