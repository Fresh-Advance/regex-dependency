<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Configuration\Pattern;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Configuration\Pattern
 */
class PatternTest extends TestCase
{
    public function testItemDefaultValues()
    {
        $item = new Pattern("someId", "someKey", "someValue");

        $this->assertSame("someId", $item->getId());
        $this->assertSame("someKey", $item->getSearchKey());
        $this->assertSame("someValue", $item->getValue());
    }
}
