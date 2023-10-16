<?php

namespace Nouma\Doubacore\Commands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Managers\KitManager;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Messages;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class KitCommand extends BaseCommand
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
            if (count(KitManager::getInstance()->getAll()) == 0) {
                $sender->sendMessage("§6Aucun kit disponible.");
                return;
            }

            $sender->sendMessage("§6Liste des kits :");
            foreach (KitManager::getInstance()->getAll() as $kit) {
                /** @var \Nouma\Doubacore\Models\Kit $kit */
                $sender->sendMessage(" §6- §e{$kit->getKey()}§6: §e{$kit->getName()}");
            }
            return;
        }

        if (!($sender instanceof Player)) {
            $sender->sendMessage("§cSeuls les joueurs peuvent récupérer un kit !");
            return;
        }

        $kit = KitManager::getInstance()->get($args['kit']);
        if ($kit == null) {
            $sender->sendMessage("§cLe kit n'existe pas !");
            return;
        }

        if (!$sender->hasPermission("doubacore.command.kit.*") && !$sender->hasPermission("doubacore.command.kit.{$kit->getKey()}")) {
            $sender->sendMessage(Messages::NO_PERMISSION($aliasUsed, "doubacore.command.kit.{$kit->getKey()}"));
            return;
        }

        $kit->sendKit($sender, $kit);
        $sender->sendMessage("§2Le kit §a{$kit->getName()} §2a été réclamé avec succès !");
    }
}