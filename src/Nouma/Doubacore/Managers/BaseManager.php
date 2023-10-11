<?php

namespace Nouma\Doubacore\Managers;

use Nouma\Doubacore\Doubacore;
use pocketmine\utils\BroadcastLoggerForwarder;
use pocketmine\utils\Config;

abstract class BaseManager
{

    protected Config $config;

    public function __construct(Doubacore $plugin, string $filename) {
        $plugin->saveResource("$filename.yml");
        $this->config = new Config($plugin->getDataFolder() . "$filename.yml", Config::YAML);
    }


    /**
     *  Return YAML's file configuration.
     *  @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    abstract public function save($model);

    /**
     *  Retrieve all saved elements.
     *  @return mixed Element[]
     */
    public function getAll(): array
    {
        $models = [];
        foreach ($this->config->getAll() as $key => $_) {
            if ($this->get($key) != null) $models[] = $this->get($key);
        }
        return $models;
    }

    /**
     * Retrieve an element depending on a key.
     * @param string $key
     * @return mixed Element
     */
    abstract public function get(string $key): mixed;

    /**
     * Check whether an element exists, depending on a key.
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return $this->config->exists($key);
    }

    /**
     * Retrieve data from the config file depending on a key.
     * @param string $key
     * @return ?array
     */
    protected function deserializeArray(string $key): ?array
    {
        foreach ($this->config->getAll() as $id => $array) {
            if ($id == $key) return $array;
        }
        return null;
    }
}