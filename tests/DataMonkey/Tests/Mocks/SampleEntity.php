<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class SampleEntity extends ExportAbstract implements ExportableEntity
{

    /**
     * @pk
     * @db_ref idtest_table
     * @strategy auto
     */
    public $id = null;

    /**
     * @db_ref column1
     */
    public $column = null;

    /**
     * @db_ref column2
     */
    public $random = 0;

    /**
     * @var void
     */
    public $notIndexedColumn;
}