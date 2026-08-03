<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    die('Run from command line only.');
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'App' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'Bixter\\Core\\' => ROOT . DS . 'core' . DS,
        'Bixter\\App\\Controllers\\' => ROOT . DS . 'App' . DS . 'controllers' . DS,
        'Bixter\\App\\Models\\' => ROOT . DS . 'App' . DS . 'models' . DS,
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

use Bixter\Core\Request;
use Bixter\Core\View;
use Bixter\Core\Router;

$passed = 0;
$failed = 0;

function assert_true(bool $condition, string $message): void
{
    global $passed, $failed;
    if ($condition) {
        echo "  PASS: {$message}\n";
        $passed++;
    } else {
        echo "  FAIL: {$message}\n";
        $failed++;
    }
}

echo "Running basic sanity checks...\n\n";

// Request
$request = new Request();
assert_true($request->isGet() === true, 'Request detects GET method');
assert_true($request->get('missing', 'default') === 'default', 'Request get fallback works');

// Router
$url = ['admin', 'users'];
$controller = (isset($url[0]) && $url[0] !== '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
assert_true($controller === 'Admin', 'Router parses admin controller');

// View
$view = new View();
$view->setSiteTitle('Test');
assert_true($view->siteTitle() === 'Test', 'View sets and returns title');

// Helper escaping
assert_true(e('<script>') === '&lt;script&gt;', 'e() escapes HTML');

$total = $passed + $failed;
echo "\n{$passed}/{$total} passed, {$failed} failed.\n";
exit($failed > 0 ? 1 : 0);
