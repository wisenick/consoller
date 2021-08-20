<?php
namespace Mrwisenick\Consoller;
use Mrwisenick\Consoller\Contracts\CommandRequestInterface;
use Mrwisenick\Consoller\Contracts\CommandHandlerInterface;

class CommandHandler
implements CommandHandlerInterface
{
	private $manual;
	private $function;

	/**
	 * Constructor
	 * @param callable|null $function 
	 * @return type
	 */
	public function __construct(callable $function = null)
	{
		$this->function = $function;
	}

	/**
	 * Run handler
	 * @param CommandRequestInterface $args
	 */
	public function run(CommandRequestInterface $args)
	{
		if (is_callable($this->function)) {
			return call_user_func($this->function, $args);
		}
	}

	/**
	 * If command handler has manual
	 * @return bool
	 */
	public function hasManual(): bool
	{
		return !empty($this->manual);
	}

	/**
	 * Set command handler manual
	 * @param string $text 
	 * @return void
	 */
	public function setManual(string $text): void
	{
		$this->manual = $text;
	}

	/**
	 * Get command handler manual
	 * @return string
	 */
	public function getManual(): string
	{
		return $this->manual;
	}

	/**
	 * Print command handler manual
	 * @return void
	 */
	public function printManual(): void
	{
		if (!$this->manual) {
			echo 'No manual for this command', PHP_EOL;
			exit(1);
		}

		echo $this->manual, PHP_EOL;
		exit(1);
	}
}
