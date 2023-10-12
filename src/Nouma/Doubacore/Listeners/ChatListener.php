<?php

namespace Nouma\Doubacore\Listeners;

use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Messages;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\lang\Translatable;
use pocketmine\player\chat\ChatFormatter;
use pocketmine\player\Player;

class ChatListener implements Listener
{

    private Doubacore $plugin;

    public function __construct(Doubacore $plugin)
    {
        $this->plugin = $plugin;
    }

    /*
     * @priority HIGHEST
     */
    public function onChat(PlayerChatEvent $event): void {
        if (strtolower(Doubacore::getInstance()->getConfig()->getNested("chat.format", "none")) == "none") return;

        $event->setFormatter(new class implements ChatFormatter {
            public function format(string $username, string $message): Translatable|string
            {
                $format = Doubacore::getInstance()->getConfig()->getNested("chat.format");
                return str_replace("{message}", $message,
                       str_replace("{player}", $username, $format));
            }
        });
    }
}