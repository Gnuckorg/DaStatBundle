Aggregators
==========

Role
----

An aggregator is a class which is responsible of the data loading.

Creation of a new one
---------------------

To add your own aggregator, you just have to define a class implementing the `\Da\StatBundle\Aggregator\AggregatorInterface`

```php
// .../My/OwnBundle/Aggregator/MyAggregator.php

namespace My\OwnBundle\Aggregator;

use Da\StatBundle\Aggregator\AggregatorInterface;

class MyAggregator implements AggregatorInterface
{
    // Implementation...
}
```

Declare a new service on this class:

```yaml
# .../My/OwnBundle/Resources/config/services.yml

da_stat.aggregator.my:
    class: My\OwnBundle\Aggregator\MyAggregator
    arguments: []
    tags:
        - { name: da_stat.aggregator }
```