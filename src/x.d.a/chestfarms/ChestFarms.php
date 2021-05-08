<?php

namespace glyphs31\chestfarms;

use pocketmine\block\Block;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\tile\Chest;

class ChestFarms extends PluginBase implements Listener{
    
    public function onEnable() : void{
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    /** 
    * @param PlayerInteractEvent $event
    */
    public function onInteract(PlayerInteractEvent $event) : void{
        $item = $event->getItem();
        $block = $event->getBlock();
        $player = $event->getPlayer();
        if($block->getId() === 146){
            $chest = $block->level->getTile(new Vector3($block->x, $block->y, $block->z));
            $this->getScheduler()->scheduleDelayedTask(new ClosureTask(
            function(int $currentTick) use ($block, $chest, $player) : void{
                    $this->addBlock($block, $chest);
                    $player->sendPopup("§aTu as mis toute les plantes dans le coffres!");
                }
            ), 20);
        }
    }

    private function addBlock(Block $blocks, Chest $chest){
        $minX = $blocks->x - 3;
        $maxX = $blocks->x + 9;
        $minZ = $blocks->z - 3;
        $maxZ = $blocks->z + 9;
        for($x = $minX; $x <= $maxX; $x++){
            for($z = $minZ; $z <= $maxZ; $z++){
                $y = $blocks->y;
                $block = $blocks->getLevel()->getBlockAt($x, $y, $z);
                if($block->getId() === 59 and $block->getDamage() === 7){
                    $get = Block::get(Block::WHEAT_BLOCK);
                    $rand = mt_rand(1,2);
                    $item = Item::get(Item::WHEAT, 0, $rand);
                    $block->level->setBlock($block, $get);
                    $chest->getInventory()->addItem($item);
                }elseif($block->getId() === 142 and $block->getDamage() === 7){
                    $get = Block::get(Block::POTATO_BLOCK);
                    $rand = mt_rand(2,3);
                    $item = Item::get(Item::POTATO, 0, $rand);
                    $block->level->setBlock($block, $get);
                    $chest->getInventory()->addItem($item);
                }elseif($block->getId() === 141 and $block->getDamage() === 7){
                    $get = Block::get(Block::CARROT_BLOCK);
                    $rand = mt_rand(2,3);
                    $item = Item::get(Item::CARROT, 0, $rand);
                    $block->level->setBlock($block, $get);
                    $chest->getInventory()->addItem($item);
                }elseif($block->getId() === 244 and $block->getDamage() === 7){
                    $get = Block::get(Block::BEETROOT_BLOCK);
                    $rand = mt_rand(1,2);
                    $item = Item::get(Item::BEETROOT, 0, $rand);
                    $block->level->setBlock($block, $get);
                    $chest->getInventory()->addItem($item);
                }
            }
        }
    }
}