<?php

declare(strict_types=1);

namespace Bixter\Core;

class QueryBuilder
{
    private Database $_db;
    private string $_table;
    private array $_select = ['*'];
    private array $_where = [];
    private array $_params = [];
    private array $_joins = [];
    private array $_orderBy = [];
    private ?int $_limit = null;
    private ?int $_offset = null;
    private ?string $_groupBy = null;

    public function __construct(Database $db, string $table)
    {
        $this->_db = $db;
        $this->_table = $table;
    }

    public function select(array $columns): self
    {
        $this->_select = $columns;
        return $this;
    }

    public function where(string $column, mixed $value, string $operator = '='): self
    {
        $placeholder = $this->placeholder($column);
        $this->_where[] = "`{$column}` {$operator} :{$placeholder}";
        $this->_params[$placeholder] = $value;
        return $this;
    }

    public function whereIn(string $column, array $values): self
    {
        if (empty($values)) {
            $this->_where[] = '1 = 0';
            return $this;
        }
        $placeholders = [];
        foreach ($values as $i => $value) {
            $placeholder = $this->placeholder($column) . '_' . $i;
            $placeholders[] = ':' . $placeholder;
            $this->_params[$placeholder] = $value;
        }
        $this->_where[] = "`{$column}` IN (" . implode(', ', $placeholders) . ')';
        return $this;
    }

    public function whereNotIn(string $column, array $values): self
    {
        $placeholders = [];
        foreach ($values as $i => $value) {
            $placeholder = $this->placeholder($column) . '_' . $i;
            $placeholders[] = ':' . $placeholder;
            $this->_params[$placeholder] = $value;
        }
        $this->_where[] = "`{$column}` NOT IN (" . implode(', ', $placeholders) . ')';
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): self
    {
        $this->_joins[] = "{$type} JOIN `{$table}` ON {$first} {$operator} {$second}";
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->_orderBy[] = "`{$column}` {$direction}";
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): self
    {
        $this->_limit = $limit;
        $this->_offset = $offset;
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->_groupBy = $column;
        return $this;
    }

    public function get(): array
    {
        $sql = $this->buildSelect();
        $stmt = $this->_db->query($sql, $this->_params);
        return $stmt->fetchAll();
    }

    public function first(): ?array
    {
        $this->_limit = 1;
        $rows = $this->get();
        return $rows[0] ?? null;
    }

    public function count(): int
    {
        $this->_select = ['COUNT(*) as c'];
        $row = $this->first();
        return (int) ($row['c'] ?? 0);
    }

    public function find(int $id): ?array
    {
        return $this->where('id', $id)->first();
    }

    public function insert(array $data): int
    {
        $columns = implode('`, `', array_keys($data));
        $placeholders = [];
        foreach (array_keys($data) as $key) {
            $placeholder = $this->placeholder($key);
            $placeholders[] = ':' . $placeholder;
            $this->_params[$placeholder] = $data[$key];
        }
        $sql = "INSERT INTO `{$this->_table}` (`{$columns}`) VALUES (" . implode(', ', $placeholders) . ')';
        $this->_db->query($sql, $this->_params);
        return (int) $this->_db->getPdo()->lastInsertId();
    }

    public function update(array $data): int
    {
        $sets = [];
        foreach ($data as $key => $value) {
            $placeholder = $this->placeholder($key);
            $sets[] = "`{$key}` = :{$placeholder}";
            $this->_params[$placeholder] = $value;
        }
        $sql = "UPDATE `{$this->_table}` SET " . implode(', ', $sets) . $this->buildWhere();
        $stmt = $this->_db->query($sql, $this->_params);
        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql = "DELETE FROM `{$this->_table}`" . $this->buildWhere();
        $stmt = $this->_db->query($sql, $this->_params);
        return $stmt->rowCount();
    }

    private function buildSelect(): string
    {
        $columns = implode(', ', array_map(static fn ($col) => $col === '*' ? $col : "`{$col}`", $this->_select));
        $sql = "SELECT {$columns} FROM `{$this->_table}`";
        $sql .= $this->buildJoins();
        $sql .= $this->buildWhere();
        if ($this->_groupBy) {
            $sql .= " GROUP BY `{$this->_groupBy}`";
        }
        $sql .= $this->buildOrderBy();
        $sql .= $this->buildLimit();
        return $sql;
    }

    private function buildWhere(): string
    {
        return empty($this->_where) ? '' : ' WHERE ' . implode(' AND ', $this->_where);
    }

    private function buildJoins(): string
    {
        return empty($this->_joins) ? '' : ' ' . implode(' ', $this->_joins);
    }

    private function buildOrderBy(): string
    {
        return empty($this->_orderBy) ? '' : ' ORDER BY ' . implode(', ', $this->_orderBy);
    }

    private function buildLimit(): string
    {
        $sql = '';
        if ($this->_limit !== null) {
            $sql .= ' LIMIT ' . $this->_limit;
        }
        if ($this->_offset !== null) {
            $sql .= ' OFFSET ' . $this->_offset;
        }
        return $sql;
    }

    private function placeholder(string $column): string
    {
        return str_replace(['`', '.', ' '], '_', $column);
    }
}
