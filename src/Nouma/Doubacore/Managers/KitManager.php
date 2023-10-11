<?php

namespace Nouma\Doubacore\Managers;

use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Kit;
use Nouma\Doubacore\Utils\ItemUtils;
use pocketmine\utils\SingletonTrait;

class KitManager extends BaseManager
{
    use SingletonTrait;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct($plugin, "kits");
    }

    public function save($model)
    {
        // TODO: Implement serialize() method.
    }

    public function get(string $key): ?Kit
    {
        $data = $this->deserializeArray($key);
        if ($data == null) return null;

        $kit = new Kit($key);

        key_exists("name", $data) && $kit->setName($data["name"]);

        if (!key_exists("items", $data)) return null;
        foreach($data["items"] as $itemString) {
            $item = ItemUtils::loadItem(...explode(":", $itemString));
            $kit->addItem($item);
        }

        foreach (["helmet", "chestplate", "leggings", "boots"] as $armorPart)
        {
            if (!key_exists($armorPart, $data)) continue;

            $item = ItemUtils::loadItem(...explode(":", $data["$armorPart"]));
            $method = "set" . strtoupper($armorPart[0]) . strtolower(substr($armorPart, 1));
            $kit->$method($item);
        }

        return $kit;
    }
}