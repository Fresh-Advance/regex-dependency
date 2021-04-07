<?php

namespace FreshAdvance\Dependency\Tests\Unit\Configuration\Example;

use FreshAdvance\Dependency\Interfaces\Configuration;

class SimpleConfiguration implements Configuration
{
    public function fetch(): array
    {
        return [
            'someKey' => 'someValue'
        ];
    }
}
