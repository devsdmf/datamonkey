<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\Factory\AbstractFactory;

class SampleFactory2 extends AbstractFactory
{

    public function create($options = null)
    {
        return SampleEntity2::factory($options);
    }
}