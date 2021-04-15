<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Interfaces\ConfigurationItem;

class Pattern implements ConfigurationItem
{
    protected string $key;

    protected string $id;

    protected $value;

    /**
     * @param string $id
     * @param mixed $value
     */
    public function __construct(string $id, string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->id = $id;
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
