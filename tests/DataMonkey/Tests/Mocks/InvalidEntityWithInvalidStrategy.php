<?php

namespace DataMonkey\Tests\Mocks;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class InvalidEntityWithInvalidStrategy extends ExportAbstract implements ExportableEntity
{

    /**
     * @pk
     * @strategy random
     * @db_ref my_pk
     */
    public $pk = null;
}