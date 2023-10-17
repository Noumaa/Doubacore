<?php

namespace Nouma\Doubacore\Models;

use DateInterval;
use DateTime;
use Exception;
use Nouma\Doubacore\Doubacore;
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

    /**
     * @throws Exception
     */
    public function teleport(Player $player): void
    {
        $session = Doubacore::getInstance()->getSessionManager()->get($player);
        $cooldowns = $session->getCooldowns();

        if (key_exists("home", $cooldowns)) {
            $cooldown = $session->getCooldowns()["home"];

            $duration = Doubacore::getInstance()->getConfig()->getNested("teleportation.cooldown");
            if (date_diff(new DateTime(), new DateTime($cooldown)) < new DateInterval("{$duration}S")) {
                $player->sendMessage("cooldown");
                return;
            }
        }

        $cooldowns["home"] = date_default_timezone_get();
        $session->setCooldowns($cooldowns);

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