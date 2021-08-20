# consoller
php cli lib

## usage

```php
<?php
global $argc, $argv;
$consoller = new Mrwisenick\Consoller\Consoller($argv);

$consoller->registerCommand(
	'show_request', 
	function($request) {
		var_dump([
			'command' => $request->getCommand(),
			'args' => $request->getArguments(),
			'params' => $request->getParams(),
		]);
	},
	'Manual text here'
);

$consoller->run();
