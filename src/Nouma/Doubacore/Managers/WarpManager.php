<?php

namespace Nouma\Doubacore\Managers;

use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Kit;
use Nouma\Doubacore\Models\Warp;
use Nouma\Doubacore\Utils\ItemUtils;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\Position;

class WarpManager extends BaseManager
{
    use SingletonTrait;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct($plugin, "warps");
    }

    public function save($model)
    {
        // TODO: Implement serialize() method.
    }

    public function get(string $key): ?Warp
    {
        $data = $this->deserializeArray($key);
        if ($data == null) return null;

        if (!array_key_exists("name", $data)) return null;
        $warp = new Warp($key);
        $warp->setName($data["name"]);

        $world = null;
        Server::getInstance()->getPluginManager()->getPlugin();

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
        $warp->setPosition($position);

        return $warp;
    }
}