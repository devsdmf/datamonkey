# ![logo](https://i.imgur.com/TYpSNO7.png) DataMonkey

[![Build Status](https://travis-ci.org/devsdmf/datamonkey.svg?branch=master)](https://travis-ci.org/devsdmf/datamonkey)
[![Latest Stable Version](https://poser.pugx.org/devsdmf/datamonkey/v/stable.svg)](https://packagist.org/packages/devsdmf/datamonkey)
[![Total Downloads](https://poser.pugx.org/devsdmf/datamonkey/downloads.svg)](https://packagist.org/packages/devsdmf/datamonkey)
[![License](https://poser.pugx.org/devsdmf/datamonkey/license.svg)](https://packagist.org/packages/devsdmf/datamonkey)

A simple database ORM for PHP projects build on top of Doctrine.

Installation
------------

```json
{
    "require": {
        "devsdmf/datamonkey":"~1.0"
    }
}
```

Usage
-----

Creating an entity:

```php
namespace Vendor\Package;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class MyEntity extends ExportAbstract implements ExportableEntity
{
    /**
     * @pk
     * @db_ref id_entity
     * @strategy auto
     */
    public $id = null;
    
    /**
     * @db_ref foo_column
     */
    public $foo = null;
}
```

Creating a factory:

```php
namespace Vendor\Package;

use DataMonkey\Entity\Factory\AbstractFactory;
use Vendor\Package\MyEntity;

class MyFactory extends AbstractFactory
{
    
    public function create($options = null)
    {
        return MyEntity::factory($options);
    }
}
```

Creating an repository

```php
namespace Vendor\Package;

use DataMonkey\Repository\Repository;

class MyRepository extends Repository
{

    protected $_name = 'mytable';
}
```

Persisting an entity:

```php
use Vendor\Package\MyEntity;
use Vendor\Package\MyFactory;
use Vendor\Package\MyRepository;

// Configure your doctrine DBAL connection
$connection = new \Doctrine\DBAL\Connection(...);

$entity = new MyEntity();
$entity->foo = 'bar';

$repo = new MyRepository($connection, new MyFactory());
$repo->save($entity);
```

Done!

Documentation
-------------

* [Developers Guide](http://datamonkey.readthedocs.org/en/latest/)
* [API Documentation](https://devsdmf.github.io/datamonkey)

Tests
-----

```
$ composer install --dev
$ ./vendor/bin/phpunit
```

License
-------

This library is licensed under the [MIT license](LICENSE).