<?php

namespace Nouma\Doubacore\Commands\Home;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Managers\HomeManager;
use Nouma\Doubacore\Managers\WarpManager;
use Nouma\Doubacore\Messages;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class HomeCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "home",
            "Téléportez-vous au home désigné",
            ['homes']
        );
        $this->setPermission("doubacore.command.home");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home", true));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(Messages::ONLY_PLAYERS());
            return;
        }

        if ($aliasUsed == "homes") {
            $sender->sendMessage("§6Liste des homes :");

            foreach (HomeManager::getInstance()->getAll() as $home)
                $sender->sendMessage(" §6- §e{$home->getName()}");
            return;
        }

        $home = HomeManager::getInstance()->getFromName('home');
        if (isset($args['home']))
            $home = HomeManager::getInstance()->getFromName($args['home']);

        if ($home == null) {
            $sender->sendMessage("§cLe home n'existe pas, essayez plutôt :");
            Server::getInstance()->dispatchCommand($sender, "homes");
            return;
        }

        $home->teleport($sender);
        $sender->sendMessage("§6Pouf !");
    }
}