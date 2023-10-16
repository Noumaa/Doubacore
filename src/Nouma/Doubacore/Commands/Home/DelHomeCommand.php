<?php

namespace Nouma\Doubacore\Commands\Home;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Managers\WarpManager;
use pocketmine\command\CommandSender;

class DelHomeCommand extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "delwarp",
            "Supprime un warp",
        );
        $this->setPermission("doubacore.command.delwarp");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("warp"));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (WarpManager::getWarp($args['warp']) == null) {
            $sender->sendMessage("§cLe warp §e{$args['warp']} §cn'existe pas !");
            return;
        }

        WarpManager::removeWarp($args['warp']);
        $sender->sendMessage("§6Le warp §e{$args['warp']} §6a été supprimé avec succès.");
    }
}