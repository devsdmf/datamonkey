# ![logo](https://i.imgur.com/TYpSNO7.png) Welcome to DataMonkey documentation

DataMonkey is a simplified ORM for PHP projects built on top of Doctrine DBAL. The DataMonkey ORM was created to ease 
the use of an ORM and support legacy databases that has some limitations which prevents the use the default Doctrine ORM.

## Features
- Simple ORM
- Low learn curve
- Entity Mapper
- Repository Persistence

## Getting Started

If you never used an ORM before, you should read the [Getting Started](getting-started.md) guide to get familiar
with *what an ORM does*, *how it can help you* and *how to use DataMonkey correctly*.

# CHANGELOG

- `1.1.0`
    * Implemented fetch method to search for large data sets in database without requires an criteria
    * Added support to fetch entities using an entity instance
    * Improved unit tests
- `1.0.2`
    * Added support to multiple primary keys
    * Added strategy to solve the correct task on SQL builder
- `1.0.1`
    * Decreased minimum version of Doctrine from 2.5 to 2.4
- `1.0.0`
    * First stable release
