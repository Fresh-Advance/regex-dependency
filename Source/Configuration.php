<?php

namespace FreshAdvance\Dependency;

class Configuration implements Interfaces\Configuration
{
    /** @var array<string|array> */
    protected array $configurations = [];

    /**
     * @param array<string|array> $configurations
     */
    public function __construct(...$configurations)
    {
        if ($configurations) {
            $this->configurations = $configurations;
        }
    }

    public function fetch(): array
    {
        $result = [];
        foreach ($this->configurations as $oneConfiguration) {
            if (is_string($oneConfiguration)) {
                /** @var Interfaces\Configuration $deepConfiguration */
                $deepConfiguration = new $oneConfiguration();
                $oneConfiguration = $deepConfiguration->fetch();
            }

            $result = array_merge($result, $oneConfiguration);
        }

        return $result;
    }
}
