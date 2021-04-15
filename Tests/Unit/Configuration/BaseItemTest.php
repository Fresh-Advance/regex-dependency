<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Configuration\BaseItem
 */
class BaseItemTest extends TestCase
{
    public function testBaseItem(): void
    {
        $item = new class extends \FreshAdvance\Dependency\Configuration\BaseItem {
            protected string $key = 'someKey';
            protected string $id = 'someId';
            protected $value = 'someValue';
        };

        $this->assertSame("someId", $item->getId());
        $this->assertSame("someKey", $item->getSearchKey());
        $this->assertSame("someValue", $item->getValue());
    }
}
