<?php
namespace Mrwisenick\Consoller\Contracts;

/**
 * Concrete command handler / repository entry
 */
interface CommandHandlerInterface {
	public function run(CommandRequestInterface $args);
	public function hasManual();
	public function setManual(string $manual);
	public function printManual();
}
