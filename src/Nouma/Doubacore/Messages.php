<?php

namespace Nouma\Doubacore;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Messages
{

    private static Doubacore $plugin;
    private static Config $config;

    public static function init(Doubacore $plugin): void
    {
        $locale = Doubacore::getLocale();
        $file = $plugin->getDataFolder() . "/messages/$locale.yml";
        $plugin->saveResource("messages/$locale.yml");

        self::$plugin = $plugin;
        self::$config = new Config($file);
    }

    public static function get(string $nestKey): mixed {
        return self::$config->getNested($nestKey, $nestKey);
    }

    public static function NO_PERMISSION(string $commandLabel, string $permission): string
    {
        $message = self::get("no_permission");
        return str_replace("{command_label}", $commandLabel,
               str_replace("{permission}", $permission,
               $message)
        );
    }

    public static function ONLY_PLAYERS()
    {
        return self::get("only_players");
    }

    public static function PLAYER_NOT_FOUND()
    {
        return self::get("player_not_found");
    }

    public static function CMD_BALANCE_DESCRIPTION(): string
    {
        return self::get("commands.balance.description");
    }
}