<?php

namespace DataMonkey\Repository;

use DataMonkey\Entity\ExportableEntity;

/**
 * Interface RepositoryInterface
 *
 * @package DataMonkey\Repository
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
interface RepositoryInterface
{
    /**
     * Fetch all records from database
     *
     * @return \DataMonkey\Repository\ResultStack
     */
    public function fetchAll();

    /**
     * Fetch objects by a set of criteria
     *
     * @param  array                              $criteria
     * @param  array                              $orderBy
     * @param  integer                            $limit
     * @param  integer                            $offset
     * @return \DataMonkey\Repository\ResultStack
     */
    public function fetchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Fetch a single object by a set of criteria
     *
     * @param  array            $criteria
     * @return ExportableEntity
     */
    public function fetchOneBy(array $criteria);

    /**
     * Persist an object in database
     *
     * @param  ExportableEntity $entity
     * @return ExportableEntity
     */
    public function save(ExportableEntity &$entity);

    /**
     * Delete an object from database (if exists)
     *
     * @param  ExportableEntity $entity
     * @return boolean
     */
    public function delete(ExportableEntity &$entity);
}
