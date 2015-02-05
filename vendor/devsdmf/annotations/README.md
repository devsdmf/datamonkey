Annotations Handler
===================

[![Build Status](https://travis-ci.org/devsdmf/annotations.svg?branch=master)](https://travis-ci.org/devsdmf/annotations)
[![Latest Stable Version](https://poser.pugx.org/devsdmf/annotations/v/stable.svg)](https://packagist.org/packages/devsdmf/annotations) 
[![Total Downloads](https://poser.pugx.org/devsdmf/annotations/downloads.svg)](https://packagist.org/packages/devsdmf/annotations) 
[![Latest Unstable Version](https://poser.pugx.org/devsdmf/annotations/v/unstable.svg)](https://packagist.org/packages/devsdmf/annotations) 
[![License](https://poser.pugx.org/devsdmf/annotations/license.svg)](https://packagist.org/packages/devsdmf/annotations)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e1babe05-8adb-4d27-84d1-511d92e2c8df/mini.png)](https://insight.sensiolabs.com/projects/e1babe05-8adb-4d27-84d1-511d92e2c8df)

A simple and directly handler for docblock and annotations for PHP

Installation
------------

Just add the following dependency line to your *composer.json* file:

```json
{
    "require": {
        "devsdmf/annotations": "1.*"
    }
}
```

Usage
-----

```php
use Devsdmf\Annotations\Reader;
use ReflectionClass;

$reflector = new ReflectionClass('MyClass');
$reader = new Reader();

$annotation = $reader->getClassAnnotations($reflector);
```

*The example above work with the most of Reflector interface implementations, see the available adapters below.*

Adapters
--------

- ReflectionClass
- ReflectionFunction
- ReflectionMethod
- ReflectionObject
- ReflectionProperty

Tests
-----

To run the test suite, you need install the require-dev dependencies:

```
$ composer install --dev
$ ./vendor/bin/phpunit
```

License
-------

This library is licensed under the [MIT license](LICENSE).
