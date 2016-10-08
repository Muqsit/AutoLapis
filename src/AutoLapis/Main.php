<?php

/*
*    _         _          __             _     
*   /_\  _   _| |_ ___   / /  __ _ _ __ (_)___ 
*  //_\\| | | | __/ _ \ / /  / _` | '_ \| / __|
* /  _  \ |_| | || (_) / /__| (_| | |_) | \__ \
* \_/ \_/\__,_|\__\___/\____/\__,_| .__/|_|___/
*                                 |_|          
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*/


namespace AutoLapis;

use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\inventory\EnchantInventory;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryCloseEvent;

class Main extends PluginBase implements Listener {

	public function onEnable() {
		$this->getLogger()->info(TF::AQUA.TF::BOLD."Enabled AutoLapis by Muqsit.");
		$this->getLogger()->info(TF::AQUA.TF::BOLD."
	    _         _          __             _     \n".TF::AQUA.TF::BOLD."
	   /_\  _   _| |_ ___   / /  __ _ _ __ (_)___ \n".TF::AQUA.TF::BOLD."
	  //_\\| | | | __/ _ \ / /  / _` | '_ \| / __|\n".TF::AQUA.TF::BOLD."
	 /  _  \ |_| | || (_) / /__| (_| | |_) | \__ \\n".TF::AQUA.TF::BOLD."
	 \_/ \_/\__,_|\__\___/\____/\__,_| .__/|_|___/\n".TF::AQUA.TF::BOLD."
	                                 |_|          ");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->reloadConfig();
	}

	public function onOpen(InventoryOpenEvent $event) {
		$inventory = $event->getInventory();
		$player = $event->getPlayer();
		$count = $this->getConfig()->get("amount");
		if ($player->hasPermission("auto.lapis")) {
			$inventory->setItem(1, Item::get(351, 4, $count)->setCustomName(TF::RESET.TF::AQUA."Lapis Lazuli"));
		}
	}

	/* There are some server-based bugs. To overcome it... */
	public function onDrop(PlayerDropItemEvent $event) {
		$player = $event->getPlayer();
		$item = $event->getItem();
		if ($item->hasCustomName()) {
			if ($item->getCustomName() == TF::RESET.TF::AQUA."Lapis Lazuli") {
				$player->getInventory()->remove($item);
				$event->setCancelled();
			}
		}
	}

	public function onClose(InventoryCloseEvent $event) {
		$inventory = $event->getInventory();
		if ($inventory instanceof EnchantInventory) {
			$inventory->setItem(0, Item::get(0));
		}
	}
}