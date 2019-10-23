<?php

namespace Sieg\Dependency\Tests;

use PHPUnit\Framework\TestCase;
use Sieg\Dependency\Container;

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

    public function testGetMatchedItemWithArguments()
    {
        $configuration = [
            '/Controller\/.*?$/i' => function ($dependency, $key, $arguments = []) {
                return $arguments;
            }
        ];

        $container = new Container($configuration);

        $arguments = ['argumentkey' => 'argumentValue'];
        $result = $container->get('Controller/SomeExample', $arguments);
        $this->assertSame($arguments, $result);

        // check if new arguments fires new cache item
        $arguments = ['othertry' => 'otherValue'];
        $result = $container->get('Controller/SomeExample', $arguments);
        $this->assertSame($arguments, $result);
    }

    public function testGetUnMatchedException()
    {
        $configuration = [
            'key' => 'value'
        ];

        $this->expectException(\Exception::class);

        $container = new Container($configuration);
        $container->get('anything');
    }

    public function testGetUnMatchedNullValue()
    {
        $configuration = [
            'key' => null
        ];

        $this->expectException(\Exception::class);

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
}
