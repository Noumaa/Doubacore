<?php

namespace Nouma\Doubacore\Api;

use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Utils\ItemUtils;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class KitManager
{

    private static Config $kits;

    public static function init(Doubacore $plugin): void
    {
        $plugin->saveResource("kits.yml");
        self::$kits = new Config($plugin->getDataFolder() . "kits.yml", Config::YAML);
    }

    public static function sendKit(Player $player, string $kitName): void
    {
        foreach (self::$kits->getAll() as $key => $kit) {
            if($key != $kitName) continue;

            foreach($kit["items"] as $itemString) {
                $item = ItemUtils::loadItem(...explode(":", $itemString));
                ItemUtils::addPlayerItemOrDrop($player, $item);
            }

            foreach (["helmet", "chestplate", "leggings", "boots"] as $armorPart)
                isset($kit["helmet"]) and ItemUtils::addPlayerItemOrDrop($player, ItemUtils::loadItem(...explode(":", $kit[$armorPart])));
        }
    }

    public static function getAll(): array
    {
        return self::$kits->getAll();
    }
}
