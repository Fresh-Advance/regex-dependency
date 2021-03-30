<?php

namespace Sieg\Dependency\Contents;

/**
 * Class Service
 *
 * The class is used to find out if callback object should be written to registry or not.
 *
 * @package Sieg\Dependency
 */
class Service
{
    /** @var Object */
    protected $service;

    /**
     * Service constructor.
     *
     * @param Object $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * @return Object
     */
    public function getService()
    {
        return $this->service;
    }
}
