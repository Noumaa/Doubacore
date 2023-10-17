<?php

namespace Nouma\Doubacore;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use Nouma\Doubacore\Commands\GodCommand;
use Nouma\Doubacore\Commands\HealCommand;
use Nouma\Doubacore\Commands\Home\DelHomeCommand;
use Nouma\Doubacore\Commands\Home\HomeCommand;
use Nouma\Doubacore\Commands\Home\SetHomeCommand;
use Nouma\Doubacore\Commands\KitCommand;
use Nouma\Doubacore\Commands\SpeedCommand;
use Nouma\Doubacore\Commands\Warp\DelWarpCommand;
use Nouma\Doubacore\Commands\Warp\SetWarpCommand;
use Nouma\Doubacore\Commands\Warp\WarpCommand;
use Nouma\Doubacore\Listeners\ChatListener;
use Nouma\Doubacore\Listeners\DamageListener;
use Nouma\Doubacore\Listeners\SessionListener;
use Nouma\Doubacore\Managers\HomeManager;
use Nouma\Doubacore\Managers\KitManager;
use Nouma\Doubacore\Managers\WarpManager;
use Nouma\Doubacore\Session\SessionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Doubacore extends PluginBase
{
    use SingletonTrait;

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
        self::setInstance($this);

        $this->saveDefaultConfig();
        Messages::init($this);

        $this->sessionManager = new SessionManager($this);
        WarpManager::setInstance(new WarpManager($this));
        KitManager::setInstance(new KitManager($this));

        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }

        $this->getServer()->getCommandMap()->register("Doubacore", new HealCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new GodCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new SpeedCommand($this));

        $this->getServer()->getCommandMap()->register("Doubacore", new KitCommand($this));

        $this->getServer()->getCommandMap()->register("Doubacore", new SetWarpCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new DelWarpCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new WarpCommand($this));

        $this->getServer()->getCommandMap()->register("Doubacore", new SetHomeCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new DelHomeCommand($this));
        $this->getServer()->getCommandMap()->register("Doubacore", new HomeCommand($this));

        $this->getServer()->getPluginManager()->registerEvents(new SessionListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DamageListener($this), $this);
    }

    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }
}