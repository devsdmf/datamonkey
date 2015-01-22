<?php

namespace DataMonkey\Tests\Repository;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Repository\Repository;
use DataMonkey\Tests\Mocks\SampleEntity;
use DataMonkey\Tests\Mocks\SampleFactory;
use DataMonkey\Tests\Mocks\SampleRepository;
use Doctrine\DBAL\DriverManager;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{

    protected $_connection = null;

    protected $_connection_params = array(
        'driver'=>'pdo_mysql',
        'host'=>'localhost',
        'user'=>'datamonkey',
        'password'=>'',
        'dbname'=>'datamonkey_test'
    );

    /**
     * @var ExportableEntity
     */
    protected $_entity = null;

    protected $_entity_data = array(
        'id'=>null,
        'column'=>'Test 1',
        'random'=>'Test 2'
    );

    /**
     * @var Repository
     */
    protected $_repository = null;

    public function setUp()
    {
        $this->_connection = DriverManager::getConnection($this->_connection_params);
        $this->_entity = SampleEntity::fromArray($this->_entity_data);
        $this->_repository = new SampleRepository($this->_connection, new SampleFactory());
    }

    public function testInitialize()
    {
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleRepository',$this->_repository);
    }

    public function testInsert()
    {
        $this->_repository->save($this->_entity);
        $this->assertNotNull($this->_entity->id);

        return $this->_entity;
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
     * @param SampleEntity $entity
     */
    public function testFetchBy($entity)
    {
        $export = $entity->export();
        $primary_key = $entity->getPrimaryKey();
        $criteria = array($primary_key=>$export[$primary_key]);
        $this->assertGreaterThan(0,count($this->_repository->fetchBy($criteria)));
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testFetchOneBy($entity)
    {
        $export = $entity->export();
        $primary_key = $entity->getPrimaryKey();
        $criteria = array($primary_key=>$export[$primary_key]);

        $entity = $this->_repository->fetchOneBy($criteria);

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testDelete($entity)
    {
        $this->assertTrue($this->_repository->delete($entity));
    }
}