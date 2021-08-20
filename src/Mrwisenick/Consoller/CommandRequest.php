<?php
namespace Mrwisenick\Consoller;
use Mrwisenick\Consoller\Contracts\CommandRequestInterface;

class CommandRequest
implements CommandRequestInterface
{
	private $commandName;
	private $args = [];
	private $params = [];

	/**
	 * Constructor
	 * @param string $commandName 
	 * @param array|array $args 
	 * @param array|array $params 
	 * @return type
	 */
	public function __construct(
		string $commandName, 
		array $args = [], 
		array $params = []
	)
	{
		$this->commandName = $commandName;
		$this->args = $args;
		$this->params = $params;
	}

	/**
	 * Get command name
	 * @return string
	 */
	public function getCommand(): string
	{
		return $this->commandName;
	}

	/**
	 * Get arguments list
	 * @return array
	 */
	public function getArguments(): array
	{
		return $this->args;
	}

	/**
	 * Get params list
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * Checks if request has help argument in list
	 * @return type
	 */
	public function hasHelpArgument(): bool
	{
		return in_array('help', $this->args);
	}
}
