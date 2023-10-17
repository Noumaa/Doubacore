<?php

namespace Nouma\Doubacore\Listeners;

use JsonException;
use Nouma\Doubacore\Doubacore;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class SessionListener implements Listener
{

    private Doubacore $plugin;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
    }

    /**
     * @throws JsonException
     */
    public function onPlayerQuit(PlayerQuitEvent $event): void {
        $this->plugin->getSessionManager()->save($event->getPlayer());
    }
}