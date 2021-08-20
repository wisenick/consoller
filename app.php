<?php
require_once __DIR__ . '/vendor/autoload.php';
global $argc, $argv;

$consoller = new Mrwisenick\Consoller\Consoller($argv);

$consoller->registerCommand(
	'show_request', 
	function($request) {
		echo 'Called command: ', $request->getCommand(), PHP_EOL,
				PHP_EOL, 'Arguments:' . PHP_EOL;

		foreach ($request->getArguments() as $arg) {
			echo "\t- ", $arg, PHP_EOL;
		}

		echo 'Params:', PHP_EOL;

		foreach ($request->getParams() as $paramName => $paramValue) {
			echo "\t- ", $paramName, PHP_EOL;
			foreach ((array)$paramValue as $valueEntry) {
				echo "\t\t- ", $valueEntry, PHP_EOL;
			}
		}
	},
	'Simply outputs all given options'
);

$consoller->run();
