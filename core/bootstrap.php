<?php

declare(strict_types=1);

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'App' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

$composerAutoload = ROOT . DS . 'vendor' . DS . 'autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    spl_autoload_register(static function (string $class): void {
        $prefixes = [
            'Bixter\\Core\\' => ROOT . DS . 'core' . DS,
            'Bixter\\App\\Controllers\\' => ROOT . DS . 'App' . DS . 'controllers' . DS,
            'Bixter\\App\\Models\\' => ROOT . DS . 'App' . DS . 'models' . DS,
            'Bixter\\App\\Middleware\\' => ROOT . DS . 'App' . DS . 'middleware' . DS,
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
}

class_alias('Bixter\\Core\\Application', 'Application');
class_alias('Bixter\\Core\\Router', 'Router');

new Bixter\Core\Application();

if (file_exists(ROOT . DS . 'routes' . DS . 'web.php')) {
    require_once ROOT . DS . 'routes' . DS . 'web.php';
}
if (file_exists(ROOT . DS . 'routes' . DS . 'api.php')) {
    require_once ROOT . DS . 'routes' . DS . 'api.php';
}

Bixter\Core\Kernel::handle();
