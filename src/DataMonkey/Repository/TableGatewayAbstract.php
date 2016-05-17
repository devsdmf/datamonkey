<?php

namespace DataMonkey\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;

/**
 * Class TableGatewayAbstract
 *
 * A class that provides support for database interaction inside an repository object
 *
 * @package DataMonkey\Repository
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
abstract class TableGatewayAbstract
{
    /**
     * Doctrine DBAL Connection instance
     * @var Connection
     */
    protected $_connection = null;

    /**
     * The table name
     * @var string
     */
    protected $_name = null;

    /**
     * The Constructor
     *
     * @param  Connection          $connection
     * @throws ConnectionException
     */
    public function __construct(Connection $connection)
    {
        $this->_connection =& $connection;

        if (is_null($this->_name)) {
            throw new ConnectionException(sprintf('You must set the table name to instantiate a TableGateway object'));
        }
    }
}
