<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Configuration\Collection;

class FirstCollection extends Collection
{
    protected array $configurations = [
        [
            'firstkey1' => 'firstvalue1',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3'
        ]
    ];
}
