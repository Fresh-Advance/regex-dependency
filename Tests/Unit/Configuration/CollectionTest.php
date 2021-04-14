<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Collection;
use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Tests\Unit\Configuration\Example\DeepItemCollection;
use FreshAdvance\Dependency\Tests\Unit\Configuration\Example\SimpleItemCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Configuration\Collection
 */
class CollectionTest extends TestCase
{
    public function testConstructor(): void
    {
        $configuration = new Collection();
        $this->assertInstanceOf(Collection::class, $configuration);
        $this->assertSame([], $configuration->getItems());
    }

    public function testConstructorConfiguration(): void
    {
        $expected = [
            new Item('key1', 'value1'),
            new Item('key2', 'value2'),
        ];
        $configuration = new Collection(...$expected);
        $this->assertEquals($expected, $configuration->getItems());
    }

    public function testSimpleIdentifierOverwrite(): void
    {
        $expected = [
            new Item('key1', 'value2'),
        ];
        $configuration = new Collection(
            new Item('key1', 'value1'),
            new Item('key1', 'value2')
        );
        $this->assertEquals($expected, $configuration->getItems());
    }

    public function testSimpleConfigCanBeMergedIn(): void
    {
        $expected = [
            new Item('key1', 'value1'),
            new Item('someKey', 'someValue'),
        ];

        $configuration = new Collection(
            new Item('key1', 'value1'),
            new SimpleItemCollection()
        );

        $fetchedConfiguration = $configuration->getItems();
        $this->assertContainsOnlyInstancesOf(Item::class, $fetchedConfiguration);
        $this->assertEquals($expected, $fetchedConfiguration);
    }

    public function testSimpleConfigCanBeMergedInAndOverwritten(): void
    {
        $expected = [
            new Item('key1', 'value1'),
            new Item('someKey', 'otherValue'),
        ];

        $configuration = new Collection(
            new Item('key1', 'value1'),
            new SimpleItemCollection,
            new Item('someKey', 'otherValue')
        );

        $fetchedConfiguration = $configuration->getItems();
        $this->assertContainsOnlyInstancesOf(Item::class, $fetchedConfiguration);
        $this->assertEquals($expected, $fetchedConfiguration);
    }

    public function testDeepLoadConfigurationCanBeOverwritten(): void
    {
        $closureExample = function () {
        };

        $expected = [
            new Item('key1', 'value1'),
            new Item('key2', $closureExample),
            new Item('key3', null),
            new Item('key4', 10),
            new Item('someKey', 'someValue'),
            new Item('secondKey1', 'secondValue1'),
            new Item('secondKey2', 'secondValue2')
        ];

        $configuration = new Collection(
            new Collection(
                new Item('key1', 'value1'),
                new Item('key2', $closureExample),
                new Item('key3', null),
                new Item('key4', 10)
            ),
            new DeepItemCollection()
        );

        $this->assertEquals($expected, $configuration->getItems());
    }

    public function testReverseDeepLoadConfigurationCanBeOverwritten(): void
    {
        $closureExample = function () {
        };

        $expected = [
            new Item('someKey', 'someOtherValue'),
            new Item('secondKey1', 'secondValue1'),
            new Item('secondKey2', 'secondValue2'),
            new Item('key1', 'value1'),
            new Item('key2', $closureExample),
            new Item('key3', null),
            new Item('key4', 10),
        ];

        $configuration = new Collection(
            new DeepItemCollection(),
            new Item('someKey', 'someOtherValue'),
            new Collection(
                new Item('key1', 'value1'),
                new Item('key2', $closureExample),
                new Item('key3', null),
                new Item('key4', 10)
            ),
        );

        $this->assertEquals($expected, $configuration->getItems());
    }
}
