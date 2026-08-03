<?php

declare(strict_types=1);

namespace Bixter\Core;

class Blueprint
{
    private string $_table;
    private array $_columns = [];
    private array $_indexes = [];
    private array $_foreign = [];

    public function __construct(string $table)
    {
        $this->_table = $table;
    }

    public function id(): void
    {
        $this->_columns[] = '`id` INT AUTO_INCREMENT PRIMARY KEY';
    }

    public function string(string $name, int $length = 255, bool $nullable = false, $default = null): self
    {
        $this->addColumn($name, 'VARCHAR(' . $length . ')', $nullable, $default);
        return $this;
    }

    public function text(string $name, bool $nullable = false): self
    {
        $this->addColumn($name, 'TEXT', $nullable);
        return $this;
    }

    public function integer(string $name, bool $nullable = false, $default = null): self
    {
        $this->addColumn($name, 'INT', $nullable, $default);
        return $this;
    }

    public function boolean(string $name, bool $default = false): self
    {
        $this->addColumn($name, 'TINYINT(1)', false, $default ? 1 : 0);
        return $this;
    }

    public function timestamp(string $name, bool $nullable = false, $default = null): self
    {
        $this->addColumn($name, 'TIMESTAMP', $nullable, $default);
        return $this;
    }

    public function timestamps(): void
    {
        $this->timestamp('created_at', false, 'CURRENT_TIMESTAMP');
        $this->timestamp('updated_at', false, 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    public function unique(string ...$columns): self
    {
        $this->_indexes[] = 'UNIQUE KEY `' . implode('_', $columns) . '_unique` (`' . implode('`, `', $columns) . '`)';
        return $this;
    }

    public function index(string ...$columns): self
    {
        $this->_indexes[] = 'KEY `' . implode('_', $columns) . '_index` (`' . implode('`, `', $columns) . '`)';
        return $this;
    }

    public function foreign(string $column, string $references, string $on, string $onDelete = 'CASCADE'): self
    {
        $this->_foreign[] = "CONSTRAINT `{$this->_table}_{$column}_fk` FOREIGN KEY (`{$column}`) REFERENCES `{$on}` (`{$references}`) ON DELETE {$onDelete}";
        return $this;
    }

    public function dropColumn(string $name): void
    {
        $this->_columns[] = 'DROP COLUMN `' . $name . '`';
    }

    public function toSql(bool $create = true): string
    {
        if ($create) {
            $lines = array_merge($this->_columns, $this->_indexes, $this->_foreign);
            return 'CREATE TABLE IF NOT EXISTS `' . $this->_table . '` (' . implode(', ', $lines) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
        }

        $lines = array_merge($this->_columns, $this->_indexes, $this->_foreign);
        return 'ALTER TABLE `' . $this->_table . '` ' . implode(', ', $lines) . ';';
    }

    private function addColumn(string $name, string $type, bool $nullable, $default = null): void
    {
        $sql = "`{$name}` {$type}";
        if (!$nullable) {
            $sql .= ' NOT NULL';
        } else {
            $sql .= ' NULL';
        }
        if ($default !== null) {
            $sql .= ' DEFAULT ' . (is_string($default) ? "'{$default}'" : $default);
        }
        $this->_columns[] = $sql;
    }
}
