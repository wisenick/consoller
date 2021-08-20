<?php
namespace Mrwisenick\Consoller\Contracts;

/**
 * Repository interface to collect command handlers
 */
interface CommandRepositoryInterface {
	public function isEmpty();
	public function hasCommand(string $commandName);
	public function getCommand(string $commandName);
	public function setCommand(string $commandName, $callable);
	public function unsetCommand(string $commandName);
	public function getList();
}
