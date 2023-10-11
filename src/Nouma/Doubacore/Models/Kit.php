<?php

namespace Nouma\Doubacore\Models;

use pocketmine\item\Item;

class Kit
{

    private string $key;
    private string $name;

    /** @var Item[] */
    private array $items;

    private Item $helmet;
    private Item $chestplate;
    private Item $leggings;
    private Item $boots;

    public function __construct(string $key = null)
    {
        $this->key = $key;
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

    public function getHelmet(): Item
    {
        return $this->helmet;
    }

    public function setHelmet(Item $helmet): void
    {
        $this->helmet = $helmet;
    }

    public function getChestplate(): Item
    {
        return $this->chestplate;
    }

    public function setChestplate(Item $chestplate): void
    {
        $this->chestplate = $chestplate;
    }

    public function getLeggings(): Item
    {
        return $this->leggings;
    }

    public function setLeggings(Item $leggings): void
    {
        $this->leggings = $leggings;
    }

    public function getBoots(): Item
    {
        return $this->boots;
    }

    public function setBoots(Item $boots): void
    {
        $this->boots = $boots;
    }
}