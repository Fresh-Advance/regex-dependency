<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Pattern;
use FreshAdvance\Dependency\Exception\PatternConfigurationException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Configuration\Pattern
 */
class PatternTest extends TestCase
{
    public function testItemDefaultValues(): void
    {
        $item = new Pattern("someId", "/someKey/i", "someValue");

        $this->assertSame("someId", $item->getId());
        $this->assertSame("/someKey/i", $item->getSearchKey());
        $this->assertSame("someValue", $item->getValue());
    }

    public function testPatternInitializationFailsIfNotRegexGivenAsKey(): void
    {
        $this->expectException(PatternConfigurationException::class);
        $item = new Pattern("someId", "someKey", "someValue");
    }
}
