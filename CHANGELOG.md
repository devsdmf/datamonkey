# CHANGELOG

- `1.2.3`
    * Fixed auto primary key in entities with manual strategy primary key
- `1.2.2`
    * Changed Repository's save method behavior to return the entity in no affected row update instead of throw a TransactionException
- `1.2.1`
    * Fixed coveralls api spec
- `1.2.0`
    * Changed minimum php version from 5.4 to 5.5
    * Updated project dependencies
- `1.1.4`
    * Changed connection parameter to receive an instance instead of a reference
- `1.1.3`
    * Fixed a bug when a limit and/or offset parameters in fetch method is not a literal integer
- `1.1.2`
    * Fixed entity mapping bug that causes to mapper index properties without @db_ref annotation
- `1.1.1`
    * Changed the factory property visibility in Repository class
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
