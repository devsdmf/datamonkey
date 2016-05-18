# ![logo](https://i.imgur.com/TYpSNO7.png) DataMonkey

[![Join the chat at https://gitter.im/devsdmf/datamonkey](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/devsdmf/datamonkey?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/devsdmf/datamonkey.svg?branch=master)](https://travis-ci.org/devsdmf/datamonkey)
[![Coverage Status](https://coveralls.io/repos/github/devsdmf/datamonkey/badge.svg?branch=master)](https://coveralls.io/github/devsdmf/datamonkey?branch=master)
[![Latest Stable Version](https://poser.pugx.org/devsdmf/datamonkey/v/stable.svg)](https://packagist.org/packages/devsdmf/datamonkey)
[![Total Downloads](https://poser.pugx.org/devsdmf/datamonkey/downloads.svg)](https://packagist.org/packages/devsdmf/datamonkey)
[![Documentation Status](https://readthedocs.org/projects/datamonkey/badge/?version=latest)](https://readthedocs.org/projects/datamonkey/?badge=latest)
[![License](https://poser.pugx.org/devsdmf/datamonkey/license.svg)](https://packagist.org/packages/devsdmf/datamonkey)

A simple database ORM for PHP projects build on top of Doctrine.

Installation
------------

```json
$ composer require devsdmf/datamonkey
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
