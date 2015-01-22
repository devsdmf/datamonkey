<?php

namespace DataMonkey\Entity\Factory;

abstract class AbstractFactory
{

    abstract public function create($options = null);
}