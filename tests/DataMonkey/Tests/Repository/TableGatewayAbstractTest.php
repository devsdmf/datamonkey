<?php

namespace DataMonkey\Tests\Repository;

use DataMonkey\Tests\Mocks\InvalidRepository;
use DataMonkey\Tests\Mocks\SampleFactory;
use DataMonkey\Tests\Mocks\SampleRepository;

class TableGatewayAbstractTest extends PersistenceTestCase
{

    public function testInitialize()
    {
        $repository = new SampleRepository($this->_connection, new SampleFactory());
        $this->assertInstanceOf('DataMonkey\Repository\TableGatewayAbstract',$repository);
    }

    /**
     * @expectedException \Doctrine\DBAL\ConnectionException
     */
    public function testInitializeFailWithoutTableName()
    {
        $repository = new InvalidRepository($this->_connection);
    }
}