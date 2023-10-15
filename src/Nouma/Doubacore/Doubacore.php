<?php

namespace Nouma\Doubacore;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use Nouma\Doubacore\Commands\God;
use Nouma\Doubacore\Commands\Heal;
use Nouma\Doubacore\Commands\Kit;
use Nouma\Doubacore\Commands\Speed;
use Nouma\Doubacore\Commands\Warp\DelWarp;
use Nouma\Doubacore\Commands\Warp\SetWarp;
use Nouma\Doubacore\Commands\Warp\Warp;
use Nouma\Doubacore\Listeners\ChatListener;
use Nouma\Doubacore\Listeners\DamageListener;
use Nouma\Doubacore\Listeners\SessionListener;
use Nouma\Doubacore\Managers\KitManager;
use Nouma\Doubacore\Managers\WarpManager;
use Nouma\Doubacore\Session\SessionManager;
use pocketmine\plugin\PluginBase;

class Doubacore extends PluginBase
{

    private static Doubacore $instance;

    public static function getInstance() : self
    {
        return self::$instance;
    }

    public static function getLocale(): string
    {
        return strtolower(self::getInstance()->getConfig()->getNested("language", "fra"));
    }

    private SessionManager $sessionManager;

    /**
     * @throws HookAlreadyRegistered
     */
    protected function onEnable(): void
    {
        self::$instance = $this;

        $this->saveDefaultConfig();
        Messages::init($this);

        $this->sessionManager = new SessionManager($this);
        WarpManager::setInstance(new WarpManager($this));
        KitManager::setInstance(new KitManager($this));

        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }

        $this->getServer()->getCommandMap()->register("Doubacore", new Heal($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new God($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new Speed($this));

        $this->getServer()->getCommandMap()->register("Doubacore", new SetWarp($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new DelWarp($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new Warp($this));

        $this->getServer()->getCommandMap()->register("Doubacore", new Kit($this));

        $this->getServer()->getPluginManager()->registerEvents(new SessionListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DamageListener($this), $this);
    }

    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }
}