<?php
namespace Mrwisenick\Consoller\Contracts;

/**
 * Command Request interface
 */
interface CommandRequestInterface {
	public function __construct(string $commandName, array $args = [], array $params = []);
	public function getCommand();
	public function getArguments();
	public function getParams();
	public function hasHelpArgument();
}
