<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConstructor(): void
    {
        $configuration = new Configuration();
        $this->assertInstanceOf(Configuration::class, $configuration);
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
        $configuration = new Configuration($expected);
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
        $configuration = new Configuration(
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue',
            ],
            \FreshAdvance\Dependency\Tests\Unit\Example\FirstConfiguration::class
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
        $configuration = new Configuration(
            \FreshAdvance\Dependency\Tests\Unit\Example\FirstConfiguration::class,
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
        $configuration = new Configuration(
            [
                'key1' => 'value1',
                'key2' => $closureExample,
                'key3' => null,
                'key4' => 10,
                'firstkey1' => 'othervalue',
                'secondkey1' => 'othervalue',
            ],
            \FreshAdvance\Dependency\Tests\Unit\Example\SecondConfiguration::class
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
        $configuration = new Configuration(
            \FreshAdvance\Dependency\Tests\Unit\Example\SecondConfiguration::class,
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
