# Entities

An *entity* is a object representation of an row in a table in your database, this object should contain all or some 
fields of your table, and these fields should be mapped using the annotations specified in the previous document.

An entity must have one or more primary keys, and these keys may have an *strategy* defined or not.

All entities must implement the *ExportableEntity* interface provided by the **DataMonkey** package, and these entities 
may extend the *ExportAbstract* class that is a configured implementation of the *ExportableEntity* interface to export 
your entities to your repository class.

## Simple Entity Example

```
namespace Vendor\Package;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class SimpleEntity extends ExportAbstract implements ExportableEntity
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

## Complex Entity Example

```
namespace Vendor\Package;

use DataMonkey\Entity\ExportableEntity;
use DataMonkey\Entity\ExportAbstract;

class ComplexEntity extends ExportAbstract implements ExportableEntity
{
    /**
     * @pk
     * @db_ref id_entity
     * @strategy auto
     */
    public $id = null;
    
    /**
     * @pk
     * @db_ref fk_column
     * @strategy manual
     */
    public $sub_id = null;

    /**
     * @db_ref foo_column
     */
    public $foo = null;
}
```
