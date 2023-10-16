<?php

namespace Nouma\Doubacore\Commands\Home;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Managers\HomeManager;
use Nouma\Doubacore\Managers\WarpManager;
use Nouma\Doubacore\Models\Home;
use Nouma\Doubacore\Models\Warp;
use pocketmine\command\CommandSender;

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
        /** @var Home $home */
        $home = HomeManager::getInstance()->getFromName($args['home']);

        if ($home == null) {
            $sender->sendMessage("§cLe home §e{$args['home']} §cn'existe pas !");
            return;
        }

        HomeManager::getInstance()->remove($home->getKey());

        $sender->sendMessage("§2Le home §a{$args['home']} §2a été supprimé avec succès !");
    }
}