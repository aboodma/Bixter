<?php

declare(strict_types=1);

namespace Bixter\Core;

class Router
{
    protected static array $routes = [];
    protected static array $groupStack = [];

    public static function get(string $pattern, $handler, array $middleware = []): void
    {
        self::add('GET', $pattern, $handler, $middleware);
    }

    public static function post(string $pattern, $handler, array $middleware = []): void
    {
        self::add('POST', $pattern, $handler, $middleware);
    }

    public static function put(string $pattern, $handler, array $middleware = []): void
    {
        self::add('PUT', $pattern, $handler, $middleware);
    }

    public static function patch(string $pattern, $handler, array $middleware = []): void
    {
        self::add('PATCH', $pattern, $handler, $middleware);
    }

    public static function delete(string $pattern, $handler, array $middleware = []): void
    {
        self::add('DELETE', $pattern, $handler, $middleware);
    }

    public static function any(string $pattern, $handler, array $middleware = []): void
    {
        self::add('GET', $pattern, $handler, $middleware);
        self::add('POST', $pattern, $handler, $middleware);
        self::add('PUT', $pattern, $handler, $middleware);
        self::add('PATCH', $pattern, $handler, $middleware);
        self::add('DELETE', $pattern, $handler, $middleware);
    }

    public static function group(array $attributes, \Closure $routes): void
    {
        self::$groupStack[] = $attributes;
        $routes();
        array_pop(self::$groupStack);
    }

    protected static function add(string $method, string $pattern, $handler, array $middleware = []): void
    {
        $group = self::currentGroup();

        $prefix = $group['prefix'] ?? '';
        if ($prefix !== '' && !str_starts_with($pattern, $prefix)) {
            $pattern = rtrim($prefix, '/') . '/' . ltrim($pattern, '/');
        }

        $groupMiddleware = $group['middleware'] ?? [];
        $middleware = array_merge($groupMiddleware, $middleware);

        self::$routes[strtoupper($method)][] = [
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware,
            'regex' => self::compilePattern($pattern),
        ];
    }

    protected static function currentGroup(): array
    {
        $group = ['prefix' => '', 'middleware' => []];
        foreach (self::$groupStack as $g) {
            if (isset($g['prefix'])) {
                $group['prefix'] = rtrim($group['prefix'], '/') . '/' . trim($g['prefix'], '/');
            }
            if (isset($g['middleware'])) {
                $group['middleware'] = array_merge($group['middleware'], (array) $g['middleware']);
            }
        }
        return $group;
    }

    protected static function compilePattern(string $pattern): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        $pattern = rtrim($pattern, '/');
        return '#^' . $pattern . '/?$#';
    }

    public static function dispatch(Request $request): bool
    {
        $method = $request->method();
        $path = $request->path();

        $routes = self::$routes[$method] ?? [];
        foreach ($routes as $route) {
            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                self::runMiddleware($route['middleware'], $request);
                self::run($route['handler'], array_values($params));
                return true;
            }
        }

        // Fallback to convention-based routing for undefined routes
        if (self::conventionRoute($path)) {
            return true;
        }

        http_response_code(404);
        $view = new View();
        $view->render('errors/404');
        return false;
    }

    protected static function runMiddleware(array $middleware, Request $request): void
    {
        foreach ($middleware as $class) {
            if (!class_exists($class)) {
                throw new \Exception("Middleware {$class} not found");
            }
            $instance = new $class();
            if (!method_exists($instance, 'handle')) {
                throw new \Exception("Middleware {$class} has no handle method");
            }
            $instance->handle($request);
        }
    }

    protected static function run($handler, array $params): void
    {
        if ($handler instanceof \Closure) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$class, $method] = explode('@', $handler, 2);
            $class = self::resolveController($class);
            if (!class_exists($class)) {
                throw new \Exception("Controller {$class} not found");
            }
            $dispatch = new $class($class, $method);
            if (!method_exists($dispatch, $method)) {
                throw new \Exception("Method {$method} not found in {$class}");
            }
            call_user_func_array([$dispatch, $method], $params);
            return;
        }

        throw new \Exception('Invalid route handler');
    }

    protected static function resolveController(string $class): string
    {
        if (strpos($class, '\\') !== false) {
            return $class;
        }
        return DEFAULT_CONTROLLER_NAMESPACE . $class;
    }

    protected static function conventionRoute(string $path): bool
    {
        $url = explode('/', ltrim($path, '/'));

        $controller = (isset($url[0]) && $url[0] !== '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $controllerName = $controller;
        array_shift($url);

        $action = (isset($url[0]) && $url[0] !== '') ? $url[0] . 'Action' : DEFAULT_ACTION;
        $actionName = $action;
        array_shift($url);

        $queryParams = array_values($url);

        $controllerFile = ROOT . DS . 'App' . DS . 'controllers' . DS . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            return false;
        }

        $controller = DEFAULT_CONTROLLER_NAMESPACE . $controllerName;
        $dispatch = new $controller($controller, $actionName);
        if (!method_exists($dispatch, $action)) {
            return false;
        }

        call_user_func_array([$dispatch, $action], $queryParams);
        return true;
    }
}
