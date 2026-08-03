<?php

declare(strict_types=1);

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $this->set('_flash_' . $key, $value);
            return null;
        }

        $val = $this->get('_flash_' . $key);
        $this->remove('_flash_' . $key);
        return $val;
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function csrfToken(): string
    {
        if (!$this->has('csrf_token')) {
            $this->set('csrf_token', bin2hex(random_bytes(32)));
        }
        return $this->get('csrf_token');
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
