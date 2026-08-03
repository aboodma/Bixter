<?php

declare(strict_types=1);

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'App' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

spl_autoload_register(static function (string $className): void {
    $paths = [
        ROOT . DS . 'core' . DS . $className . '.php',
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

Router::route($url);
