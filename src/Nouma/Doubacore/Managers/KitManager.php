<?php

namespace Nouma\Doubacore\Managers;

use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Kit;
use Nouma\Doubacore\Utils\ItemUtils;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class KitManager extends BaseManager
{
    use SingletonTrait;

    public static function init(Doubacore $plugin)
    {
        self::setInstance(new self($plugin));
    }

    public function __construct(Doubacore $plugin)
    {
        parent::__construct($plugin, "kits");
    }

    public function save($model)
    {
        // TODO: Implement serialize() method.
    }

    public function get(string $key): Kit
    {
        $data = $this->deserializeArray($key);
        $kit = new Kit($key);

        key_exists("name", $data) && $kit->setName($data["name"]);

        foreach($data["items"] as $itemString) {
            $item = ItemUtils::loadItem(...explode(":", $itemString));
            $kit->addItem($item);
        }

        foreach (["helmet", "chestplate", "leggings", "boots"] as $armorPart)
        {
            $item = ItemUtils::loadItem(...explode(":", $data["$armorPart"]));
            $method = "set" . strtoupper($armorPart[0]) . strtolower(substr($armorPart, 1));
            $kit->$method($item);
        }

        return $kit;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }
}