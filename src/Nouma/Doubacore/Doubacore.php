<?php

namespace Nouma\Doubacore;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use Nouma\Doubacore\Api\Warp\WarpManager;
use Nouma\Doubacore\Commands\God;
use Nouma\Doubacore\Commands\Heal;
use Nouma\Doubacore\Commands\Warp\DelWarp;
use Nouma\Doubacore\Commands\Warp\SetWarp;
use Nouma\Doubacore\Commands\Warp\Warp;
use Nouma\Doubacore\Listeners\DamageListener;
use Nouma\Doubacore\Listeners\SessionListener;
use Nouma\Doubacore\Session\SessionManager;
use pocketmine\plugin\PluginBase;

class Doubacore extends PluginBase
{

    private SessionManager $sessionManager;

    /**
     * @throws HookAlreadyRegistered
     */
    protected function onEnable(): void
    {
        $this->sessionManager = new SessionManager($this);

        WarpManager::init($this);

        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }

        $this->getServer()->getCommandMap()->register("Doubacore", new Heal($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new God($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new SetWarp($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new DelWarp($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new Warp($this));

        $this->getServer()->getPluginManager()->registerEvents(new SessionListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DamageListener($this), $this);
    }

    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }
}