<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Interfaces\ConfigurationItem;

abstract class BaseItem implements ConfigurationItem
{
    protected string $key;

    protected string $id;

    /** @var mixed */
    protected $value;

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
