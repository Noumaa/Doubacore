<?php

namespace Nouma\Doubacore\Managers;

use JsonException;
use Nouma\Doubacore\Commands\Home\HomeCommand;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Kit;
use Nouma\Doubacore\Models\Warp;
use Nouma\Doubacore\Utils\ItemUtils;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\Position;

class HomeManager extends BaseManager
{
    use SingletonTrait;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct($plugin, "homes");
    }

    public function save($model)
    {
        /** @var \Nouma\Doubacore\Models\Home $model */
        $this->getConfig()->set($model->getKey()."name", $model->getName());
        $this->getConfig()->set($model->getKey()."x", $model->getPosition()->getX());
        $this->getConfig()->set($model->getKey()."y", $model->getPosition()->getY());
        $this->getConfig()->set($model->getKey()."z", $model->getPosition()->getZ());
        $this->getConfig()->set($model->getKey()."world", $model->getPosition()->getWorld()->getFolderName());
        try {
            $this->getConfig()->save();
        } catch (JsonException $e) {
            Doubacore::getInstance()->getLogger()->warning('Error in saving homes : ');
            var_dump($e);
        }
    }

    public function get(string $key): ?HomeCommand
    {
        $data = $this->deserializeArray($key);
        if ($data == null) return null;

        if (!array_key_exists("name", $data)) return null;
        $home = new \Nouma\Doubacore\Models\Home($key);
        $home->setName($data["name"]);

        $world = null;

        if (array_key_exists("world", $data))
            $world = Server::getInstance()->getWorldManager()->getWorldByName($data['world']);

        if ($world == null)
            Server::getInstance()->getWorldManager()->getDefaultWorld();

        $vector3 = [];
        foreach(['x', 'y', 'z'] as $vector) {
            if (!array_key_exists($vector, $data)) return null;
            $vector3[$vector] = $data[$vector];
        }

        $position = new Position($vector3['x'], $vector3['y'], $vector3['z'], $world);
        $home->setPosition($position);

        return $home;
    }

    public function getFromName(string $name): ?HomeCommand
    {
        foreach ($this->config->getAll() as $id => $array) {
            if (!isset($array['name'])) continue;
            if ($array['name'] == $name) return $this->get($id);
        }
        return null;
    }
}