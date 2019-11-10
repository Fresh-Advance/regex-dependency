<?php

namespace Sieg\Dependency\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface;
use Sieg\Dependency\Container;
use Sieg\Dependency\Contents\Service;

class ContainerTest extends TestCase
{
    public function testConstructor()
    {
        $container = new Container();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testContainerGetConstructorConfiguration()
    {
        $configuration = [
            'key' => 'value'
        ];

        $container = new Container($configuration);
        $this->assertSame($configuration, $container->getConfiguration());
    }

    public function testContainerSetGetConfiguration()
    {
        $configuration = [
            'key' => 'value'
        ];

        $container = new Container();
        $container->setConfiguration($configuration);
        $this->assertSame($configuration, $container->getConfiguration());
    }

    public function testGetSimpleItem()
    {
        $configuration = [
            'key' => 'value'
        ];

        $container = new Container($configuration);
        $result = $container->get('key');

        $this->assertSame('value', $result);
    }

    public function testGetCallbackItem()
    {
        $configuration = [
            'key' => function ($dependency, $match) {
                return $match;
            }
        ];

        $container = new Container($configuration);
        $this->assertSame(['key'], $container->get('key'));
    }

    public function testGetMatchedItem()
    {
        $configuration = [
            '/Controller\/(.*?)$/i' => function ($dependency, $match) {
                return $match;
            }
        ];

        $container = new Container($configuration);
        $result = $container->get('Controller/SomeExample');

        $this->assertSame([
            'Controller/SomeExample',
            'SomeExample'
        ], $result);
    }

    public function testGetUnMatchedException()
    {
        $configuration = [
            'key' => 'value'
        ];

        $this->expectException(NotFoundExceptionInterface::class);

        $container = new Container($configuration);
        $container->get('anything');
    }

    public function testGetUnMatchedNullValue()
    {
        $configuration = [
            'key' => null
        ];

        $this->expectException(NotFoundExceptionInterface::class);

        $container = new Container($configuration);
        $container->get('anything');
    }

    public function testGetRecursiveDependency()
    {
        $configuration = [
            'first' => 'someValue',
            'second' => function (Container $dependency, $key) {
                return $dependency->get('first');
            }
        ];

        $container = new Container($configuration);
        $result = $container->get('second');

        $this->assertSame('someValue', $result);
    }

    public function testHas()
    {
        $configuration = [
            '/Controller\/(.*?)$/i' => function ($dependency, $match) {
                return $match;
            }
        ];

        $container = new Container($configuration);
        $this->assertTrue($container->has('Controller/SomeExample'));
        $this->assertFalse($container->has('somethingNotExisting'));
    }

    public function testGetSameServiceObjectOnDifferentCallsByDefault()
    {
        $configuration = [
            'someKey' => function (Container $dependency, $match) {
                return new Service(new \stdClass());
            }
        ];

        $container = new Container($configuration);
        $call1 = $container->get('someKey');
        $call2 = $container->get('someKey');

        $this->assertSame(spl_object_id($call1), spl_object_id($call2));
    }

    /**
     * @dataProvider calculateValueDataProvider
     */
    public function testCallbackCalculationsCached($expectedResult, $expectedCalls)
    {
        $mock = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['someMethod'])
            ->getMock();

        $mock->expects($this->exactly($expectedCalls))->method('someMethod')->willReturn($expectedResult);

        $configuration = [
            'mockedClass' => $mock,
            'someKey' => function (Container $dependency, $match) {
                $mockedItem = $dependency->get('mockedClass');
                return $mockedItem->someMethod();
            }
        ];

        $container = new Container($configuration);
        $result = $container->get('someKey');
        $container->get('someKey');

        $this->assertSame($expectedResult, $result);
    }

    public function calculateValueDataProvider()
    {
        return [
            ['string', 1],
            [123, 1],
            [new \stdClass(), 2],
            [true, 1],
            [['array'], 1]
        ];
    }

    public function testGetDifferentItemObjectOnDifferentCallsIfItemReturned()
    {
        $configuration = [
            'someKey' => function (Container $dependency, $match) {
                return new \stdClass();
            }
        ];

        $container = new Container($configuration);
        $call1 = $container->get('someKey');
        $call2 = $container->get('someKey');

        $this->assertNotSame(spl_object_id($call1), spl_object_id($call2));
    }
}
