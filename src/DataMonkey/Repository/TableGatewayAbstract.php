<?php

namespace DataMonkey\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;

abstract class TableGatewayAbstract
{

    protected $_connection = null;

    protected $_name = null;

    public function __construct(Connection &$connection)
    {
        $this->_connection =& $connection;

        if (is_null($this->_name)) {
            throw new ConnectionException(sprintf('You must set the table name to instantiate a TableGateway object'));
        }
    }
}