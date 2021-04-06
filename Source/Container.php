<?php

namespace FreshAdvance\Dependency;

use FreshAdvance\Dependency\Interfaces\Configuration as ConfigurationInterface;
use Psr\Container\ContainerInterface;
use FreshAdvance\Dependency\Contents\Service;
use FreshAdvance\Dependency\Exception\NotFoundException;

class Container implements ContainerInterface
{
    /**
     * Configuration variable
     *
     * @var array<mixed>
     */
    protected $configuration = [];

    /**
     * Cache of processed items
     *
     * @var array<mixed>
     */
    protected $registry = [];

    public function __construct(ConfigurationInterface $configuration = null)
    {
        if ($configuration) {
            $this->setConfiguration($configuration);
        }
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->configuration = $configuration->fetch();
    }

    /**
     * Get whole configuration content
     *
     * @return array<mixed>
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * Get dependency item
     *
     * @param string $key
     *
     * @return mixed
     * @throws \Exception if nothing matches by the key in container configuration
     *
     */
    public function get($key)
    {
        if (isset($this->registry[$key])) {
            return $this->registry[$key];
        } else {
            return $this->callNotCachedItem($key);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        try {
            $this->getConfigurationByKey($key);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * Get not cached item by dependency configuration
     *
     * Cache the item if possible
     *
     * @param string $key
     *
     * @return mixed
     *
     * @throws NotFoundException if nothing matches by the key in container configuration
     */
    protected function callNotCachedItem($key)
    {
        list($item, $match) = $this->getConfigurationByKey($key);
        $result = is_callable($item) ? $item($this, $match) : $item;

        if (!is_object($result)) {
            $this->registry[$key] = $result;
        } elseif ($result instanceof Service) {
            $result = $result->getService();
            $this->registry[$key] = $result;
        }

        return $result;
    }

    /**
     * Get one key configuration from configuration array
     *
     * @param string $key
     *
     * @return array<mixed>
     *
     * @throws NotFoundException if nothing matches by the key in container configuration
     */
    protected function getConfigurationByKey(string $key): array
    {
        if (isset($this->configuration[$key])) {
            return [$this->configuration[$key], [$key]];
        } else {
            foreach ($this->configuration as $configurationKey => $item) {
                if (
                    strpos($configurationKey, "/") === 0
                    && preg_match($configurationKey, $key, $matches)
                ) {
                    return [$item, $matches];
                }
            }
        }

        throw new NotFoundException("No configuration in container matches {$key}.");
    }
}
