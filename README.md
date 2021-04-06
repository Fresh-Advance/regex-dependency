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

Simple keys
-----------

    $configuration = [
        'key' => 'value'
    ];
    
    $container = new Container($configuration);
    $keyValue = $container->get('key');

Match keys
----------

Configuration key should start with "/" to be searched as regular expression. 
    
    $configuration = [
        '/Controller\/.*?$/i' => 'value'
    ];

    $container = new Container($configuration);
    $keyValue = $container->get('Controller/SomeExample');

Value as callback
-----------------

    $configuration = [
        '/Controller\/(.*?)$/i' => function ($dependency, $match) {
            return $match;
        }
    ];

Two arguments is sent to callbacks:
    
* $dependency - current instance of container
* $match - array with match results:
    - in string case like: ['Controller/SomeName']
    - in regular expression case, the match response is provided: ['Controller/SomeName', 'SomeName']
    
**Objects returned by callbacks are not cached by default**, but they can be, if wrapped as a Service.

    $configuration = [
        'someKey' => function (Container $dependency, $match) {
            return new Service(new \stdClass());
        }
    ];

    $container = new Container($configuration);
    $call1 = $container->get('someKey');