RegEx Dependency Container
==========================

[![Build Status](https://travis-ci.org/Sieg/regex-dependency.svg?branch=master)](https://travis-ci.org/Sieg/regex-dependency)
[![Coverage Status](https://coveralls.io/repos/github/Sieg/regex-dependency/badge.svg?branch=master)](https://coveralls.io/github/Sieg/regex-dependency?branch=master)
[![Packagist](https://img.shields.io/packagist/v/sieg/regex-dependency.svg)](https://packagist.org/packages/sieg/regex-dependency)

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