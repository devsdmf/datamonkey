<?php

namespace DataMonkey\Tests\Repository;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Repository\Repository;
use DataMonkey\Tests\Mocks\SampleEntity2;
use DataMonkey\Tests\Mocks\SampleFactory2;
use DataMonkey\Tests\Mocks\SampleRepository2;
use Doctrine\DBAL\DriverManager;

class Repository2Test extends \PHPUnit_Framework_TestCase
{

    protected $_connection = null;

    protected $_connection_params = array(
        'driver'=>'pdo_mysql',
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'',
        'dbname'=>'datamonkey_test'
    );

    /**
     * @var ExportableEntity
     */
    protected $_entity = null;

    protected $_entity_data = array(
        'key1'=>1,
        'key2'=>2,
        'column'=>'Test 2'
    );

    /**
     * @var Repository
     */
    protected $_repository = null;

    public function setUp()
    {
        $this->_connection = DriverManager::getConnection($this->_connection_params);
        $this->_entity = SampleEntity2::fromArray($this->_entity_data);
        $this->_repository = new SampleRepository2($this->_connection, new SampleFactory2());
    }

    public function testInitialize()
    {
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleRepository2',$this->_repository);
    }

    /**
     * @depends testInitialize
     * @return ExportableEntity
     */
    public function testInsert()
    {
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity2',$this->_repository->save($this->_entity));

        return $this->_entity;
    }

    /**
     * @depends testInitialize
     * @expectedException \DataMonkey\Repository\Exception\InvalidPrimaryKeyException
     */
    public function testInsertFailEmptyPrimaryKey()
    {
        $entity = new SampleEntity2();
        $this->_repository->save($entity);
    }

    /**
     * @depends testInsert
     */
    public function testFetchAll()
    {
        $this->assertGreaterThan(0,count($this->_repository->fetchAll()));
    }

    /**
     * @depends testInsert
     * @param SampleEntity2 $entity
     */
    public function testFetchBy($entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $criteria     = array();

        foreach ($primary_keys as $primary_key) {
            $criteria[$primary_key['key']] = $export[$primary_key['key']];
        }

        $this->assertGreaterThan(0,count($this->_repository->fetchBy($criteria)));
    }

    /**
     * @depends testInsert
     * @param SampleEntity2 $entity
     */
    public function testFetchOneBy($entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $criteria     = array();

        foreach ($primary_keys as $primary_key) {
            $criteria[$primary_key['key']] = $export[$primary_key['key']];
        }

        $entity = $this->_repository->fetchOneBy($criteria);

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity2',$entity);
    }

    /**
     * @depends testInsert
     * @param SampleEntity2 $entity
     */
    public function testDelete($entity)
    {
        $this->assertTrue($this->_repository->delete($entity));
    }
}