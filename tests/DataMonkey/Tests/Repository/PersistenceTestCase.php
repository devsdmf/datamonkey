<?php

namespace DataMonkey\Tests\Repository;

use Doctrine\DBAL\DriverManager;

class PersistenceTestCase extends \PHPUnit_Framework_TestCase
{

    protected $_connection = null;

    protected function getDatabaseConnection()
    {
        return DriverManager::getConnection(array('driver'=>DATABASE_DRIVER,
                                                  'host'=>DATABASE_HOST,
                                                  'user'=>DATABASE_USER,
                                                  'password'=>DATABASE_PASS,
                                                  'dbname'=>DATABASE_NAME));
    }

    public function setUp()
    {
        $this->_connection = $this->getDatabaseConnection();
    }
}