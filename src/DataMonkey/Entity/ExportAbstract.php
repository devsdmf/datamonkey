<?php

namespace DataMonkey\Entity;

use Devsdmf\Annotations\Reader as AnnotationReader;

abstract class ExportAbstract implements ExportableEntity
{

    private $_mapping = null;

    private $_primary_key = null;

    public function getMapping($reverse = false, $reload = false)
    {
        if (is_null($this->_mapping) || $reload) {
            $this->_mapping = array();
            $reflector      = new \ReflectionClass($this);
            $reader         = new AnnotationReader();

            foreach ($reflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $annotations = $reader->getPropertyAnnotations($property);

                $db_ref = (!is_null($annotations->db_ref)) ? $annotations->db_ref : $property->getName();
                $this->_mapping[$property->getName()] = (string)$db_ref;

                if (isset($annotations->pk))
                    $this->_primary_key = (string)$db_ref;
            }
        }

        return ($reverse) ? array_flip($this->_mapping) : $this->_mapping;
    }

    public function getPrimaryKey()
    {
        if (is_null($this->_primary_key)) {
            $this->getMapping();
        }

        return $this->_primary_key;
    }

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
                if (property_exists($this,$property)) {
                    $this->$property = $value;
                }
            }
        }

        return $this;
    }

    public function toArray()
    {
        $reflector = new \ReflectionClass($this);
        $data      = array();

        foreach ($reflector->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }

    public function export()
    {
        $export = array();
        $mapping = $this->getMapping();
        $data = $this->toArray();

        foreach ($data as $property => $value) {
            $export[$mapping[$property]] = $value;
        }

        return $export;
    }

    public static function fromArray(array $data)
    {
        $class = get_called_class();
        $instance = new $class();
        return $instance->exchangeArray($data);
    }

    public static function factory(array $data)
    {
        $class = get_called_class();
        $instance = new $class();
        return $instance->exchangeArray($data,true);
    }
}