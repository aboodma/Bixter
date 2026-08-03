<?php

declare(strict_types=1);

class User extends Model
{
    protected string $_table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findOne('email', $email);
    }

    public function findByUsername(string $username): ?array
    {
        return $this->findOne('username', $username);
    }

    public function validate(array $data): bool
    {
        $this->_errors = [];

        if (empty($data['username']) || strlen($data['username']) < 3) {
            $this->_errors['username'] = 'Username must be at least 3 characters.';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->_errors['email'] = 'A valid email is required.';
        }

        if (empty($data['password']) || strlen($data['password']) < 6) {
            $this->_errors['password'] = 'Password must be at least 6 characters.';
        }

        return !$this->hasErrors();
    }

    public function register(array $data): ?int
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
