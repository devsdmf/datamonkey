<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Silex\Tests', __DIR__);

/**
 * @name test_function
 */
function test_function(){}

class CustomTestClass {

    /**
     * @var string
     */
    public $name = 'value';
}
