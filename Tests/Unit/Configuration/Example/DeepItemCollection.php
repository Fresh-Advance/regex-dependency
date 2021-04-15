<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Configuration\Collection;
use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Interfaces\ConfigurationItemCollection;

class DeepItemCollection implements ConfigurationItemCollection
{
    public function getItems(): array
    {
        $collection = new Collection(
            new Item('someKey', 'deepOriginalValue'),
            new SimpleItemCollection(),
            new Item('secondKey1', 'secondValue1'),
            new Item('secondKey2', 'secondValue2')
        );

        return $collection->getItems();
    }
}
