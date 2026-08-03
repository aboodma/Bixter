<?php

declare(strict_types=1);

namespace Bixter\App\Models;

use Bixter\Core\Model;
use Bixter\Core\Application;

class Post extends Model
{
    protected string $_table = 'posts';

    public function findPublished(): array
    {
        return Application::$db->table($this->_table)
            ->where('status', 'published')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->findOne('slug', $slug);
    }

    public function validate(array $data): bool
    {
        $this->_errors = [];

        if (empty($data['title']) || strlen($data['title']) < 3) {
            $this->_errors['title'] = 'Title must be at least 3 characters.';
        }

        if (empty($data['slug']) || !preg_match('/^[a-z0-9-]+$/', $data['slug'])) {
            $this->_errors['slug'] = 'Slug must contain only lowercase letters, numbers, and hyphens.';
        }

        if (empty($data['content'])) {
            $this->_errors['content'] = 'Content is required.';
        }

        if (!in_array($data['status'] ?? '', ['draft', 'published'])) {
            $this->_errors['status'] = 'Status must be draft or published.';
        }

        return !$this->hasErrors();
    }
}
