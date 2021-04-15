<?php

namespace FreshAdvance\Dependency\Interfaces;

/**
 * Container of configuration items
 */
interface ConfigurationItemCollection
{
    /**
     * @return array<ConfigurationItem>
     */
    public function getItems(): array;
}
