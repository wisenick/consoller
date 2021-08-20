<?php
namespace Mrwisenick\Consoller;
use Mrwisenick\Consoller\Contracts\CommandRequestInterface;
use Mrwisenick\Consoller\Contracts\CommandRequestBuilderInterface;

class CommandRequestBuilder
implements CommandRequestBuilderInterface
{
	const ENT_PARAM = 'param';
	const ENT_ARGUMENT = 'arg';
	const ENT_INVALID = 'invalid';

	protected $command;
	protected $arguments = [];
	protected $params = [];

	/**
	 * Fabric static method to build Request Object
	 * @param array $argv 
	 * @return type
	 */
	public static function build(array $argv): CommandRequestInterface
	{
		$builder = new static;
		$builder->parseInputInputArray($argv);

		return new CommandRequest(
			$builder->getCommand(),
			$builder->getArguments() ?: [],
			$builder->getParams() ?: []
		);
	}

	/**
	 * Description
	 * @param string $string 
	 * @return string
	 */
	public static function defineInputEntity(string $string): string
	{
		if (preg_match("/\[[^\[\]\t\n]+\]/", $string)) {
			return static::ENT_PARAM;
		}

		if (preg_match("/\{[^\{\}\t\n]+\}/", $string)) {
			return static::ENT_ARGUMENT;
		}

		if (preg_match("/\{[^\{\}\t\n]+\}/", $string)) {
			return static::ENT_ARGUMENT;
		}

		return static::ENT_ARGUMENT;
	}

	/**
	 * Description
	 * @param array $list 
	 * @return void
	 */
	public function parseInputInputArray(array $list): void
	{
		$this->parseCommand($list[1] ?: 'undefined');
		$inputParams = array_slice($list, 2);

		foreach ($inputParams as $item) {
			$entityType = static::defineInputEntity($item);

			if ($entityType === static::ENT_INVALID) continue;

			switch ($entityType) {
				case static::ENT_PARAM:
					$this->parseParam($item);
					break;
				default:
					$this->parseArgument($item);
					break;
			}
		}
	}

	/**
	 * Description
	 * @param string $command 
	 * @return void
	 */
	protected function parseCommand(string $command): void
	{
		if (is_numeric($command)) {
			throw new \Exception('Command must be a non numeric string');
		}

		$this->command = trim($command);
	}

	/**
	 * Description
	 * @param string $string 
	 * @return void
	 */
	protected function parseArgument(string $string): void
	{
		if (preg_match("/[\=\,]+/", $string)) return;
		if (preg_match("/\{([^\{\}\t\n]+)\}/", $string, $matches)) {
			$this->addArgument($matches[1]);
			return;
		}

		$string = preg_replace("/[\{\}\,]+/", '', $string);
		if (is_numeric($string)) return;
		$this->addArgument($string);
	}

	/**
	 * Description
	 * @param string $string 
	 * @return void
	 */
	protected function parseParam(string $string): void
	{
		preg_match("/[\[]+([^\[\]\t\n]+)[\]]+/", $string, $matches);
		$list = $matches[1];
		$params = explode(',', $list);

		foreach ($params as $entry) {
			// ignore valueless params
			if (strpos($entry, '=') === false) continue;
			$arParam = explode('=', $entry);

			// Ignoer numeric param names
			if (is_numeric($arParam[0])) continue;
			$this->addParam($arParam[0], $arParam[1]);
		}
	}

	/**
	 * Description
	 * @param string $arg 
	 * @return void
	 */
	protected function addArgument($arg): void
	{
		if (!$arg) return;

		if (!in_array($arg, $this->arguments)) {
			$this->arguments[] = $arg;
		}
	}

	/**
	 * Description
	 * @param string $param 
	 * @param string $value 
	 * @return void
	 */
	protected function addParam(string $param, string $value): void
	{
		if (isset($this->params[$param])) {
			$this->params[$param] = array_merge(
				(array)$this->params[$param],
				(array)$value
			);
		} else {
			$this->params[$param] = $value;
		}
	}

	/**
	 * Description
	 * @return string
	 */
	public function getCommand(): string
	{
		return $this->command;
	}

	/**
	 * Description
	 * @return array
	 */
	public function getArguments(): array
	{
		return $this->arguments;
	}

	/**
	 * Description
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}
}
