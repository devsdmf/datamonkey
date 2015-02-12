<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('DataMonkey\Tests', __DIR__);

if((bool)getenv('TRAVIS_ENV')) {
    define('DATABASE_DRIVER','pdo_mysql');
    define('DATABASE_HOST','localhost');
    define('DATABASE_USER','root');
    define('DATABASE_PASS','');
    define('DATABASE_NAME','datamonkey_test');
} else {
    define('DATABASE_DRIVER','pdo_mysql');
    define('DATABASE_HOST','localhost');
    define('DATABASE_USER','root');
    define('DATABASE_PASS','');
    define('DATABASE_NAME','datamonkey_test');
}