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
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase Implements Listener {
	//scheduleDelayedTask
	public $cfg;
	public $players;
        public $gameStarted = [];
	
		public function onEnable() {
		$this->saveDefaultConfig();
 		$this->cfg = $this->getConfig();
                $this->api = EconomyAPI::getInstance();
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
		public function onPlayerTouch(PlayerInteractEvent $event) {
		if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63) {
			$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
 
			if($sign instanceof Sign) {
				$signtext = $sign->getText();
 				if($signtext[0] == "§l§4[Brawl]") {
					$player = $event->getPlayer();
					$name = $player->getName();
					$this->getServer()->getScheduler()->scheduleRepeatingTask(new Task1($this), 20*60);
					if(empty($signtext[3]) !== true) {
						$worlds = $signtext[3];
						$this->getServer()->loadLevel($worlds);
 						$event->getPlayer()->teleport(Server::getInstance()->getLevelByName($worlds)->getSafeSpawn());
 						if (($world = $this->getServer()->getLevelByName($worlds))) {
							$count = count($world->getPlayers());
 							$player->sendTip(TextFormat::GREEN. "§l§4[Brawl] Téléportation en cour !");
							$this->getServer()->broadcastMessage("§l§4[Brawl]§a $name rejoin la partie §7[$count/8]");
							$player->setNameTag("§7" .$player->getName());
							$player->setDisplayName("§7" .$player->getName());
 							$duration = $this->cfg->get("Duration");
							$player->getInventory()->clearAll();
							if($this->gameStarted === true & $this->timer = 60 & count($this->players)> 8 & $player->isOp()){
								$event->setCancelled(true);
								$player->sendMessage("§l§4[Brawl] Tu ne peut pas rejoindre cette partie");
								$this->refreshSign();
								return;
								//sign event use
 							}
 						}
 					}
				}
			}
		}
     }

     	public function onRespawn(PlayerRespawnEvent $event) {
		$player = $event->getPlayer();
		$player->setNameTag($player->getName());
        }
        
        public function removePlayers($p, $players) {
           if (strtolower($players) == "players") { 
              unset($this->players[array_search($p, $this->players)]);
                 return true; 
                 }
        }

        public function onDeath(PlayerDeathEvent $event) {
           if ($event->getPlayer($event->getEntity()->getName()) && $this->gameStarted == true) {
            $this->removePlayers($event->getEntity()->getName(), "players");
            $event->getEntity()->teleport($this->getServer()->getLevelByName($this->cfg->get("quitte_level")->getSafeSpawn()));
        }
        foreach ($this->players as $players) {
                if (count($this->players) == 1 && $this->gameStarted == true) {
                    $this->getServer()->getPlayer($b)->getInventory()->clearAll();
                    $this->removePlayers($p, "players");
                    $this->getServer()->getPlayer($players)->teleport($this->getServer()->getLevelByName($this->cfg->get("winner_level")->getSafeSpawn()));
                    $argent = $this->cfg->get("argent_gagnant");
                    $this->getServer()->broadcastMessage("§l§a[PvPBrawl] ".$players->getName()." a gagne la partie ".$argent." + Coins !");
                    $this->api->addMoney($players, $argent);
                    $this->gameStarted = false;
                }
            }
        }
   }
