<?php
//le plugin est créer part TutoGamerWalid & MrReskill copyright 2015 - 2016 ©

namespace BrawlPVP;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Entity;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\Player;

class Main extends PluginBase Implements Listener {
	//scheduleDelayedTask
	public $cfg;
	public $players;
	
		public function onEnable() {
		$this->saveDefaultConfig();
 		$this->cfg = $this->getConfig();
		$this->getLogger()->info("BrawlPVP has been enable");
	}

 public function onDisable() {
		$this->saveDefaultConfig();
		$this->getLogger()->info("Brawl has been disable");
	}

	public function onSignChange(SignChangeEvent $event) {
		if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63) {
			$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
 			if ($event->getLine ( 0 ) == "§l§4[Brawl]" && $event->getPlayer()->isOp()) {
				$event->setLine(0,"§l§4[Brawl]");
 				if (($world = $this->getServer()->getLevelByName("worldname"))) {
					$count = count($world->getPlayers());
 					$event->getLine(1);
 					$event->getLine(2);
 					$event->setLine(1,"§l§bPVP - BL !");
 					$event->setLine(2,"[$count/8]");
 					$player = $event->getPlayer();
 					$player->sendMessage("[PVPBRAWL] Succefully created !");
 					//create a new sign 
 				}
 			}
		}
	}
