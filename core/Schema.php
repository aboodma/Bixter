<?php

declare(strict_types=1);

namespace Bixter\Core;

class Schema
{
    public static function create(string $table, \Closure $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        Application::$db->query($blueprint->toSql(true));
    }

    public static function table(string $table, \Closure $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        Application::$db->query($blueprint->toSql(false));
    }

    public static function drop(string $table): void
    {
        Application::$db->query("DROP TABLE IF EXISTS `{$table}`");
    }

    public static function dropIfExists(string $table): void
    {
        Application::$db->query("DROP TABLE IF EXISTS `{$table}`");
    }

    public static function hasTable(string $table): bool
    {
        try {
            Application::$db->query("SELECT 1 FROM `{$table}` LIMIT 1");
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
