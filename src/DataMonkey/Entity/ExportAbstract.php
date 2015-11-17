<?php

namespace DataMonkey\Entity;

use DataMonkey\Entity\Exception\InvalidEntityException;
use DataMonkey\Entity\Exception\InvalidStrategyException;
use Devsdmf\Annotations\Reader as AnnotationReader;

/**
 * Class ExportAbstract
 *
 * @package DataMonkey\Entity
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
abstract class ExportAbstract implements ExportableEntity
{
    /**
     * Mapping array with properties and database reference fields
     * @var array
     */
    private $_mapping = null;

    /**
     * The primary keys of table defined by `pk` annotation
     * @var array
     */
    private $_primary_keys = null;

    /**
     * {@inheritdoc}
     */
    public function getMapping($reverse = false, $reload = false)
    {
        if (is_null($this->_mapping) || $reload) {
            $this->_mapping = array();
            $this->_primary_keys = array();
            $reflector = new \ReflectionClass($this);
            $reader = new AnnotationReader();

            foreach ($reflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $annotations = $reader->getPropertyAnnotations($property);

                if (isset($annotations->db_ref)) {
                    $db_ref = $annotations->db_ref;
                    $this->_mapping[$property->getName()] = (string) $db_ref;

                    if (isset($annotations->pk)) {
                        $key      = (string) $db_ref;
                        $strategy = (isset($annotations->strategy)) ? (string) $annotations->strategy : 'auto';

                        if ($strategy != 'auto' && $strategy != 'manual')
                            throw new InvalidStrategyException(sprintf('The primary key strategy must be auto or manual'));

                        $this->_primary_keys[] = array('key'=>$key,'strategy'=>$strategy);
                    }
                }
            }
        }

        return ($reverse) ? array_flip($this->_mapping) : $this->_mapping;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrimaryKeys()
    {
        if (is_null($this->_primary_keys)) {
            $this->getMapping();
        }

        if (count($this->_primary_keys) == 0) {
            throw new InvalidEntityException(sprintf('An entity must have an primary key'));
        } else {
            return $this->_primary_keys;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function exchangeArray(array $data, $mapping = false)
    {
        $reflector = new \ReflectionClass($this);
        $properties = $reflector->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $property) {
            unset($data[$property->getName()]);
        }

        if ($mapping) {
            // Importing array using the reverse object mapper
            $mapping = $this->getMapping(true);
            foreach ($data as $key => $value) {
                if (isset($mapping[$key])) {
                    $this->$mapping[$key] = $value;
                }
            }
        } else {
            // Using the object properties
            foreach ($data as $property => $value) {
                if (property_exists($this, $property)) {
                    $this->$property = $value;
                }
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $this->getMapping();
        $reflector = new \ReflectionClass($this);
        $data = array();

        foreach ($reflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        $export = array();
        $mapping = $this->getMapping();
        $data = $this->toArray();

        foreach ($data as $property => $value) {
            if (array_key_exists($property,$mapping)) {
                $export[$mapping[$property]] = $value;
            }
        }

        return $export;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromArray(array $data)
    {
        $class = get_called_class();
        $instance = new $class();

        return $instance->exchangeArray($data);
    }

    /**
     * {@inheritdoc}
     */
    public static function factory(array $data)
    {
        $class = get_called_class();
        $instance = new $class();

        return $instance->exchangeArray($data, true);
    }
}
