<?php

declare(strict_types=1);

namespace Bixter\Core;

class Database
{
    private ?\PDO $_pdo = null;

    public function getPdo(): \PDO
    {
        if ($this->_pdo === null) {
            $dsn = 'mysql:host=' . DB_SERVER . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                $this->_pdo = new \PDO($dsn, DB_USER, DB_PASSWORD, $options);
            } catch (\PDOException $e) {
                if (DEBUG) {
                    die('Database connection failed: ' . $e->getMessage());
                }
                die('Database connection failed.');
            }
        }

        return $this->_pdo;
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode('`, `', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO `{$table}` (`{$columns}`) VALUES ({$placeholders})";
        $this->query($sql, $data);
        return (int) $this->getPdo()->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams): int
    {
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "`{$key}` = :{$key}";
        }
        $setSql = implode(', ', $set);
        $sql = "UPDATE `{$table}` SET {$setSql} WHERE {$where}";
        $this->query($sql, array_merge($data, $whereParams));
        return $this->query("SELECT ROW_COUNT() as c")->fetch()['c'] ?? 0;
    }

    public function delete(string $table, string $where, array $params): int
    {
        $sql = "DELETE FROM `{$table}` WHERE {$where}";
        $this->query($sql, $params);
        return $this->query("SELECT ROW_COUNT() as c")->fetch()['c'] ?? 0;
    }
}
