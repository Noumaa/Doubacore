<?php

namespace Nouma\Doubacore\Managers;

use Nouma\Doubacore\Doubacore;
use pocketmine\utils\Config;

abstract class BaseManager
{

    protected Config $config;

    public function __construct(Doubacore $plugin, string $filename) {
        $this->config = new Config($plugin->getDataFolder() . "$filename.yml", Config::YAML);
    }

    public function getAll(): array
    {
        $models = [];
        foreach ($this->config->getAll() as $key => $_) $models[] = $this->get($key);
        return $models;
    }

    abstract public function getConfig(): Config;

    abstract public function save($model);

    abstract public function get(string $key);

    protected function deserializeArray(string $key): ?array
    {
        foreach ($this->config->getAll() as $id => $array) {
            if ($id == $key) return $array;
        }
        return null;
    }
}