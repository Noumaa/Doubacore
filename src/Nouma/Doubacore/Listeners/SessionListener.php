<?php

namespace Nouma\Doubacore\Listeners;

use Nouma\Doubacore\Doubacore;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class SessionListener implements Listener
{

    private Doubacore $plugin;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $this->plugin->getSessionManager()->load($event->getPlayer());
    }
}