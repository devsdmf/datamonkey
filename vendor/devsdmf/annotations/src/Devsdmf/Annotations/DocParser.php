<?php

namespace Devsdmf\Annotations;

use Devsdmf\Annotations\Adapter\AdapterInterface;
use Devsdmf\Annotations\Exception\AdapterNotFoundException;

/**
 * Class DocParser
 *
 * The parser for DocBlock annotations
 *
 * @package Devsdmf
 * @subpackage Annotations
 * @namespace Devsdmf\Annotations
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
class DocParser implements ParserInterface
{

    /**
     * The instance of the current reflector
     *
     * @var \Reflector
     */
    private $reflector = null;

    /**
     * The instance of the current adapter
     *
     * @var \Devsdmf\Annotations\Adapter\AdapterInterface
     */
    private $adapter = null;

    /**
     * The Constructor
     */
    public function __construct(){}

    /**
     * {@inheritdoc}
     */
    public function setReflector(\Reflector $reflector, $adapterDiscover = true)
    {
        if ($adapterDiscover) {
            $adapter = __NAMESPACE__ . '\\Adapter\\' . get_class($reflector) . 'Adapter';
            if (class_exists($adapter)) {
                $this->setAdapter(new $adapter());
            } else {
                throw new AdapterNotFoundException(sprintf('Adapter for "$s" objects was not found.',get_class($reflector)));
            }
        }

        $this->reflector = $reflector;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReflector()
    {
        return $this->reflector;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($input = null, $delimiter = ' ')
    {
        if (is_null($input) && !is_null($this->reflector) && !is_null($this->adapter)) {
            $input = $this->adapter->getDocBlock($this->reflector);
        }

        $data = array();

        preg_match_all('#@(.*?)\n#s', $input, $matches);

        $matches = $matches[0];
        foreach ($matches as $annotation) {
            $annotation = trim($annotation);
            $annotation = explode($delimiter,$annotation);

            $key = str_replace('@','',$annotation[0]);
            unset($annotation[0]);
            $value = implode($delimiter,$annotation);

            if (isset($data[$key])) {
                if (is_array($data[$key])) {
                    $data[$key][] = $value;
                } else {
                    $old_value = $data[$key];
                    $data[$key] = array($old_value,$value);
                }
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Reset the DocParser state
     *
     * @return DocParser
     */
    public function reset()
    {
        $this->reflector = null;
        $this->adapter   = null;

        return $this;
    }
}
