<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Interfaces\ConfigurationItemCollection;

class SimpleItemCollection implements ConfigurationItemCollection
{
    public function getItems(): array
    {
        return [
            new Item('someKey', 'someValue')
        ];
    }
}
