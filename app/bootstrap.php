<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

if (PHP_SAPI === 'cli') {
	$configurator->setDebugMode(in_array('--debug', $_SERVER['argv'], true));
} else {
	$configurator->setDebugMode([
	]);
}
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
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
