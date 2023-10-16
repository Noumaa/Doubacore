<?php

namespace Nouma\NORM;

use PDO;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class NORM
{
    use SingletonTrait;

    private PluginBase $plugin;

    /** @var IModel[] $models */
    private array $models;
    private PDO $PDO;

    public function __construct(PluginBase $plugin, string $dsn, string $username = null, string $password = null, string $options = null)
    {
        $this->plugin = $plugin;
        $this->PDO = new PDO($dsn, $username, $password, $options);
        self::setInstance($this);
    }

    private function getPDO(): PDO
    {
        return $this->PDO;
    }

    public function addModel(IModel $model): void
    {
        if (!isset($this->models)) $this->models = [];
        $this->models[] = $model;
    }

    public function createSchema() {
        if (!isset($this->models)) return true;
        foreach ($this->models as $model) {
            $tableName = $model->getTableName();

            $stmt = $this->PDO->prepare("CREATE TABLE ?;");
            $stmt->bindParam(0, $tableName);
            $stmt->execute();
        }
    }
}