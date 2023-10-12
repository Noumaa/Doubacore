<?php

namespace Nouma\Doubacore\Listeners;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use Exception;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Messages;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;

class PlayerListener implements Listener {

    private Doubacore $plugin;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();

        $join = $this->plugin->getConfig()->getNested("chat.join_message");
        if ($join != "none") {
            $event->setJoinMessage(
                str_replace("{player}", $player->getName(),
                    $this->plugin->getConfig()->getNested("chat.join_message")
                ));
        }

        $welcome = $this->plugin->getConfig()->getNested("chat.welcome_message");
        if ($welcome != "none") {
            if (!$player->hasPlayedBefore())
                Server::getInstance()->broadcastMessage(
                    str_replace(
                        "{player}", $player->getName(),
                        $this->plugin->getConfig()->getNested("chat.welcome_message")
                    )
                );
        }
    }

    /**
     * @throws Exception
     */
    public function onQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();

        $quit = $this->plugin->getConfig()->getNested("chat.quit_message");
        if ($quit != "none") {
            $event->setQuitMessage(
                str_replace(
                "{player}", $player->getName(),
                        $this->plugin->getConfig()->getNested("chat.quit_message")
                )
            );
        }

        $this->plugin->getSessionManager()->get($player)->save();
    }
}