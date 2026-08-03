<?php

declare(strict_types=1);

class Router
{
    public static function route(array $url): void
    {
        $controller = (isset($url[0]) && $url[0] !== '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $controllerName = $controller;
        array_shift($url);

        $action = (isset($url[0]) && $url[0] !== '') ? $url[0] . 'Action' : DEFAULT_ACTION;
        $actionName = $action;
        array_shift($url);

        $queryParams = array_values($url);

        $controllerFile = ROOT . DS . 'App' . DS . 'controllers' . DS . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            self::_notFound();
        }

        $dispatch = new $controllerName($controllerName, $actionName);

        if (!method_exists($dispatch, $action)) {
            self::_notFound();
        }

        call_user_func_array([$dispatch, $action], $queryParams);
    }

    private static function _notFound(): void
    {
        http_response_code(404);
        include ROOT . DS . 'App' . DS . 'views' . DS . '404.php';
        exit;
    }
}
