<?php

declare(strict_types=1);

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'App' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

$composerAutoload = ROOT . DS . 'vendor' . DS . 'autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    spl_autoload_register(static function (string $className): void {
        $paths = [
            ROOT . DS . 'core' . DS . $className . '.php',
            ROOT . DS . 'core' . DS . 'Http' . DS . $className . '.php',
            ROOT . DS . 'App' . DS . 'controllers' . DS . $className . '.php',
            ROOT . DS . 'App' . DS . 'models' . DS . $className . '.php',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                require_once $path;
                return;
            }
        }
    });
}

if (file_exists(ROOT . DS . 'routes' . DS . 'web.php')) {
    require_once ROOT . DS . 'routes' . DS . 'web.php';
}
if (file_exists(ROOT . DS . 'routes' . DS . 'api.php')) {
    require_once ROOT . DS . 'routes' . DS . 'api.php';
}

Kernel::handle();
