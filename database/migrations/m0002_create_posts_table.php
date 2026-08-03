<?php

declare(strict_types=1);

namespace Bixter\Database\Migrations;

use Bixter\Core\Migration;
use Bixter\Core\Schema;
use Bixter\Core\Blueprint;

class M0002CreatePostsTable extends Migration
{
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table): void {
            $table->id();
            $table->string('title')->index();
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->string('status', 50, false, 'draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('posts');
    }
}
