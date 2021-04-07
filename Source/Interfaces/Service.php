<?php

namespace FreshAdvance\Dependency\Interfaces;

/**
 * Interface to decide if object should be cached in registry or not
 */
interface Service
{
    public function getService(): object;
}
