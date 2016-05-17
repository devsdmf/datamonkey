# CHANGELOG
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
