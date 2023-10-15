<?php

namespace Nouma\Doubacore\Commands;

use CortexPE\Commando\args\FloatArgument;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\args\TargetPlayerArgument;
use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use Nouma\Doubacore\Managers\KitManager;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Messages;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class Speed extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "speed",
            Messages::get("commands.speed.description")
        );
        $this->setPermission("doubacore.command.speed;doubacore.command.speed.self");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new FloatArgument("speed", false));
        $this->registerArgument(1, new TargetPlayerArgument(true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $speed = (float) $args['speed'];

        if (isset($args['player'])) {
            if (!$sender->hasPermission("doubacore.command.speed.other")) {
                Messages::NO_PERMISSION($aliasUsed, "doubacore.command.speed.other");
                return;
            }

            $target = Server::getInstance()->getPlayerExact($args['player']);
            if ($target == null) {
                Messages::PLAYER_NOT_FOUND();
                return;
            }

            $target->sendMessage(str_replace("{player}", $sender->getName(), Messages::get("commands.speed.set-speed.target")));
            $target->sendMessage(str_replace("{speed}", $speed, Messages::get("commands.speed.set-speed.player")));
            $target->setMovementSpeed($speed / 10, true);
            return;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(Messages::ONLY_PLAYERS());
            return;
        }

        $sender->sendMessage(str_replace("{speed}", $speed, Messages::get("commands.speed.set-speed.player")));
        $sender->setMovementSpeed($speed / 10, true);
    }
}