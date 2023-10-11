<?php

namespace Nouma\Doubacore\Models;

use pocketmine\player\Player;
use pocketmine\world\Position;

class Warp
{

    private string $key;
    private string $name;

    private Position $position;

    public function __construct(string $key = null)
    {
        $this->key = $key;
    }

    public function teleport(Player $player): void
    {
        $player->teleport($this->getPosition());
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): void
    {
        !isset($this->key) && $this->key = $key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

}