<?php

declare(strict_types=1);

namespace Bixter\Database\Migrations;

use Bixter\Core\Migration;
use Bixter\Core\Schema;
use Bixter\Core\Blueprint;

class M0001CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table): void {
            $table->id();
            $table->string('username')->index();
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->string('role', 50, false, 'user');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('users');
    }
}
