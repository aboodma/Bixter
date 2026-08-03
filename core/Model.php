<?php

declare(strict_types=1);

namespace Bixter\Core;

abstract class Model
{
    protected string $_table = '';
    protected array $_errors = [];
    protected ?QueryBuilder $_query = null;

    public function __construct()
    {
    }

    public function query(): QueryBuilder
    {
        return Application::$db->table($this->_table);
    }

    public function findById(int $id): ?array
    {
        return $this->query()->where('id', $id)->first();
    }

    public function findAll(): array
    {
        return $this->query()->orderBy('id', 'DESC')->get();
    }

    public function findOne(string $column, mixed $value): ?array
    {
        return $this->query()->where($column, $value)->first();
    }

    public function insert(array $data): int
    {
        return $this->query()->insert($data);
    }

    public function update(int $id, array $data): int
    {
        return $this->query()->where('id', $id)->update($data);
    }

    public function delete(int $id): int
    {
        return $this->query()->where('id', $id)->delete();
    }

    public function getErrors(): array
    {
        return $this->_errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->_errors);
    }

    abstract public function validate(array $data): bool;
}
