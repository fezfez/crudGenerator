<?php

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    chdir(__DIR__ . '/../'); // standalone
} elseif (is_file(__DIR__ . '/../../../autoload.php')) {
    chdir(__DIR__ . '/../../../../'); // install with composer
} else {
    throw new RuntimeException('Error: vendor/autoload.php could not be found. Did you run php composer.phar install?');
}

include_once 'vendor/autoload.php';

Symfony\Component\Debug\Debug::enable();

$app = new Silex\Application();

require __DIR__.'/../silex/resources/config/prod.php';
require __DIR__.'/../silex/src/app.php';
require __DIR__.'/../silex/src/controllers.php';

$directoriestoCreate = array(
	'Cache'   => $app['cache.path'],
	'History' => CrudGenerator\History\HistoryManager::HISTORY_PATH,
	'Config'  => CrudGenerator\MetaData\Config\MetaDataConfigDAO::PATH
);

foreach ($directoriestoCreate as $directoryName => $directoryPath) {
	if (!is_dir($directoryPath)) {
		mkdir($directoryPath);
	}

	if (!is_writable($directoryPath)) {
		throw new Exception(sprintf('%s directory "%s" is not writable', $directoryName, $directoryPath));
	}
}

$app->run();
