<?php

namespace DataMonkey\Repository;

use DataMonkey\Entity\ExportableEntity;

interface RepositoryInterface
{

    public function fetchAll();

    public function fetchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function fetchOneBy(array $criteria);

    public function save(ExportableEntity &$entity);

    public function delete(ExportableEntity &$entity);
}