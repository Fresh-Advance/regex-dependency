<?php

namespace FreshAdvance\Dependency\Tests\Unit\Contents;

use PHPUnit\Framework\TestCase;
use FreshAdvance\Dependency\Contents\Service;

class ServiceTest extends TestCase
{
    public function testGetService(): void
    {
        $serviceObject = new \stdClass();
        $serviceWrap = new Service($serviceObject);
        $this->assertSame($serviceObject, $serviceWrap->getService());
    }
}
