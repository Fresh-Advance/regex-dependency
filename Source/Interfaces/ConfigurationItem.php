<?php

namespace FreshAdvance\Dependency\Interfaces;

/**
 * Container configuration item
 */
interface ConfigurationItem
{
    /**
     * Id for identifying this item by
     */
    public function getId(): string;

    /**
     * String to search for this item value in Container
     */
    public function getSearchKey(): string;

    /**
     * @return mixed
     */
    public function getValue();
}
