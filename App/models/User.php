<?php

declare(strict_types=1);

namespace Bixter\App\Models;

use Bixter\Core\Model;
use Bixter\Core\Validator;

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
        $id = $data['id'] ?? null;
        $rules = [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        if ($id !== null) {
            unset($rules['password']);
            $rules['email'] .= '|unique:users,email,id,' . $id;
        } else {
            $rules['email'] .= '|unique:users,email';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->_errors = $validator->errors();
            return false;
        }

        return true;
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
