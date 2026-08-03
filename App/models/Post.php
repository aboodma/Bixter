<?php

declare(strict_types=1);

namespace Bixter\App\Models;

use Bixter\Core\Model;
use Bixter\Core\Validator;
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
        $id = $data['id'] ?? null;
        $rules = [
            'title' => 'required|min:3',
            'slug' => 'required|regex:/^[a-z0-9-]+$/',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ];

        if ($id !== null) {
            $rules['slug'] .= '|unique:posts,slug,id,' . $id;
        } else {
            $rules['slug'] .= '|unique:posts,slug';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->_errors = $validator->errors();
            return false;
        }

        return true;
    }
}
