<?php

namespace Nouma\Doubacore\Commands;

use CortexPE\Commando\args\TargetPlayerArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use Nouma\Doubacore\Doubacore;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class HealCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "heal",
            "Soignez quelqu'un et nourrissez-le",
        );
        $this->setPermission("doubacore.command.heal;doubacore.command.heal.self;doubacore.command.heal.other");
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
                $sender->sendMessage('§cSeuls les joueurs peuvent se faire soigner !');
                return;
            }

            $sender->setHealth(20);
            $sender->getHungerManager()->setFood(20);
            $sender->getHungerManager()->setSaturation(20);
            $sender->sendMessage('§6Comme neuf !');
            return;
        }

        if (!$sender->hasPermission('doubacore.command.heal.other')) {
            $sender->sendMessage('§cVous n\'avez pas la permission !');
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args['player']);
        if ($player == null) {
            $sender->sendMessage('§cJoueur introuvable !');
            return;
        }

        $player->setHealth(20);
        $player->getHungerManager()->setFood(20);
        $player->getHungerManager()->setSaturation(20);

        $player->sendMessage("§e{$sender->getName()} §6vous a soigné !");
        $sender->sendMessage("§e{$player->getName()} §6a été soigné !");
    }
}