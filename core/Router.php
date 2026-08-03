<?php

declare(strict_types=1);

class Router
{
    protected static array $routes = [];

    public static function get(string $pattern, $handler): void
    {
        self::add('GET', $pattern, $handler);
    }

    public static function post(string $pattern, $handler): void
    {
        self::add('POST', $pattern, $handler);
    }

    public static function put(string $pattern, $handler): void
    {
        self::add('PUT', $pattern, $handler);
    }

    public static function patch(string $pattern, $handler): void
    {
        self::add('PATCH', $pattern, $handler);
    }

    public static function delete(string $pattern, $handler): void
    {
        self::add('DELETE', $pattern, $handler);
    }

    public static function any(string $pattern, $handler): void
    {
        self::add('GET', $pattern, $handler);
        self::add('POST', $pattern, $handler);
        self::add('PUT', $pattern, $handler);
        self::add('PATCH', $pattern, $handler);
        self::add('DELETE', $pattern, $handler);
    }

    protected static function add(string $method, string $pattern, $handler): void
    {
        self::$routes[strtoupper($method)][] = [
            'pattern' => $pattern,
            'handler' => $handler,
            'regex' => self::compilePattern($pattern),
        ];
    }

    protected static function compilePattern(string $pattern): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }

    public static function dispatch(Request $request): bool
    {
        $method = $request->method();
        $path = $request->path();

        $routes = self::$routes[$method] ?? [];
        foreach ($routes as $route) {
            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                self::run($route['handler'], array_values($params));
                return true;
            }
        }

        // Fallback to convention-based routing for undefined routes
        if (self::conventionRoute($path)) {
            return true;
        }

        http_response_code(404);
        include ROOT . DS . 'App' . DS . 'views' . DS . '404.php';
        return false;
    }

    protected static function run($handler, array $params): void
    {
        if ($handler instanceof Closure) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$class, $method] = explode('@', $handler, 2);
            if (!class_exists($class)) {
                throw new Exception("Controller {$class} not found");
            }
            $dispatch = new $class($class, $method);
            if (!method_exists($dispatch, $method)) {
                throw new Exception("Method {$method} not found in {$class}");
            }
            call_user_func_array([$dispatch, $method], $params);
            return;
        }

        throw new Exception('Invalid route handler');
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

        $dispatch = new $controllerName($controllerName, $actionName);
        if (!method_exists($dispatch, $action)) {
            return false;
        }

        call_user_func_array([$dispatch, $action], $queryParams);
        return true;
    }
}
