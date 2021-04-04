<?php

namespace FreshAdvance\Dependency\Tests\Unit\Example;

use FreshAdvance\Dependency\Configuration;

class SecondConfiguration extends Configuration
{
    protected array $configurations = [
        FirstConfiguration::class,
        [
            'secondkey1' => 'secondvalue1',
            'secondkey2' => 'secondvalue2',
            'secondkey3' => 'secondvalue3'
        ]
    ];
}
