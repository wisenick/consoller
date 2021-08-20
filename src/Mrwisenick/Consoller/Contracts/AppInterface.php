<?php
namespace Mrwisenick\Consoller\Contracts;

/**
 * Main app interface
 */
interface AppInterface {
	public function __construct(array $argv, CommandRepositoryInterface $repository = null);
	public function setRepository(CommandRepositoryInterface $repository);
	public function getRepository();

	public function getRequest();
	
	// Repository wrapper methods
	public function registerCommand(string $commandName, $callable, string $manual = null);
	public function unregisterCommand(string $commandName);
	
	public function printCommands();
	public function run();
}
