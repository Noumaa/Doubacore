<?php

namespace Nouma\Doubacore;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Messages
{

    private Doubacore $plugin;
    private Config $config;

    public function __construct(Doubacore $plugin)
    {
        $locale = Doubacore::getLocale();
        $file = $plugin->getDataFolder() . "/messages/$locale.yml";
        $plugin->saveResource("messages/$locale.yml");

        $this->plugin = $plugin;
        $this->config = new Config($file, Config::YAML);
    }

    public static function get(string $nestKey): mixed {
        $locale = Doubacore::getLocale();
        $file = "messages/$locale.yml";

        Doubacore::getInstance()->saveResource($file);
        $config = new Config($file);

        return $config->getNested($nestKey, $nestKey);
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