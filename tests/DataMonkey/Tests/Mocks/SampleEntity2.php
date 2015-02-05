<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class SampleEntity2 extends ExportAbstract implements ExportableEntity
{

    /**
     * @pk
     * @db_ref key1
     * @strategy manual
     */
    public $key1 = null;

    /**
     * @pk
     * @db_ref key2
     * @strategy manual
     */
    public $key2 = null;

    /**
     * @db_ref column
     */
    public $column = null;
}