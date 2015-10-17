<?php

/** @var Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';

dump(
	$container->getByType(Nette\Mail\IMailer::class)
);
