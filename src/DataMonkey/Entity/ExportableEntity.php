<?php

namespace DataMonkey\Entity;

/**
 * Interface ExportableEntity
 *
 * @package DataMonkey\Entity
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
interface ExportableEntity
{
    /**
     * Get entity mapping between object properties and database fields
     *
     * @param  bool  $reverse
     * @param  bool  $reload
     * @return array
     */
    public function getMapping($reverse = false, $reload = false);

    /**
     * Get the primary key field
     *
     * @return array
     */
    public function getPrimaryKeys();

    /**
     * Persist an array inside the entity
     *
     * @param  array            $data
     * @param  bool             $mapping
     * @return ExportableEntity
     */
    public function exchangeArray(array $data, $mapping = false);

    /**
     * Get an array representation of the entity
     *
     * @return array
     */
    public function toArray();

    /**
     * Get an array representation of the entity where the array keys are the database fields
     * specified on the entity property annotation
     *
     * @return array
     */
    public function export();

    /**
     * Build a entity instance persisting an array
     *
     * @param  array            $data
     * @return ExportableEntity
     */
    public static function fromArray(array $data);

    /**
     * Build a entity instance persisting an database parsed array
     *
     * @param  array            $data
     * @return ExportableEntity
     */
    public static function factory(array $data);
}
