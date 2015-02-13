<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class InvalidEntityWithoutPrimaryKey extends ExportAbstract implements ExportableEntity
{

    /**
     * @db_ref column
     */
    public $column = null;
}