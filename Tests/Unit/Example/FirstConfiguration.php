<?php

namespace FreshAdvance\Dependency\Tests\Unit\Example;

use FreshAdvance\Dependency\Configuration;

class FirstConfiguration extends Configuration
{
    protected array $configurations = [
        [
            'firstkey1' => 'firstvalue1',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3'
        ]
    ];
}
