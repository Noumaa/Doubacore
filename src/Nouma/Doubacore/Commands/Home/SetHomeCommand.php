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
use Nouma\Doubacore\Session\SessionManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Ramsey\Uuid\Uuid;

class SetHomeCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "sethome",
            "Créer un home à l'endroit où vous êtes",
        );
        $this->setPermission("doubacore.command.sethome");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("home", true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(Messages::ONLY_PLAYERS());
            return;
        }

        if (!isset($args['home'])) $args['home'] = 'home';

        $session = $this->doubacore->getSessionManager()->get($sender);

        $home = new Home($args['home'], $sender->getPosition());
        $session->setHome($home);

        $sender->sendMessage("§2Point de home §a{$home->getName()} §2a été définis avec succès !");
    }
}