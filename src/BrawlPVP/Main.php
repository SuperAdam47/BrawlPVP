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
