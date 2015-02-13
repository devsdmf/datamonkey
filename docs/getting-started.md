# Getting Started

This article will guide you to learn *what is an ORM*, *how an ORM can help you* and *how to use the DataMonkey correctly*.

## What is an ORM ?

Object-relational mapping (ORM, O/RM, and O/R mapping) in computer science is a programming technique for converting data 
between incompatible type systems in object-oriented programming languages. ([Wikipedia](http://en.wikipedia.org/wiki/Object-relational_mapping))
In this case, we can say that an ORM would be a way to mirror an object from your database structure, this provides you 
a solid application architecture that will be transparent when the data must be persisted in a database system, you can 
manipulate your "database objects" in a *clean way* that provides an most readable, maintainable and beautiful code.

## How an ORM can help you ?

The use of an ORM provides you a lot of benefits such as, object-oriented database structure, 
transparent transaction (less queries), easily interactions between entities (because all is objects), easy to understand, 
more maintainable code and a lot of other things.

## How to use DataMonkey correctly ?

Before start this guide, you'll need to install the DataMonkey in your project, then, if you haven't did it or don't 
know how do this, see the [installation guide](installation.md), and you need know too how to instantiate an Doctrine DBAL 
Connection object, to do this, I recommend you to read this [quick guide](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#getting-a-connection) 
in the Doctrine documentation.

> Doctrine DBAL is already included in DataMonkey package.

### Let's start!

First, you need to create an entity that is a *mirror* of an table in your database, assuming that our table has only
two fields, *id_entity* and *foo_column*, we need to create an entity object that extends the *ExportAbstract* class and
implements the *ExportableEntity* interface, and set all fields of our table as properties in the entity class.

To map our entity, we will use the docblock annotations to tell to DataMonkey which field represent that property, you can
see the [annotations section](annotations.md) to see which annotations are supported by DataMonkey.

Then, here is our entity:

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

Now, we need to create a factory class to build our entity when an fetch operation is performed in the repository class.
The factory class must extend the *AbstractFactory* class and implement the method *create*, and in this method we will 
configure and return an instance of our entity created above.

Then, let's create an factory for our entity:

```
namespace Vendor\Package;

use DataMonkey\Entity\Factory\AbstractFactory;
use Vendor\Package\SimpleEntity;

class SimpleFactory extends AbstractFactory
{

    public function create($options = null)
    {
        return SimpleEntity::factory($options);
    }
}
```

Now, the DataMonkey not yet known which table represents our entity, for it, we need to create an repository class and 
tell to DataMonkey which table it will persist the entity and what is their factory, and one more time, our class must 
extend an DataMonkey class, this time, we must extend *Repository* class and we need to set an property *$_name* that 
will receive the name of our table.

```
namespace Vendor\Package;

use DataMonkey\Repository\Repository;

class SimpleRepository extends Repository
{

    protected $_name = 'mytable';
}
```

Now, let's insert a new object in database:

```
// Our previous created entity
use Vendor\Package\SimpleEntity;
// Our factory
use Vendor\Package\SimpleFactory;
// and our repository
use Vendor\Package\SimpleRepository;

// Configure your doctrine DBAL connection
$connection = new \Doctrine\DBAL\Connection(...);

// Creating an instance of our entity and setting the data
$entity = new MyEntity();
$entity->foo = 'bar';

// Creating an instance of the repository and the factory
$repo = new MyRepository($connection, new MyFactory());

// Persisting our entity
$repo->save($entity);
```

Alright! You finished the getting started guide, now you're able to use the DataMonkey in your projects, for an more
advanced usage, check the next sections.

Enjoy!
