<?php

namespace Nouma\Doubacore\Commands\Warp;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Managers\WarpManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Warp extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "warp",
            "Téléportez-vous au warp désigné",
        );
        $this->setPermission("doubacore.command.warp;doubacore.command.warp.list");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("warp", true));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args['warp'])) {
            if (count(WarpManager::getAllWarps()) == 0) {
                $sender->sendMessage("§6Aucun warp disponible.");
                return;
            }

            $sender->sendMessage("§6Liste des warps :");
            foreach (WarpManager::getAllWarps() as $name => $data) {
                $position = WarpManager::getWarp($name);
                $sender->sendMessage(" §6- §e{$name}§6: §e$position");
            }
            return;
        }

        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cSeuls les joueurs peuvent se téléporter !");
            return;
        }

        $warp = WarpManager::getWarp($args['warp']);
        if ($warp == null) {
            $sender->sendMessage("§cLe warp n'existe pas !");
            return;
        }

        if (!$sender->hasPermission("doubacore.command.warp.*") && !$sender->hasPermission("doubacore.command.warp.{$args['warp']}")) {
            $sender->sendMessage("§cVous n'avez pas la permission !");
            return;
        }

        $sender->teleport($warp);
        $sender->sendMessage("§6Pouf !");
    }
}