<?php

namespace Nouma\Doubacore\Managers;

use JsonException;
use Nouma\Doubacore\Doubacore;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class WarpManager
{

    private static array $warps = [];
    private static Config $config;

    public static function init(Doubacore $plugin): void
    {
        $plugin->saveResource("warps.json");
        $config = new Config($plugin->getDataFolder() . "warps.json", Config::JSON);
        self::$config = $config;
        self::$warps = $config->getAll();
    }

    public static function getWarp(string $warpName): ?Position
    {
        if (isset(self::$warps[$warpName])) {
            $warpData = self::$warps[$warpName];
            return new Position($warpData["x"], $warpData["y"], $warpData["z"], Server::getInstance()->getWorldManager()->getWorldByName($warpData["level"]));
        } else {
            return null;
        }
    }

    public static function getAllWarps(): array {
        return self::$warps;
    }

    /**
     * @throws JsonException
     */
    public static function setWarp(string $warpName, Position $position): void
    {
        self::$warps[$warpName] = [
            "x" => $position->x,
            "y" => $position->y,
            "z" => $position->z,
            "level" => $position->getWorld()->getFolderName()
        ];
        self::$config->set($warpName, self::$warps[$warpName]);
        self::$config->save();
    }

    /**
     * @throws JsonException
     */
    public static function removeWarp(string $warpName): void
    {
        if (isset(self::$warps[$warpName])) {
            unset(self::$warps[$warpName]);
            self::$config->remove($warpName);
            self::$config->save();
        }
    }
}
