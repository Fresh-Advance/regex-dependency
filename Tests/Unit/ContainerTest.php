<?php

namespace FreshAdvance\Dependency\Tests\Unit;

use FreshAdvance\Dependency\Configuration\Collection;
use FreshAdvance\Dependency\Configuration\Item;
use FreshAdvance\Dependency\Configuration\Pattern;
use FreshAdvance\Dependency\Container;
use FreshAdvance\Dependency\Contents\Service;
use FreshAdvance\Dependency\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Dependency\Container
 */
class ContainerTest extends TestCase
{
    protected const EXISTING_CONTROLLER = 'Controller/SomeExample';

    public function testConstructor(): void
    {
        $container = new Container();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testGetSimpleItem(): void
    {
        $configuration = new Collection(
            new Item('key', 'value')
        );

        $container = new Container($configuration);
        $result = $container->get('key');

        $this->assertSame('value', $result);
    }

    public function testGetCallbackItem(): void
    {
        $configuration = new Collection(
            new Item('key', function ($dependency, $match) {
                return $match;
            })
        );

        $container = new Container($configuration);
        $this->assertSame(['key'], $container->get('key'));
    }

    public function testGetMatchedItem(): void
    {
        $configuration = new Collection(
            new Pattern(
                'exampleExpression',
                '/Controller\/(.*?)$/i',
                function ($dependency, $match) {
                    return $match;
                }
            )
        );

        $container = new Container($configuration);
        $result = $container->get(self::EXISTING_CONTROLLER);

        $this->assertSame([
            self::EXISTING_CONTROLLER,
            'SomeExample'
        ], $result);
    }

    public function testGetUnMatchedException(): void
    {
        $configuration = new Collection(
            new Item('key', 'value')
        );

        $this->expectException(NotFoundException::class);

        $container = new Container($configuration);
        $container->get('anything');
    }

    public function testGetUnMatchedNullValue(): void
    {
        $configuration = new Collection(
            new Item('key', null)
        );

        $this->expectException(NotFoundException::class);

        $container = new Container($configuration);
        $container->get('anything');
    }

    public function testGetRecursiveDependency(): void
    {
        $configuration = new Collection(
            new Item('first', 'someValue'),
            new Item('second', function (Container $dependency, $key) {
                return $dependency->get('first');
            })
        );

        $container = new Container($configuration);
        $result = $container->get('second');

        $this->assertSame('someValue', $result);
    }

    public function testHas(): void
    {
        $configuration = new Collection(
            new Pattern(
                'patternExample',
                '/Controller\/(.*?)$/i',
                function ($dependency, $match) {
                    return $match;
                }
            ),
            new Item('/', 'Special case with one boundary')
        );

        $container = new Container($configuration);
        $this->assertTrue($container->has(self::EXISTING_CONTROLLER));
        $this->assertTrue($container->has('/'));
        $this->assertFalse($container->has('somethingNotExisting'));
    }

    public function testGetSameServiceObjectOnDifferentCallsByDefault(): void
    {
        $configuration = new Collection(
            new Item('someKey', function (Container $dependency, $match) {
                return new Service(new \stdClass());
            })
        );

        $container = new Container($configuration);
        $call1 = $container->get('someKey');
        $call2 = $container->get('someKey');

        $this->assertSame(spl_object_id($call1), spl_object_id($call2));
    }

    /**
     * @param mixed $expectedResult
     * @dataProvider calculateValueDataProvider
     */
    public function testCallbackCalculationsCached($expectedResult, int $expectedCalls): void
    {
        $mock = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['someMethod'])
            ->getMock();

        $mock->expects($this->exactly($expectedCalls))
            ->method('someMethod')
            ->willReturn($expectedResult);

        $configuration = new Collection(
            new Item('mockedClass', $mock),
            new Item('someKey', function (Container $dependency, $match) {
                $mockedItem = $dependency->get('mockedClass');
                return $mockedItem->someMethod();
            })
        );

        $container = new Container($configuration);
        $result = $container->get('someKey');
        $container->get('someKey');

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array<mixed>
     */
    public function calculateValueDataProvider(): array
    {
        return [
            ['string', 1],
            [123, 1],
            [new \stdClass(), 2],
            [true, 1],
            [['array'], 1]
        ];
    }

    public function testGetDifferentItemObjectOnDifferentCallsIfItemReturned(): void
    {
        $configuration = new Collection(
            new Item('someKey', function (Container $dependency, $match) {
                return new \stdClass();
            })
        );

        $container = new Container($configuration);
        $call1 = $container->get('someKey');
        $call2 = $container->get('someKey');

        $this->assertNotSame(spl_object_id($call1), spl_object_id($call2));
    }
}
