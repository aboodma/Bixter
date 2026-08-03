<?php

declare(strict_types=1);

namespace Bixter\Core;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }

    public function isAjax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
            || $this->header('Accept') === 'application/json';
    }

    public function post(string $key = '', mixed $default = null): mixed
    {
        if ($key === '') {
            return $_POST ?? [];
        }
        return $_POST[$key] ?? $default;
    }

    public function get(string $key = '', mixed $default = null): mixed
    {
        if ($key === '') {
            return $_GET ?? [];
        }
        return $_GET[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        $data = array_merge($_GET ?? [], $_POST ?? []);
        return $data[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($_GET ?? [], $_POST ?? []);
    }

    public function header(string $key, string $default = ''): string
    {
        $headerKey = 'HTTP_' . str_replace('-', '_', strtoupper($key));
        return $_SERVER[$headerKey] ?? $default;
    }

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function path(): string
    {
        $path = $_SERVER['PATH_INFO'] ?? parse_url($this->uri(), PHP_URL_PATH) ?? '/';
        $path = rtrim($path, '/');
        return $path === '' ? '/' : $path;
    }
}
