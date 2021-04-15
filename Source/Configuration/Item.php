<?php

namespace FreshAdvance\Dependency\Configuration;

class Item extends BaseItem
{
    /**
     * @param mixed $value
     */
    public function __construct(string $key, $value, string $id = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->id = $id ?? $key;
    }
}
