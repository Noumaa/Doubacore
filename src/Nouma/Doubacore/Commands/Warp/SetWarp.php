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

class SetWarp extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "setwarp",
            "Créer un warp à l'endroit où vous êtes",
        );
        $this->setPermission("doubacore.command.setwarp");
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
        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cSeuls les joueurs peuvent créer un warp !");
            return;
        }

        WarpManager::setWarp($args['warp'], $sender->getPosition());
        $sender->sendMessage("§6Le warp §e{$args['warp']} §6a été créé avec succès.");
    }
}