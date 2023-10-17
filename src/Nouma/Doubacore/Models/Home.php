<?php

namespace Nouma\Doubacore\Models;

use pocketmine\player\Player;
use pocketmine\world\Position;

class Home
{

    private string $name;
    private Position $position;

    public function __construct(string $name, Position $position)
    {
        $this->name = $name;
        $this->position = $position;
    }

    public function teleport(Player $player): void
    {
        $player->teleport($this->getPosition());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        !isset($this->name) && $this->name = $name;
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