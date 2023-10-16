<?php

namespace Nouma\Doubacore\Commands;

use CortexPE\Commando\args\TargetPlayerArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use Nouma\Doubacore\Doubacore;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class GodCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "god",
            "Rendez quelqu'un invincible",
        );
        $this->setPermission("doubacore.command.god;doubacore.command.god.self;doubacore.command.god.other");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new TargetPlayerArgument(true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args['player'])) {
            if (!($sender instanceof Player)) {
                $sender->sendMessage('§cSeuls les joueurs peuvent être invincible !');
                return;
            }

            $session = $this->doubacore->getSessionManager()->get($sender);

            $session->setGod(!$session->isGod());
            $sender->sendMessage($session->isGod() ? '§6Vous êtes désormais invincible.' : '§6Vous êtes désormais vulnérable.');
            return;
        }

        if (!$sender->hasPermission('doubacore.command.god.other')) {
            $sender->sendMessage('§cVous n\'avez pas la permission !');
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args['player']);
        if ($player == null) {
            $sender->sendMessage('§cJoueur introuvable !');
            return;
        }

        $session = $this->doubacore->getSessionManager()->get($player);
        $session->setGod(!$session->isGod());

        $player->sendMessage($session->isGod() ? "§e{$sender->getName()} §6vous a rendu invincible." : "§e{$sender->getName()} §6vous a rendu vulnérable.");
        $sender->sendMessage($session->isGod() ? "§e{$player->getName()} §6est désormais invincible." : "§e{$player->getName()} §6est désormais vulnérable.");
    }
}