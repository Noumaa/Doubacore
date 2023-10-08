<?php

namespace Nouma\Doubacore\Listeners;

use Nouma\Doubacore\Doubacore;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

class DamageListener implements Listener
{

    private Doubacore $plugin;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onDamage(EntityDamageEvent $event): void {
        if (!($event->getEntity() instanceof Player)) return;
        $session = $this->plugin->getSessionManager()->get($event->getEntity());

        if ($session->isGod()) $event->cancel();
    }
}