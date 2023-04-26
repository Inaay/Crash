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
use pocketmine\utils\Limits;
use pocketmine\world\Position;

class Main extends PluginBase {

	/**
	 * @var self
	 */
	private static $instance;

    /**
     * @var int
     */
    public const CRASH_FAST_MODE = 0;

    /**
     * @var int
     */
    public const CRASH_SLOW_MODE = 1;

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
	 * @param int $mode
	 * 
	 * @return void
	 */
	public function crashPlayer(Player $player, int $mode = self::CRASH_FAST_MODE): void {
		if ($mode === self::CRASH_FAST_MODE) {
            $player->getNetworkSession()->sendDataPacket(RemoveActorPacket::create($player->getId()));
        } elseif ($mode === self::CRASH_SLOW_MODE) {
			$oldPosition = $player->getPosition();
            $player->teleport(new Position($player->getPosition()->getX(), Limits::INT32_MAX - 1, $player->getPosition()->getY(), $player->getWorld()));
			$player->teleport($oldPosition);
        }
	}
}