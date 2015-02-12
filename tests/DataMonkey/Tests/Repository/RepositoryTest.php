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
        'user'=>'root',
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

    /**
     * @depends testInitialize
     * @return ExportableEntity
     */
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
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $this->assertGreaterThan(0,count($this->_repository->fetchBy($criteria)));
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testFetchByOrdering($entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);
        $order        = array($primary_key=>'ASC');

        $this->assertGreaterThan(0,count($this->_repository->fetchBy($criteria,$order)));
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testFetchByWithLimit($entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $this->assertEquals(1,count($this->_repository->fetchBy($criteria,null,1)));
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testFetchUsingEntity($entity)
    {
        $mock_entity = new SampleEntity();
        $mock_entity->column = $entity->column;

        $this->assertGreaterThan(0,count($this->_repository->fetch($mock_entity)));
    }

    /**
     * @depends testInitialize
     * @expectedException \DataMonkey\Repository\Exception\InvalidArgumentException
     */
    public function testFetchByFailWhenCriteriaIsEmpty()
    {
        $this->_repository->fetchBy(array());
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testFetchOneBy($entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $entity = $this->_repository->fetchOneBy($criteria);

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
    }

    /**
     * @depends testInsert
     * @depends testFetchOneBy
     * @param SampleEntity $entity
     */
    public function testUpdate($entity)
    {
        $entity->column = 'Updated value';

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$this->_repository->save($entity));

        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $entity = $this->_repository->fetchOneBy($criteria);

        $this->assertEquals('Updated value',$entity->column);
    }

    /**
     * @depends testInsert
     * @param SampleEntity $entity
     */
    public function testDelete($entity)
    {
        $this->assertTrue($this->_repository->delete($entity));
    }

    /**
     * @depends testInsert
     * @depends testDelete
     * @param SampleEntity $entity
     */
    public function testDeleteFail($entity)
    {
        $this->assertFalse($this->_repository->delete($entity));
    }

    /**
     * @depends testInitialize
     * @depends testInsert
     * @depends testDelete
     */
    public function testFetchByWithLimitOffset()
    {
        $entity        = SampleEntity::fromArray($this->_entity_data);
        $second_entity = SampleEntity::fromArray($this->_entity_data);
        $this->_repository->save($entity);
        $this->_repository->save($second_entity);

        $export       = $second_entity->export();
        $primary_keys = $second_entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $this->assertEquals(1,count($this->_repository->fetchBy($criteria,null,1,0)));
        $this->_repository->delete($entity);
        $this->_repository->delete($second_entity);
    }
}