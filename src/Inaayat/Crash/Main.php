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

namespace Inaayat\Crash;

use Inaayat\Crash\command\CrashCommand;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	/**
	 * @var self
	 */
	private static $instance;

	/**
	 * @return void
	 */
	public function onEnable(): void {
		self::$instance = $this;
		$this->getServer()->getCommandMap()->register("crash", new CrashCommand());
	}

	/**
	 * @return self
	 */
	public static function getInstance(): self {
		return self::$instance;
	}

	/**
	 * @param Player $player
	 * 
	 * @return void
	 */
	public function crashPlayer(Player $player): void {
		$player->getNetworkSession()->sendDataPacket(RemoveActorPacket::create($player->getId()));
	}
}