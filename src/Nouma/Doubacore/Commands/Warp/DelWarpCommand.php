<?php

namespace Nouma\Doubacore\Commands\Warp;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Managers\WarpManager;
use Nouma\Doubacore\Models\Warp;
use pocketmine\command\CommandSender;

class DelWarpCommand extends BaseCommand
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
        /** @var Warp $warp $warp */
        $warp = WarpManager::getInstance()->getFromName($args['warp']);

        if ($warp == null) {
            $sender->sendMessage("§cLe warp §e{$args['warp']} §cn'existe pas !");
            return;
        }

        WarpManager::getInstance()->remove($warp->getKey());

        $sender->sendMessage("§2Le warp §a{$args['warp']} §2a été supprimé avec succès !");
    }
}