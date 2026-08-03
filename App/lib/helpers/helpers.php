<?php

declare(strict_types=1);

use Bixter\Core\Application;

function dnd(mixed $data): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function root(string $path = ''): string
{
    return PROOT . ltrim($path, '/');
}

function csrf(): string
{
    return Application::$session->csrfToken();
}

function csrfInput(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf()) . '">';
}

function verifyCsrf(array $data): bool
{
    return isset($data['csrf_token']) && hash_equals(csrf(), $data['csrf_token']);
}
