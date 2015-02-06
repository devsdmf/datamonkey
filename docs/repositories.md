# Repositories

A *repository* class is wrapper for your table in database, this is the class that will persist your entities in the 
database, and it is very simple to configure.

The only thing that you need to do, is extend the *Repository* class provided by DataMonkey package and set the *$_name* 
property that will represent the name of your table in database.

## Repository Example

```
namespace Vendor\Package;

use DataMonkey\Repository\Repository;

class SimpleRepository extends Repository
{

    protected $_name = 'mytable';
}
```
