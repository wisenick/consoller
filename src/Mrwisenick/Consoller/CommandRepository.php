<?php
namespace Mrwisenick\Consoller;
use Mrwisenick\Consoller\Contracts\CommandRepositoryInterface;
use Mrwisenick\Consoller\Contracts\CommandHandlerInterface;
use Mrwisenick\Consoller\CommandHandler;

class CommandRepository
implements CommandRepositoryInterface
{
	private $list = [];

	public function __construct()
	{

	}

	/**
	 * If current list is empty
	 * @return bool
	 */
	public function isEmpty(): bool
	{
		return empty($this->list);
	}

	/**
	 * Checks for command in list
	 * @param string $commandName 
	 * @return bool
	 */
	public function hasCommand(string $commandName): bool
	{
		return isset($this->list[strtolower($commandName)]);
	}

	/**
	 * Get command handler from list
	 * @param string $commandName 
	 * @return CommandHandlerInterface
	 */
	public function getCommand(string $commandName): CommandHandlerInterface
	{
		return $this->list[strtolower($commandName)];
	}

	/**
	 * Set command handler in list
	 * @param string $commandName 
	 * @param type $handler 
	 * @param string|null $manual 
	 * @return CommandHandlerInterface
	 */
	public function setCommand(
		string $commandName, 
		$handler,
		string $manual = null
	): CommandHandlerInterface
	{
		$commandName = strtolower($commandName);
		if (
			(!is_object($handler) && $handler instanceof CommandHandlerInterface) ||
			!is_callable($handler)
		) {
			throw new Exception('Invalid command handler. Must be callable or instance of CommandHandlerInterface');
		}

		if (is_object($handler) && $handler instanceof CommandHandlerInterface) {
			$this->list[$commandName] = $handler;
		} else {
			$this->list[$commandName] = new CommandHandler($handler);
		}

		if ($manual) {
			$this->list[$commandName]->setManual($manual);
		}

		return $this->list[$commandName];
	}

	/**
	 * Unset command handler in list
	 * @param string $commandName 
	 * @return void
	 */
	public function unsetCommand(string $commandName): void
	{
		unset($this->list[strtolower($commandName)]);
	}

	/**
	 * Get the full list of commands and handlers
	 * @return array
	 */
	public function getList(): array
	{
		return $this->list;
	}
}
