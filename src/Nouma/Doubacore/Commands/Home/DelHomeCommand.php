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
use Nouma\Doubacore\Models\Home;
use Nouma\Doubacore\Models\Warp;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class DelHomeCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "delhome",
            "Supprime un home.",
        );
        $this->setPermission("doubacore.command.delhome");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(Messages::ONLY_PLAYERS());
            return;
        }

        if (!isset($args['home'])) $args['home'] = 'home';

        $session = $this->doubacore->getSessionManager()->get($sender);

        $home = $session->getHome($args["home"]);
        $session->removeHome($home);

        $sender->sendMessage("§2Point de home §a{$home->getName()} §2a été supprimé avec succès !");
    }
}