<?php

namespace Nouma\Doubacore\Utils;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\StringToItemParser;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class ItemUtils
{

    public static function addItemOrDrop(Player $player, Item $item): void
    {
        $inventory = $player->getInventory();
        $position = $player->getPosition();
        $world = $position->getWorld();

        $inventory->canAddItem($item) ? $inventory->addItem($item) : $world->dropItem($position, $item);
    }

    public static function loadItem(string $itemName, int $amount, string $name = "default", ...$enchantments): Item|ItemBlock
    {
        $item = StringToItemParser::getInstance()->parse($itemName);
        if ($item === null) {
            $item = VanillaItems::AIR();
        }
        $item->setCount($amount);
        if(strtolower($name) !== "default"){
            $item->setCustomName($name);
        }
        $enchantment = null;
        foreach($enchantments as $key => $name_level){
            if($key % 2 === 0) { //Name expected
                $enchantment = StringToEnchantmentParser::getInstance()->parse((string)$name_level);
            }elseif($enchantment !== null){
                $item->addEnchantment(new EnchantmentInstance($enchantment, (int)$name_level));
            }
        }

        return $item;
    }

    public static function saveItem(Item $item): string
    {
        $vanillaName = $item->getVanillaName();
        $count = $item->getCount();
        $customName = $item->getCustomName();
        $enchantments = "";
        foreach ($item->getEnchantments() as $enchant) {
            if ($enchantments != "") $enchantments .= ":";
            $enchantments .= $enchant->getType()->getName()->getText() . ':' . $enchant->getLevel();
        }
        return "$vanillaName:$count:$customName:$enchantments";
    }
}