<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    die('Run this from the command line only.');
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

require_once ROOT . DS . 'config' . DS . 'config.php';

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'Bixter\\Core\\' => ROOT . DS . 'core' . DS,
        'Bixter\\App\\Models\\' => ROOT . DS . 'App' . DS . 'models' . DS,
        'Bixter\\App\\Controllers\\' => ROOT . DS . 'App' . DS . 'controllers' . DS,
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (strpos($class, $prefix) === 0) {
            $relative = substr($class, strlen($prefix));
            $path = $baseDir . str_replace('\\', DS, $relative) . '.php';
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    }
});

class_alias('Bixter\\Core\\Application', 'Application');

Bixter\Core\Application::$db = new Bixter\Core\Database();

$migrator = new Bixter\Core\Migrator();
$migrator->run();
