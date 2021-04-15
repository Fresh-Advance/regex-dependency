<?php

namespace FreshAdvance\Dependency\Configuration;

use FreshAdvance\Dependency\Interfaces\ConfigurationItemCollection;
use FreshAdvance\Dependency\Interfaces\ConfigurationItem;

class Collection implements ConfigurationItemCollection
{
    /** @var array<string,ConfigurationItem> */
    protected array $configurationItems = [];

    /**
     * @param ConfigurationItem|ConfigurationItemCollection $configurationItems
     */
    public function __construct(...$configurationItems)
    {
        $this->processItems($configurationItems);
    }

    /**
     * @param array<ConfigurationItem|ConfigurationItemCollection> $items
     */
    protected function processItems(array $items): void
    {
        foreach ($items as $oneItem) {
            $this->processOneItem($oneItem);
        }
    }

    /**
     * @param ConfigurationItem|ConfigurationItemCollection $item
     */
    protected function processOneItem($item): void
    {
        if ($item instanceof ConfigurationItemCollection) {
            $this->processItems($item->getItems());
        } else {
            $this->addOneItem($item);
        }
    }

    protected function addOneItem(ConfigurationItem $item): void
    {
        $this->configurationItems[$item->getId()] = $item;
    }

    /**
     * @return array<ConfigurationItem>
     */
    public function getItems(): array
    {
        return array_values($this->configurationItems);
    }
}
