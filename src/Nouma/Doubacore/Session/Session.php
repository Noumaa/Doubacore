<?php

namespace Nouma\Doubacore\Session;

use pocketmine\player\Player;

class Session
{

    private Player $player;

    private bool $isGod;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->isGod = false;
    }

    public function setGod(bool $isGod): void
    {
        $this->isGod = $isGod;
    }

    public function isGod(): bool {
        return $this->isGod;
    }
}