<?php

namespace DataMonkey\Repository;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\Factory\AbstractFactory;
use DataMonkey\Repository\Exception\InvalidArgumentException;
use DataMonkey\Repository\Exception\InvalidPrimaryKeyException;
use DataMonkey\Repository\Exception\TransactionException;
use Doctrine\DBAL\Connection;

/**
 * Class Repository
 *
 * Provides an data abstraction layer for easy database interaction
 *
 * @package DataMonkey\Repository
 * @author Lucas Mendes de Freitas <devsdmf@gmail.com>
 * @copyright Copyright 2010-2015 (c) devSDMF Software Development Inc.
 */
class Repository extends TableGatewayAbstract implements RepositoryInterface
{
    /**
     * @var AbstractFactory
     */
    private $_factory = null;

    /**
     * The Constructor
     *
     * @param  Connection                         $connection
     * @param  AbstractFactory                    $factory
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function __construct(Connection &$connection, AbstractFactory $factory)
    {
        parent::__construct($connection);
        $this->_factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll()
    {
        $query = 'SELECT * FROM `' . $this->_name . '`';
        $result = $this->_connection->fetchAll($query);

        $stack = new ResultStack();

        foreach ($result as $row) {
            $stack->attach($this->_factory->create($row));
        }

        return $stack;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        if (count($criteria) == 0 || is_null($criteria)) {
            throw new InvalidArgumentException(sprintf('You must set an criteria when using fetchBy method'));
        }

        $fields = array();
        $data = array();

        // Preparing fields and data
        foreach ($criteria as $field => $value) {
            $fields[] = '`' . $field . '`=?';
            $data[] = $value;
        }
        $field_string = implode(' AND ', $fields);

        // Preparing order statement
        if (!is_null($orderBy) && count($orderBy) > 0) {
            $order = array();
            foreach ($orderBy as $field => $sort) {
                $order[] = $field . ' ' . $sort;
            }
            $order_string = ' ORDER BY ' . implode(', ', $order);
        }

        // Preparing limit statement
        if (!is_null($limit)) {
            $limit_string = ' LIMIT ';
            if (is_null($offset)) {
                $limit_string .= $limit;
            } else {
                $limit_string .= $offset . ',' . $limit;
            }
        }

        $query = 'SELECT * FROM `' . $this->_name . '` WHERE ' . $field_string . ((isset($order_string)) ? $order_string : '') . ((isset($limit_string)) ? $limit_string : '');

        $result = $this->_connection->fetchAll($query, $data);
        $stack = new ResultStack();

        foreach ($result as $key => $row) {
            $stack->attach($this->_factory->create($row), $key);
        }

        return $stack;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOneBy(array $criteria)
    {
        $result = $this->fetchBy($criteria, null, 1);
        $result->rewind();

        if ($result->count() == 1) {
            return $result->current();
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(ExportableEntity &$entity)
    {
        $primary_keys = $entity->getPrimaryKeys();
        $export       = $entity->export();
        $type         = 'insert';
        $check        = false;

        foreach ($primary_keys as $primary_key) {
            if ($primary_key['strategy'] == 'manual') {
                if (is_null($export[$primary_key['key']])) {
                    throw new InvalidPrimaryKeyException(sprintf('The primary key %s are using manual strategy, you must set an value to proceed.',$primary_key['key']));
                } else {
                    $check = true;
                }
            } elseif ($primary_key['strategy'] == 'auto' && $check == false && $type == 'insert') {
                if (is_null($export[$primary_key['key']])) {
                    $type = 'insert';
                } else {
                    $type = 'update';
                }
            }
        }

        if ($check) {
            reset($primary_keys);
            $criteria = array();

            foreach ($primary_keys as $primary_key) {
                if (!is_null($export[$primary_key['key']])) {
                    $criteria[$primary_key['key']] = $export[$primary_key['key']];
                }
            }

            $result = $this->fetchOneBy($criteria);
            $type = (is_null($result)) ? 'insert' : 'update';
        }

        if ($type == 'insert') {
            # INSERT
            $fields = array();
            $data = array();

            foreach ($export as $field => $value) {
                $fields[] = '`' . $field . '`';
                $data[] = $value;
            }

            $field_string = implode(',', $fields);
            $data_string = str_repeat('?,', count($data));
            $data_string = substr($data_string, 0, strlen($data_string) - 1);

            $query = 'INSERT INTO `' . $this->_name . '` (' . $field_string . ') VALUES (' . $data_string . ')';

            $result = $this->_connection->executeUpdate($query, $data);

            if ($result == 1) {
                if (count($primary_keys) == 1) {
                    $id_entity = $this->_connection->lastInsertId();
                    $entity->exchangeArray(array($primary_keys[0]['key'] => $id_entity), true);
                }

                return $entity;
            } else {
                throw new TransactionException(sprintf('An error occurred at try to insert data in %s table', $this->_name));
            }
        } else {
            # UPDATE
            $fields = array();
            $data = array();

            foreach ($export as $field => $value) {
                $fields[] = '`' . $field . '`=?';
                $data[] = $value;
            }
            $field_string = implode(',', $fields);

            reset($primary_keys);
            foreach ($primary_keys as $primary_key) {
                $where[] = '`' . $primary_key['key'] . '`=?';
                $data[] = $export[$primary_key['key']];
            }
            $where_string = implode(' AND ',$where);

            $query = 'UPDATE `' . $this->_name . '` SET ' . $field_string . ' WHERE ' . $where_string;

            $result = $this->_connection->executeUpdate($query, $data);
            if ($result == 1) {
                return $entity;
            } elseif ($result == 0) {
                throw new TransactionException(sprintf('No affected row'));
            } else {
                throw new TransactionException(sprintf('An error occurred at update %s table', $this->_name));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ExportableEntity &$entity)
    {
        $primary_keys = $entity->getPrimaryKeys();
        $export       = $entity->export();
        $data         = array();

        foreach ($primary_keys as $primary_key) {
            $where[] = '`' . $primary_key['key'] . '`=?';
            $data[] = $export[$primary_key['key']];
        }
        $where_string = implode(' AND ',$where);

        $query = 'DELETE FROM `' . $this->_name . '` WHERE ' . $where_string;

        $result = $this->_connection->executeUpdate($query,$data);

        if ($result == 1) {
            return true;
        } else {
            return false;
        }
    }
}