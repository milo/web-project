<?php

function dump($var)
{
	Tracy\Dumper::dump($var, [
		Tracy\Dumper::TRUNCATE => 1024,
		Tracy\Dumper::COLLAPSE => 30,
		Tracy\Dumper::COLLAPSE_COUNT => 15,
		Tracy\Dumper::DEPTH => 6,
	]);

	return $var;
}

function bdump($var)
{
	Tracy\Debugger::barDump($var);
	return $var;
}

require __DIR__ . '/../vendor/autoload.php';

Tracy\Debugger::$maxDepth = 10;

$configurator = new Nette\Configurator;

if (PHP_SAPI === 'cli') {
	$configurator->setDebugMode(!in_array('--production', $_SERVER['argv'], TRUE));
} else {
	$configurator->setDebugMode([
	]);
}

$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../lib')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');
if ($configurator->isDebugMode()) {
#	Dibi\Bridges\Tracy\Panel::$maxLength = 65535;
	$configurator->addConfig(__DIR__ . '/config/config.debug.neon');
}

$container = $configurator->createContainer();

return $container;
