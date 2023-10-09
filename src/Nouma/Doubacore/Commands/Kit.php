<?php

namespace Nouma\Doubacore\Commands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Api\KitManager;
use Nouma\Doubacore\Doubacore;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class Kit extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "kit",
            "Récupérer un kit",
        );
        $this->setPermission("doubacore.command.kit;doubacore.command.kit.list");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("kit", true));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args['kit'])) {
            if (count(KitManager::getAll()) == 0) {
                $sender->sendMessage("§6Aucun kit disponible.");
                return;
            }

            $sender->sendMessage("§6Liste des kits :");
            foreach (KitManager::getAll() as $key => $kit) {
                $sender->sendMessage(" §6- §e{$key}§6: §e{$kit["name"]}");
            }
            return;
        }

        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cSeuls les joueurs peuvent récupérer un kit !");
            return;
        }

        if (!key_exists($args['kit'], KitManager::getAll())) {
            $sender->sendMessage("§cLe kit n'existe pas !");
            return;
        }

        if (!$sender->hasPermission("doubacore.command.kit.*") && !$sender->hasPermission("doubacore.command.kit.{$args['kit']}")) {
            $sender->sendMessage("§cVous n'avez pas la permission !");
            return;
        }

        KitManager::sendKit($sender, $args['kit']);
        $sender->sendMessage("§2Le kit §a{$args['kit']} §2a été réclamé avec succès !");
    }
}