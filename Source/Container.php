<?php

namespace Sieg\Dependency;

use Psr\Container\ContainerInterface;
use Sieg\Dependency\Exception\NotFoundException;

class Container implements ContainerInterface
{
    /**
     * Configuration variable
     *
     * @var array
     */
    protected $configuration = [];

    /**
     * Cache of processed items
     *
     * @var array
     */
    protected $registry = [];

    /**
     * Container constructor.
     *
     * @param null|array $configuration
     */
    public function __construct($configuration = null)
    {
        $configuration && $this->setConfiguration($configuration);
    }

    /**
     * Overwrite configuration contents
     *
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Get whole configuration content
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get dependency item
     *
     * @param string $key
     * @param array $arguments
     *
     * @return mixed
     * @throws \Exception if nothing matches by the key in container configuration
     *
     */
    public function get($key, $arguments = [])
    {
        $hash = $this->getCallHash($key, $arguments);
        if (!isset($this->registry[$hash])) {
            $this->registry[$hash] = $this->getNew($key, $arguments);
        }

        return $this->registry[$hash];
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
     * @param string $key
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws NotFoundException if nothing matches by the key in container configuration
     */
    public function getNew($key, $arguments = [])
    {
        list($item, $match) = $this->getConfigurationByKey($key);
        return is_callable($item) ? $item($this, $match, $arguments) : $item;
    }

    /**
     * Calculate hash by key and arguments
     *
     * @param string $key
     * @param array $arguments
     *
     * @return string
     */
    protected function getCallHash($key, $arguments)
    {
        return md5($key . json_encode($arguments));
    }

    /**
     * Get one key configuration from configuration array
     *
     * @param string $key
     *
     * @return array($key, $matches)
     *
     * @throws NotFoundException if nothing matches by the key in container configuration
     */
    protected function getConfigurationByKey($key)
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
