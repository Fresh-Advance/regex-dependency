<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Interfaces\ConfigurationItemCollection;
use FreshAdvance\Dependency\Interfaces\ConfigurationItem;

class Collection implements ConfigurationItemCollection
{
    /** @var array<string,ConfigurationItem> */
    protected array $configurationItems = [];

    /**
     * @param array<ConfigurationItem|ConfigurationItemCollection> $configurationItems
     */
    public function __construct(...$configurationItems)
    {
        $this->addItems($configurationItems);
    }

    protected function addItems($items): void
    {
        foreach($items as $oneItem) {
            $this->addOneItem($oneItem);
        }
    }

    protected function addOneItem($item): void
    {
        if ($item instanceof ConfigurationItemCollection) {
            $this->addItems($item->getItems());
        } else {
            $this->configurationItems[$item->getId()] = $item;
        }
    }

    /**
     * @return array<ConfigurationItem>
     */
    public function getItems(): array
    {
        return array_values($this->configurationItems);
    }
}
