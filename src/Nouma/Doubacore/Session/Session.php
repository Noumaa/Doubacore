<?php

namespace Nouma\Doubacore\Session;

use JsonException;
use Nouma\Doubacore\Doubacore;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Session
{

    private Player $player;
    private Config $config;

    private bool $isGod = false;

    public function __construct(Player $player)
    {
        if (!is_dir(Doubacore::getInstance()->getDataFolder() . "users/"))
            mkdir(Doubacore::getInstance()->getDataFolder() . "users/");

        $this->player = $player;
        $this->config = new Config(Doubacore::getInstance()->getDataFolder() . "users/{$player->getName()}.yml", Config::YAML);
    }

    /**
     * @throws JsonException
     */
    public function save(): void {
        if (count($this->config->getAll()) == 0)
            Doubacore::getInstance()->saveResource("users/{$this->player->getName()}.yml");

        $this->config->save();
    }

    public function setGod(bool $isGod): void
    {
        $this->isGod = $isGod;
    }

    public function isGod(): bool {
        return $this->isGod;
    }
}