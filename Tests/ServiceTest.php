<?php

namespace Sieg\Dependency\Tests;

use PHPUnit\Framework\TestCase;
use Sieg\Dependency\Service;

class ServiceTest extends TestCase
{
    public function testGetService()
    {
        $serviceObject = new \stdClass();
        $serviceWrap = new Service($serviceObject);
        $this->assertSame($serviceObject, $serviceWrap->getService());
    }
}
