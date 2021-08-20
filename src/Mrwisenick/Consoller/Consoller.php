<?php
namespace Mrwisenick\Consoller;
use Mrwisenick\Consoller\Contracts\AppInterface;
use Mrwisenick\Consoller\Contracts\CommandRepositoryInterface;
use Mrwisenick\Consoller\Contracts\CommandRequestInterface;
use Mrwisenick\Consoller\Contracts\CommandHandlerInterface;
use Mrwisenick\Consoller\CommandRepository;

class Consoller
implements AppInterface
{
	protected CommandRequestInterface $request;
	protected CommandRepositoryInterface $commandRepository;

	/**
	 * Constructor
	 * @param array $argv 
	 * @param CommandRepositoryInterface|null $repository 
	 */
	public function __construct(array $argv, CommandRepositoryInterface $repository = null)
	{
		$argv = (array)$argv ?: [];
		$this->request = CommandRequestBuilder::build($argv);

		if ($repository) {
			$this->setRepository($repository);
		} else {
			$this->setRepository(new CommandRepository);
		}
	}

	/**
	 * Set repository object
	 * @param CommandRepositoryInterface $repository 
	 * @return void
	 */
	public function setRepository(CommandRepositoryInterface $repository): CommandRepositoryInterface
	{
		return $this->commandRepository = $repository;
	}

	/**
	 * Get repository object
	 * @return CommandRepositoryInterface
	 */
	public function getRepository(): CommandRepositoryInterface
	{
		return $this->commandRepository;
	}

	/**
	 * Get request object
	 * @return CommandRequestInterface
	 */
	public function getRequest(): CommandRequestInterface
	{
		return $this->request;
	}

	/**
	 * Wrapper for registering command
	 * @param string $commandName 
	 * @param mixed $callable 
	 * @param string|null $manual 
	 * @return CommandHandlerInterface
	 */
	public function registerCommand(
		string $commandName, 
		$callable,
		string $manual = null
	): CommandHandlerInterface
	{
		return $this->commandRepository->setCommand($commandName, $callable, $manual);
	}

	/**
	 * Wrapper for unregistering command
	 * @param string $commandName 
	 * @return void
	 */
	public function unregisterCommand(string $commandName): void
	{
		$this->commandRepository->unset($commandName);
	}

	/**
	 * Prints out command list
	 * @return type
	 */
	public function printCommands(): void
	{
		if ($this->commandRepository->isEmpty()) {
			echo 'No commands been registered.' . PHP_EOL;
			return;
		};

		$handlers = $this->commandRepository->getList();

		echo 'Following registered commands available:' . PHP_EOL;

		foreach ($handlers as $commandName => $handler) {
			echo "\t- ", $commandName, PHP_EOL;
			if ($handler->hasManual()) {
				echo "\t",  $handler->getManual();
			}
		}

		echo PHP_EOL;
		exit(1);
	}

	public function run(): void
	{
		$commandName = $this->request->getCommand();

		if (!$this->commandRepository->hasCommand($commandName)) {
			$this->printCommands();
			exit(1);
		}

		if ($this->request->hasHelpArgument()) {
			$this->commandRepository->getCommand($commandName)->printManual();
			exit(1);
		}

		$this->commandRepository->getCommand($commandName)->run($this->getRequest());
	}
}
