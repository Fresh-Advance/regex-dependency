<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Item;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Configuration\Item
 */
class ItemTest extends TestCase
{
    public function testItemDefaultValues()
    {
        $item = new Item("someKey", "someValue");

        $this->assertSame("someKey", $item->getId());
        $this->assertSame("someKey", $item->getSearchKey());
        $this->assertSame("someValue", $item->getValue());
    }

    public function testItemSpecialId()
    {
        $item = new Item("someKey", "someValue", "specialId");

        $this->assertSame("specialId", $item->getId());
        $this->assertSame("someKey", $item->getSearchKey());
        $this->assertSame("someValue", $item->getValue());
    }
}
