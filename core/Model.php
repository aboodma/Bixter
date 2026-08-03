<?php

declare(strict_types=1);

namespace Bixter\Core;

abstract class Model
{
    protected Database $_db;
    protected string $_table = '';
    protected array $_errors = [];

    public function __construct()
    {
        $this->_db = Application::$db;
    }

    public function findById(int $id): ?array
    {
        return $this->_db->fetch("SELECT * FROM {$this->_table} WHERE id = :id LIMIT 1", ['id' => $id]);
    }

    public function findAll(): array
    {
        return $this->_db->fetchAll("SELECT * FROM {$this->_table} ORDER BY id DESC");
    }

    public function findOne(string $column, mixed $value): ?array
    {
        return $this->_db->fetch("SELECT * FROM {$this->_table} WHERE {$column} = :value LIMIT 1", ['value' => $value]);
    }

    public function insert(array $data): int
    {
        return $this->_db->insert($this->_table, $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->_db->update($this->_table, $data, 'id = :id', ['id' => $id]);
    }

    public function delete(int $id): int
    {
        return $this->_db->delete($this->_table, 'id = :id', ['id' => $id]);
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
