<?php

namespace Nouma\Doubacore\Managers;

use JsonException;
use Nouma\Doubacore\Commands\Home\HomeCommand;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Home;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\Position;

class HomeManager extends BaseManager
{
    use SingletonTrait;

    public function __construct(Doubacore $plugin, Player $player)
    {
        parent::__construct($plugin, "homes");
    }

    public function save($model)
    {
        /** @var Home $model */
        $this->getConfig()->setNested($model->getKey().".name", $model->getName());
        $this->getConfig()->setNested($model->getKey().".x", $model->getPosition()->getX());
        $this->getConfig()->setNested($model->getKey().".y", $model->getPosition()->getY());
        $this->getConfig()->setNested($model->getKey().".z", $model->getPosition()->getZ());
        $this->getConfig()->setNested($model->getKey().".world", $model->getPosition()->getWorld()->getFolderName());
        try {
            $this->getConfig()->save();
        } catch (JsonException $e) {
            Doubacore::getInstance()->getLogger()->warning('Error in saving homes : ');
            var_dump($e);
        }
    }

    public function get(string $key): ?Home
    {
        $data = $this->deserializeArray($key);
        if ($data == null) return null;

        if (!array_key_exists("name", $data)) return null;
        $home = new Home($key);
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
}