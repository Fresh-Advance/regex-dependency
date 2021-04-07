<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Configuration\Collection;

class SecondCollection extends Collection
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
