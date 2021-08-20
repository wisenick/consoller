<?php
namespace Mrwisenick\Consoller\Contracts;
use Mrwisenick\Consoller\Contracts\CommandRequestInterface;

/**
 * Command request Builder interface
 */
interface CommandRequestBuilderInterface
{
	public static function build(array $argv): CommandRequestInterface;
}
