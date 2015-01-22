<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\Factory\AbstractFactory;

class SampleFactory extends AbstractFactory
{

    public function create($options = null)
    {
        return SampleEntity::factory($options);
    }
}