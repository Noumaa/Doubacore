<?php

namespace Nouma\Doubacore\Models;

use Nouma\Doubacore\Utils\ItemUtils;
use Nouma\NORM\IModel;
use pocketmine\item\Item;
use pocketmine\player\Player;

class Kit implements IModel
{

    private string $key;
    private string $name;

    /** @var Item[] */
    private array $items;

    private ?Item $helmet = null;
    private ?Item $chestplate = null;
    private ?Item $leggings = null;
    private ?Item $boots = null;

    public function __construct(string $key = null)
    {
        $this->key = $key;
    }

    public function sendKit(Player $player, Kit $kit): void
    {
        foreach($kit->getItems() as $items)
            ItemUtils::addItemOrDrop($player, $items);

        foreach (["Helmet", "Chestplate", "Leggings", "Boots"] as $armorPart)
        {
            $getArmorPart = "get" . $armorPart;
            $kit->$getArmorPart() != null && ItemUtils::addItemOrDrop($player, $kit->$getArmorPart());
        }
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): void
    {
        !isset($this->key) && $this->key = $key;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getHelmet(): ?Item
    {
        return $this->helmet;
    }

    public function setHelmet(Item $helmet): void
    {
        $this->helmet = $helmet;
    }

    public function getChestplate(): ?Item
    {
        return $this->chestplate;
    }

    public function setChestplate(Item $chestplate): void
    {
        $this->chestplate = $chestplate;
    }

    public function getLeggings(): ?Item
    {
        return $this->leggings;
    }

    public function setLeggings(Item $leggings): void
    {
        $this->leggings = $leggings;
    }

    public function getBoots(): ?Item
    {
        return $this->boots;
    }

    public function setBoots(Item $boots): void
    {
        $this->boots = $boots;
    }

    public function getTableName(): string
    {
        return "kit";
    }
}