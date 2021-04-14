RegEx Dependency Container
==========================

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_regex-dependency&metric=alert_status)](https://sonarcloud.io/dashboard?id=Fresh-Advance_regex-dependency)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_regex-dependency&metric=coverage)](https://sonarcloud.io/dashboard?id=Fresh-Advance_regex-dependency)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_regex-dependency&metric=sqale_index)](https://sonarcloud.io/dashboard?id=Fresh-Advance_regex-dependency)
[![Packagist](https://img.shields.io/packagist/v/fresh-advance/regex-dependency.svg)](https://packagist.org/packages/fresh-advance/regex-dependency)

Small, configurable service locator/DI container with possibility to describe keys as 
regular expressions. The component can be used as a Router too.

The package is:

* compliant to PSR-11.
* follow the PSR-4 and PSR-12
* works on PHP 7.2+.

## Simple case

    $configuration = new Collection(
        new Item('key', 'value'),
    );

    $container = new Container($configuration);
    $value = $container->get('key');

    var_dump:
      string(5) "value"

## Pattern case

    $configuration = new Collection(
        new Pattern('examplePattern', '/Example\/.*?$/i', 'SomeValue'),
    );
    
    $container = new Container($configuration);
    $value = $container->get('Example/Something');
    
    var_dump:
      string(9) "SomeValue"

## Value as callback

    $configuration = new Collection(
        new Pattern('examplePattern', '/Example\/(?P<special>.*?)$/i', function ($dependency, $match) {
            return $match;
        }),
    );
    
    $container = new Container($configuration);
    $keyValue = $container->get('Example/Something');

    var_dump:
      array(3) {
        [0] => string(17) "Example/Something"
        'special' => string(9) "Something"
        [1] => string(9) "Something"
      }

Two arguments is sent to callbacks:
    
* Container $dependency - current instance of container
* array $match - array with match results: the match response is provided: ['Controller/SomeName', 'SomeName']

## Service registry
**Objects returned by callbacks are not cached by default**, but they can be, if wrapped as a **Service**.

    $configuration = new Collection(
        new Item('someKey', function (Container $dependency) {
            return new Service(new \stdClass());
        })
    );