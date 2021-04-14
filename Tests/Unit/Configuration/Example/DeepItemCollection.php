<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Configuration\Collection;
use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Interfaces\ConfigurationItemCollection;

class DeepItemCollection implements ConfigurationItemCollection
{
    protected array $configurations = [
        FirstCollection::class,
        [
            'secondkey1' => 'secondvalue1',
            'secondkey2' => 'secondvalue2',
            'secondkey3' => 'secondvalue3'
        ]
    ];
}
