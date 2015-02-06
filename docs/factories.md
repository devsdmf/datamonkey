# Factories

A *factory* class is a helper that will used by repository classes when you perform fetch methods, that will allow the 
DataMonkey returns to you an instance of your entity instead of an array with the data returned by the query.

The *factory* class is really simple, you only need to extend the *AbstractFactory* class provided by the DataMonkey 
package and override the *create* method that will be used by the repository class to create a configured instance of 
your entity, and in this *create* method you can call the static method *factory* passing the options parameter, 
this method is provided by the *ExportableEntity* interface implemented in your entity.

## Factory Class Example

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
