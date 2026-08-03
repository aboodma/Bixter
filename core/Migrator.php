<?php

declare(strict_types=1);

namespace Bixter\Core;

class Migrator
{
    private string $_path;

    public function __construct(string $path = '')
    {
        $this->_path = $path ?: ROOT . DS . 'database' . DS . 'migrations';
    }

    public function run(): void
    {
        $this->_ensureMigrationsTable();
        $files = $this->_migrationFiles();

        foreach ($files as $file) {
            $name = basename($file, '.php');
            if ($this->_ran($name)) {
                continue;
            }

            require_once $file;
            $class = $this->_className($name);
            if (!class_exists($class)) {
                throw new \Exception("Migration class {$class} not found in {$file}");
            }

            /** @var Migration $migration */
            $migration = new $class();
            $migration->up();
            $this->_record($name);
            echo "Migrated: {$name}\n";
        }

        echo "Migrations complete.\n";
    }

    public function rollback(): void
    {
        $this->_ensureMigrationsTable();
        $rows = $this->_pendingRollbacks();

        foreach (array_reverse($rows) as $row) {
            $file = $this->_path . DS . $row['migration'] . '.php';
            if (!file_exists($file)) {
                continue;
            }
            require_once $file;
            $class = $this->_className($row['migration']);
            if (!class_exists($class)) {
                continue;
            }

            /** @var Migration $migration */
            $migration = new $class();
            $migration->down();
            $this->_remove($row['migration']);
            echo "Rolled back: {$row['migration']}\n";
        }

        echo "Rollback complete.\n";
    }

    public function status(): array
    {
        $this->_ensureMigrationsTable();
        $files = $this->_migrationFiles();
        $ran = $this->_ranMigrations();

        $status = [];
        foreach ($files as $file) {
            $name = basename($file, '.php');
            $status[] = [
                'migration' => $name,
                'ran' => in_array($name, $ran, true),
            ];
        }
        return $status;
    }

    private function _migrationFiles(): array
    {
        if (!is_dir($this->_path)) {
            return [];
        }
        $files = glob($this->_path . DS . '*.php') ?: [];
        sort($files);
        return $files;
    }

    private function _ensureMigrationsTable(): void
    {
        Schema::create('migrations', static function (Blueprint $table): void {
            $table->id();
            $table->string('migration');
            $table->timestamp('created_at');
        });
    }

    private function _ran(string $name): bool
    {
        $row = Application::$db->table('migrations')->where('migration', $name)->first();
        return $row !== null;
    }

    private function _record(string $name): void
    {
        Application::$db->table('migrations')->insert(['migration' => $name, 'created_at' => date('Y-m-d H:i:s')]);
    }

    private function _remove(string $name): void
    {
        Application::$db->table('migrations')->where('migration', $name)->delete();
    }

    private function _ranMigrations(): array
    {
        return array_column(Application::$db->table('migrations')->orderBy('id')->get(), 'migration');
    }

    private function _pendingRollbacks(): array
    {
        return Application::$db->table('migrations')->orderBy('id', 'DESC')->limit(1)->get();
    }

    private function _className(string $file): string
    {
        $name = str_replace('_', '', $file);
        return 'Bixter\\Database\\Migrations\\' . $name;
    }
}
