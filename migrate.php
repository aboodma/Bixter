<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    die('Run this from the command line only.');
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

require_once ROOT . DS . 'config' . DS . 'config.php';

spl_autoload_register(static function (string $className): void {
    $paths = [
        ROOT . DS . 'core' . DS . $className . '.php',
        ROOT . DS . 'App' . DS . 'models' . DS . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$db = new Database();
Application::$db = $db;
$migration = new Migration();
$migration->run();

echo "Migrations completed.\n";
