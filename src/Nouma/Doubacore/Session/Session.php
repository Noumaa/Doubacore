<?php

namespace Nouma\Doubacore\Session;

use JsonException;
use Nouma\Doubacore\Doubacore;
use Nouma\Doubacore\Models\Home;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class Session
{

    private Player $player;
    private Config $config;

    /** @var Home[] $homes */
    private array $homes;
    private bool $isGod;

    public function __construct(Player $player)
    {
        if (!is_dir(Doubacore::getInstance()->getDataFolder() . "users/"))
            mkdir(Doubacore::getInstance()->getDataFolder() . "users/");

        Doubacore::getInstance()->saveResource("users/{$player->getName()}.json");

        $this->player = $player;
        $this->config = new Config(Doubacore::getInstance()->getDataFolder() . "users/{$player->getName()}.json", Config::JSON);

        $this->parse();
    }

    private function parse(): void
    {
        $this->isGod = $this->config->getNested("is_god", false);

        $this->homes = [];
        foreach ($this->config->getNested("homes", []) as $name => $dataHome) {
            if (!key_exists('position', $dataHome)) continue;
            $this->setHome(new Home($name, $this->parsePosition($dataHome['position'])));
        }
    }

    private function parsePosition(array $dataPosition): Position
    {
        return new Position(
            $dataPosition['x'],
            $dataPosition['y'],
            $dataPosition['z'],
            Server::getInstance()->getWorldManager()->getWorldByName($dataPosition['world'])
        );
    }

    /**
     * @throws JsonException
     */
    public function save(): void {
        $this->config->setNested("is_god", $this->isGod);

        $homeData = [];
        foreach ($this->getHomes() as $home) {
            $homeData[$home->getName()] = [
                "position" => [
                    "x" => $home->getPosition()->getX(),
                    "y" => $home->getPosition()->getY(),
                    "z" => $home->getPosition()->getZ(),
                    "world" => $home->getPosition()->getWorld()->getFolderName(),
                ]
            ];
        }

        $this->config->setNested("homes", $homeData);

        $this->config->save();
    }

    public function setGod(bool $isGod): void
    {
        $this->isGod = $isGod;
    }

    public function isGod(): bool {
        return $this->isGod;
    }

    /** @return Home[] */
    public function getHomes(): array
    {
        $homes = [];
        foreach ($this->homes as $name => $home) {
            if (isset($this->homes[$home->getName()]))
                $homes[] = $this->homes[$home->getName()];
        }
        return $homes;
    }

    public function setHomes(array $homes): void
    {
        foreach ($homes as $home) {
            $this->homes[$home->getName()] = $home;
        }
    }

    public function getHome(string $name): ?Home
    {
        return $this->homes[$name] ?? null;
    }

    public function setHome(Home $home): void
    {
        $this->homes[$home->getName()] = $home;
    }

    public function removeHome(Home $home): void
    {
        unset($this->homes[$home->getName()]);
    }
}