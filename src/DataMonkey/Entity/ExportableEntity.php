<?php

namespace DataMonkey\Entity;

interface ExportableEntity
{
    public function getMapping($reverse = false, $reload = false);

    public function getPrimaryKey();

    public function exchangeArray(array $data, $mapping = false);

    public function toArray();

    public function export();

    public static function fromArray(array $data);

    public static function factory(array $data);
}