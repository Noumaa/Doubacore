<?php

namespace Nouma\Doubacore\Session;

use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Exceptions\SessionNotFoundException;
use pocketmine\player\Player;

class SessionManager
{

    private Doubacore $plugin;
    private array $sessions;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
        $this->sessions = [];
    }

    public function load(Player $player): void {
        $session = new Session($player);
        $this->sessions[$player->getName()] = $session;
    }

    /**
     * @throws JsonException
     */
    public function save(Player $player): void {
        $session = $this->get($player);
        $session->save();
        unset($this->sessions[$player->getName()]);
    }

    public function get(Player $player): Session {
        if (!key_exists($player->getName(), $this->sessions)) $this->load($player);
        return $this->sessions[$player->getName()];
    }
}