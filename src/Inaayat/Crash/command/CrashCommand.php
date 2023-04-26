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

		if (count($args) !== 2) {
			$sender->sendMessage(TextFormat::RED . "Usage: /crash <player> <fast|slow>");
			return false;
		}

		$player = $sender->getServer()->getPlayerExact($args[0]);
		if (!$player instanceof Player) {
			$sender->sendMessage(TextFormat::RED . "Player not found.");
			return false;
		}

		$mode = strtolower($args[1]);
		if ($mode !== "fast" && $mode !== "slow") {
			$sender->sendMessage(TextFormat::RED . "Invalid mode, use 'fast' or 'slow'.");
			$sender->sendMessage(TextFormat::RED . "Usage: /crash <player> <fast|slow>");
			return false;
		}

		if ($mode === "slow") {
			$this->getOwningPlugin()->crashPlayer($player, Main::CRASH_SLOW_MODE);
			$sender->sendMessage(TextFormat::GREEN . "Slow crash initiated on player: " . TextFormat::RED . $player->getName());
		} else {
			$this->getOwningPlugin()->crashPlayer($player, Main::CRASH_FAST_MODE);
			$sender->sendMessage(TextFormat::GREEN . "Fast crash initiated on player: " . TextFormat::RED . $player->getName());
		}
		return true;
	}

	/**
	 * @return Main
	 */
	public function getOwningPlugin(): Main {
		return Main::getInstance();
	}
}