<?php

declare(strict_types=1);

namespace tony\stark;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\plugin\Pluginbase;

use pocketmine\player\Player;

use pocketmine\server;

use FormAPI\SimpleForm;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\event\inventory\InventoryTransactionEvent;

use pocketmine\item\VanillaItems;

class Main extends Pluginbase implements Listener {

    public function onEnable(): void {

        

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

    }

    public function onDisable(): void {

        

    }

    public function onJoin(PlayerJoinEvent $e) {

    	$player = $e->getPlayer();

    	$item = VanillaItems::NETHER_STAR()->setCustomName("§eMenu");

    	$player->getInventory()->setItem(8, $item, true);

    }

    public function onInteract(PlayerInteractEvent $e) {

    	$player = $e->getPlayer();

    	$item = $e->getItem();

    	if ($item->getId() === 399 && $item->getCustomName() === "§eMenu") {

    		$this->newSimpleForm($player);

    	}

    }

    public function onTransaction(InventoryTransactionEvent $event) {

      $transaction = $event->getTransaction();

      foreach ($transaction->getActions() as $action) {

        $item = $action->getSourceItem();

        $source = $transaction->getSource();

        if ($source instanceof Player && $item->getId() === 399 && $item->getCustomName() === "§eMenu") {

          $event->cancel();

        }

      }

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool  {

    	if ($cmd->getname() =="menu") {

    		if($sender instanceof Player ) {

    			$this->newSimpleForm($sender);

    		} else {

    			$sender->sendMessage("Bro You Cant Open Nether Star From Console");

    			return true;

    		}

    	}

    	return true;

    }

    public function newSimpleForm($player){

    	$form  = new SimpleForm(function(Player $player, int $data =null){

    		if ($data === null){

    			return true; 

    		}

    		switch ($data){

    			case 0:

    			$this->dispatchCommand($player,"sbmenu");

    			break;

    			case 1:

    			$this->dispatchCommand($player,"bank");            

    			break;

    			case 2:

    			$this->dispatchCommand($player,"ec");           

    			break;

    			case 3:

    			$this->dispatchCommand($player,"auction");           

    			break; 

    			case 4:

    			$this->dispatchCommand($player,"bazaar");            

    			break;

    			case 5:

    			$this->dispatchCommand($player,"warps");            

    			break;

    			case 6:

    			$this->dispatchCommand($player,"setting");           

    			break;

    		}

    	});

    	$form->setTitle("§e§lSkyblock Menu");

    	$form->setContent("All The Important Functions Can Be Accessed From This Menu");

    	$form->addButton("§b§lSkyblockMenu");

    	$form->addButton("§l§bBank");

    	$form->addButton("§l§bEnderChest");

    	$form->addButton("§l§bAuction");

    	$form->addButton("§b§lBazaar");

    	$form->addButton("§b§lWarps");

    	$form->addButton("§b§lSettings");

    	$form->sendToPlayer($player);

    	return $form;

    }

}
