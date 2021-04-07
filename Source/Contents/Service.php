<?php

namespace FreshAdvance\Dependency\Contents;

use FreshAdvance\Dependency\Interfaces\Service as ServiceInterface;

class Service implements ServiceInterface
{
    protected object $service;

    public function __construct(object $service)
    {
        $this->service = $service;
    }

    public function getService(): object
    {
        return $this->service;
    }
}
