<?php

namespace DataMonkey\Tests\Entity;

use DataMonkey\Entity\ExportAbstract;
use DataMonkey\Tests\Mocks\InvalidEntityWithInvalidStrategy;
use DataMonkey\Tests\Mocks\InvalidEntityWithoutPrimaryKey;
use DataMonkey\Tests\Mocks\SampleEntity;

class ExportableEntityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ExportAbstract
     */
    protected $_entity = null;

    protected $_data = array(
        'id'=>1,
        'column'=>'Test 1',
        'random'=>'Test 2'
    );

    protected $_exported_data = array(
        'idtest_table'=>1,
        'column1'=>'Test 1',
        'column2'=>'Test 2'
    );

    protected $_primary_key = array(array('key'=>'idtest_table','strategy'=>'auto'));

    public function setUp()
    {
        $this->_entity = new SampleEntity();
    }

    public function testGetMapping()
    {
        $keys = array_keys($this->_data);
        $export = $this->_entity->getMapping();

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key,$export);
        }
    }

    public function testGetMappingReverse()
    {
        $keys = array_keys($this->_exported_data);
        $export = $this->_entity->getMapping(true);

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key,$export);
        }
    }

    /**
     * @expectedException \DataMonkey\Entity\Exception\InvalidStrategyException
     */
    public function testGetMappingFailInvalidStrategy()
    {
        $entity = new InvalidEntityWithInvalidStrategy();
        $entity->getMapping();
    }

    public function testGetPrimaryKey()
    {
        $this->assertEquals($this->_primary_key,$this->_entity->getPrimaryKeys());
    }

    /**
     * @expectedException \DataMonkey\Entity\Exception\InvalidEntityException
     */
    public function testGetPrimaryKeyFailWithoutPrimaryKey()
    {
        $entity = new InvalidEntityWithoutPrimaryKey();
        $entity->getPrimaryKeys();
    }

    public function testExchangeArray()
    {
        $entity = $this->_entity->exchangeArray($this->_data);
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
        return $entity;
    }

    public function testExchangeArrayMapping()
    {
        $entity = $this->_entity->exchangeArray($this->_exported_data,true);
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);
        return $entity;
    }

    /**
     * @depends testExchangeArray
     * @param SampleEntity $entity
     */
    public function testToArray($entity)
    {
        $data = $entity->toArray();
        foreach ($data as $key => $value) {
            if (isset($this->_data[$key])) {
                $this->assertEquals($this->_data[$key],$value);
            }
        }
    }

    /**
     * @depends testExchangeArrayMapping
     * @param SampleEntity $entity
     */
    public function testExport($entity)
    {
        $data = $entity->export();
        foreach ($data as $key => $value) {
            $this->assertEquals($this->_exported_data[$key],$value);
        }
    }

    public function testFromArray()
    {
        $entity = SampleEntity::fromArray($this->_data);
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);

        $data = $entity->toArray();
        foreach ($data as $key => $value) {
            if (isset($this->_data[$key])) {
                $this->assertEquals($this->_data[$key],$value);
            }
        }
    }

    public function testFactory()
    {
        $entity = SampleEntity::factory($this->_exported_data);
        $this->assertInstanceOf('\DataMonkey\Tests\Mocks\SampleEntity',$entity);

        $data = $entity->export();
        foreach ($data as $key => $value) {
            $this->assertEquals($this->_exported_data[$key],$value);
        }
    }
}