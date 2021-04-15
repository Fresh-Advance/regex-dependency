<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Interfaces\ConfigurationItem;

class Item implements ConfigurationItem
{
    protected string $key;

    protected string $id;

    protected $value;

    /**
     * @param string $id
     * @param mixed $value
     */
    public function __construct(string $key, $value, string $id = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->id = $id ?? $key;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSearchKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
