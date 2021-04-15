<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Exception\PatternConfigurationException;

class Pattern extends BaseItem
{
    /**
     * @param mixed $value
     */
    public function __construct(string $id, string $key, $value)
    {
        if (@preg_match($key, '') === false) {
            throw new PatternConfigurationException();
        }

        $this->key = $key;
        $this->value = $value;
        $this->id = $id;
    }
}
