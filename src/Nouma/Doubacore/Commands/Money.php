<?php

namespace Nouma\Doubacore\Commands;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
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

class Money extends BaseCommand
{

    private Doubacore $doubacore;

    public function __construct(Doubacore $plugin)
    {
        parent::__construct(
            $plugin,
            "balance",
            Messages::CMD_BALANCE_DESCRIPTION(),
            ["/money", "/bal"]
        );
        $this->setPermission("doubacore.command.balance;doubacore.command.balance.self");
        $this->doubacore = $plugin;
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new TargetPlayerArgument(true));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args['player'])) {
            BedrockEconomyAPI::beta()->get($sender->getName())
                ->onCompletion(function ($balance) use ($sender) {
                    $sender->sendMessage("§6Solde : §e$$balance");
                }, fn() => true );

            return;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(Messages::ONLY_PLAYERS());
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args['player']);
        if ($player == null) {
            $sender->sendMessage(Messages::PLAYER_NOT_FOUND());
            return;
        }

        if (!$sender->hasPermission("doubacore.command.balance.other")) {
            $sender->sendMessage(Messages::NO_PERMISSION($aliasUsed, "doubacore.command.balance.other"));
            return;
        }

        BedrockEconomyAPI::beta()->get($player->getName())
            ->onCompletion(function ($balance) use ($player, $sender) {
                $sender->sendMessage("§6Solde de §e{$player->getName()} §6: §e$$balance");
            }, fn() => true );
    }
}