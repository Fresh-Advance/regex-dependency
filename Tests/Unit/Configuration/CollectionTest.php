<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Collection;
use FreshAdvance\Dependency\Tests\Unit\Configuration\Example\FirstCollection;
use FreshAdvance\Dependency\Tests\Unit\Configuration\Example\SecondCollection;
use FreshAdvance\Dependency\Tests\Unit\Configuration\Example\SimpleConfiguration;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testConstructor(): void
    {
        $configuration = new Collection();
        $this->assertInstanceOf(Collection::class, $configuration);
        $this->assertSame([], $configuration->fetch());
    }

    public function testConstructorConfiguration(): void
    {
        $expected = [
            'key1' => 'value1',
            'key2' => function () {
            },
            'key3' => null,
            'key4' => 10,
        ];
        $configuration = new Collection($expected);
        $this->assertEquals($expected, $configuration->fetch());
    }

    public function testSimpleConfigCanBeMergedIn(): void
    {
        $regularPattern = [
            'key1' => 'value1'
        ];
        $expected = [
            'key1' => 'value1',
            'someKey' => 'someValue'
        ];

        $configuration = new Collection(
            $regularPattern,
            SimpleConfiguration::class
        );
        $this->assertEquals($expected, $configuration->fetch());
    }

    public function testDeepLoadConfiguration(): void
    {
        $closureExample = function () {
        };
        $expected = [
            'key1' => 'value1',
            'key2' => $closureExample,
            'key3' => null,
            'key4' => 10,
            'firstkey1' => 'firstvalue1',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3',
        ];
        $configuration = new Collection(
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue',
            ],
            FirstCollection::class
        );
        $this->assertEquals($expected, $configuration->fetch());
    }

    public function testDeepLoadReverseConfiguration(): void
    {
        $closureExample = function () {
        };
        $expected = [
            'firstkey1' => 'othervalue',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3',
            'key1' => 'value1',
            'key2' => $closureExample,
            'key3' => null,
            'key4' => 10,
        ];
        $configuration = new Collection(
            FirstCollection::class,
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue'
            ],
        );
        $this->assertEquals($expected, $configuration->fetch());
    }

    public function testDeepFileLoadConfiguration(): void
    {
        $closureExample = function () {
        };
        $expected = [
            'key1' => 'value1',
            'key2' => $closureExample,
            'key3' => null,
            'key4' => 10,
            'firstkey1' => 'firstvalue1',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3',
            'secondkey1' => 'secondvalue1',
            'secondkey2' => 'secondvalue2',
            'secondkey3' => 'secondvalue3'
        ];
        $configuration = new Collection(
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue',
                'secondkey1' => 'othervalue',
            ],
            SecondCollection::class
        );
        $this->assertEquals($expected, $configuration->fetch());
    }

    public function testDeepFileLoadReverseConfiguration(): void
    {
        $closureExample = function () {
        };
        $expected = [
            'key1' => 'value1',
            'key2' => $closureExample,
            'key3' => null,
            'key4' => 10,
            'firstkey1' => 'othervalue',
            'firstkey2' => 'firstvalue2',
            'firstkey3' => 'firstvalue3',
            'secondkey1' => 'othervalue',
            'secondkey2' => 'secondvalue2',
            'secondkey3' => 'secondvalue3'
        ];
        $configuration = new Collection(
            SecondCollection::class,
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue',
                'secondkey1' => 'othervalue',
            ]
        );
        $this->assertEquals($expected, $configuration->fetch());
    }
}
