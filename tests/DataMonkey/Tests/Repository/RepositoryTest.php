<?php

namespace DataMonkey\Tests\Repository;

use DataMonkey\Tests\Mocks\SampleEntity;
use DataMonkey\Tests\Mocks\SampleEntity2;
use DataMonkey\Tests\Mocks\SampleFactory;
use DataMonkey\Tests\Mocks\SampleFactory2;
use DataMonkey\Tests\Mocks\SampleRepository;
use DataMonkey\Tests\Mocks\SampleRepository2;

class RepositoryTest extends PersistenceTestCase
{

    public function testInitializeRepositoryWithAutoStrategy()
    {
        $repository = new SampleRepository($this->_connection, new SampleFactory());
        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleRepository',$repository);

        return $repository;
    }

    public function testInitializeRepositoryWithManualStrategy()
    {
        $repository = new SampleRepository2($this->_connection, new SampleFactory2());
        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleRepository2',$repository);

        return $repository;
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @param SampleRepository $repository
     * @return SampleEntity
     */
    public function testInsertFirstEntityWithAutoStrategy($repository)
    {
        $entity = SampleEntity::fromArray(array('column'=>'Test','random'=>1));
        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleEntity',$repository->save($entity));

        return $entity;
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @param SampleRepository $repository
     * @return SampleEntity
     */
    public function testInsertSecondEntityWithAutoStrategy($repository)
    {
        $entity = SampleEntity::fromArray(array('column'=>'Test 2','random'=>2));
        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleEntity',$repository->save($entity));

        return $entity;
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @param SampleRepository $repository
     */
    public function testFetchAll($repository)
    {
        $this->assertGreaterThan(0,count($repository->fetchAll()));
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @param SampleRepository $repository
     * @param SampleEntity $entity
     */
    public function testFetchBy($repository, $entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $this->assertGreaterThan(0,count($repository->fetchBy($criteria)));
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @param SampleRepository $repository
     * @expectedException \DataMonkey\Repository\Exception\InvalidArgumentException
     */
    public function testFetchByFailEmptyCriteria($repository)
    {
        $repository->fetchBy(array());
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @depends testInsertSecondEntityWithAutoStrategy
     * @param SampleRepository $repository
     * @param SampleEntity $entity
     */
    public function testFetchOrderBy($repository, $entity)
    {
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $order        = array($primary_key=>'DESC');

        $result = $repository->fetch(null,$order);
        $result->rewind();

        $this->assertGreaterThan(0,count($result));
        $this->assertEquals(2,$result->current()->random);
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertSecondEntityWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @param SampleRepository $repository
     */
    public function testFetchWithLimit($repository)
    {
        $this->assertEquals(1,count($repository->fetch(null,null,1)));
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertSecondEntityWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @param SampleRepository $repository
     */
    public function testFetchWithLimitOffset($repository)
    {
        $result = $repository->fetch(null,null,1,1);
        $result->rewind();

        $this->assertGreaterThan(0,count($result));
        $this->assertEquals(2,$result->current()->random);
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @param SampleRepository $repository
     * @expectedException \DataMonkey\Repository\Exception\InvalidArgumentException
     */
    public function testFetchFailInvalidCriteria($repository)
    {
        $repository->fetch(new \stdClass());
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @param SampleRepository $repository
     * @param SampleEntity $entity
     */
    public function testFetchOneByCriteriaArray($repository, $entity)
    {
        $export       = $entity->export();
        $primary_keys = $entity->getPrimaryKeys();
        $primary_key  = $primary_keys[0]['key'];
        $value        = $export[$primary_key];
        $criteria     = array($primary_key=>$value);

        $entity = $repository->fetchOneBy($criteria);

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @param SampleRepository $repository
     * @param SampleEntity $entity
     */
    public function testFetchOneByEntityInstance($repository, $entity)
    {
        $entity = SampleEntity::fromArray(array('id'=>$entity->id));

        $entity = $repository->fetchOneBy($entity);

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @depends testFetchOneByEntityInstance
     * @param SampleRepository $repository
     * @param SampleEntity $entity
     */
    public function testUpdateEntityWithAutoStrategy($repository, $entity)
    {
        $entity->column = 'Updated';

        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$repository->save($entity));

        $entity = $repository->fetchOneBy($entity);

        $this->assertEquals('Updated',$entity->column);
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @depends testInsertSecondEntityWithAutoStrategy
     * @param SampleRepository $repository
     * @param SampleEntity $entity_1
     * @param SampleEntity $entity_2
     */
    public function testDeleteEntitiesWithAutoStrategy($repository, $entity_1, $entity_2)
    {
        $this->assertTrue($repository->delete($entity_1));
        $this->assertTrue($repository->delete($entity_2));
    }

    /**
     * @depends testInitializeRepositoryWithAutoStrategy
     * @depends testInsertFirstEntityWithAutoStrategy
     * @depends testDeleteEntitiesWithAutoStrategy
     * @param SampleRepository $repository
     * @params SampleEntity $entity
     */
    public function testDeleteEntityWithAutoStrategyFail($repository, $entity)
    {
        $this->assertFalse($repository->delete($entity));
    }

    /**
     * @depends testInitializeRepositoryWithManualStrategy
     * @param SampleRepository2 $repository
     * @return SampleEntity2
     */
    public function testInsertEntityWithManualStrategy($repository)
    {
        $entity = SampleEntity2::fromArray(array('key1'=>1,'key2'=>2,'column'=>'Test'));
        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleEntity2',$repository->save($entity));

        return $entity;
    }

    /**
     * @depends testInitializeRepositoryWithManualStrategy
     * @param SampleRepository $repository
     * @expectedException \DataMonkey\Repository\Exception\InvalidPrimaryKeyException
     */
    public function testInsertEntityWithManualStrategyFailEmptyPrimaryKey($repository)
    {
        $entity = new SampleEntity2();
        $repository->save($entity);
    }

    /**
     * @depends testInitializeRepositoryWithManualStrategy
     * @depends testInsertEntityWithManualStrategy
     * @depends testFetchOneByEntityInstance
     * @param SampleRepository2 $repository
     * @param SampleEntity2 $entity
     */
    public function testUpdateEntityWithManualStrategy($repository, $entity)
    {
        $entity->column = 'Updated';

        $this->assertInstanceOf('DataMonkey\Tests\Mocks\SampleEntity2',$repository->save($entity));

        $entity = $repository->fetchOneBy($entity);

        $this->assertEquals('Updated',$entity->column);
    }

    /**
     * @depends testInitializeRepositoryWithManualStrategy
     * @depends testInsertEntityWithManualStrategy
     * @param SampleRepository2 $repository
     * @param SampleEntity2 $entity
     */
    public function testDeleteEntityWithManualStrategy($repository, $entity)
    {
        $this->assertTrue($repository->delete($entity));
    }
}