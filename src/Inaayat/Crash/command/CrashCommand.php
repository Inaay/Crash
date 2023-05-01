<?php

/**
 *
 *  ██ ███    ██  █████   █████  ██    ██  █████  ████████
 *  ██ ████   ██ ██   ██ ██   ██  ██  ██  ██   ██    ██
 *  ██ ██ ██  ██ ███████ ███████   ████   ███████    ██
 *  ██ ██  ██ ██ ██   ██ ██   ██    ██    ██   ██    ██
 *  ██ ██   ████ ██   ██ ██   ██    ██    ██   ██    ██
 *
 * @author Inaayat
 * @link https://github.com/Inaay
 *
 */

declare(strict_types=1);

namespace Inaayat\Crash\command;

use Inaayat\Crash\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;

class CrashCommand extends Command implements PluginOwned {

	public function __construct() {
		parent::__construct("crash", "Crash players");
		$this->setPermission("crash.command");
	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array $args
	 * 
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		if (count($args) !== 1) {
			$sender->sendMessage(TextFormat::RED . "Usage: /crash <player>");
			return false;
		}
		$player = $sender->getServer()->getPlayerExact($args[0]);
		if (!$player instanceof Player) {
			$sender->sendMessage(TextFormat::RED . "Player not found.");
			return false;
		}
		$this->getOwningPlugin()->crashPlayer($player);
		$sender->sendMessage(TextFormat::GREEN . "Crash initiated on player: " . TextFormat::RED . $player->getName());
		return true;
	}

	/**
	 * @return Main
	 */
	public function getOwningPlugin(): Main {
		return Main::getInstance();
	}
}