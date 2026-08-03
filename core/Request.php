<?php

declare(strict_types=1);

class Request
{
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
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

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function path(): string
    {
        $uri = parse_url($this->uri(), PHP_URL_PATH);
        return $uri ?: '/';
    }
}
