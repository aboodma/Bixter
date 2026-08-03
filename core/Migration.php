<?php

declare(strict_types=1);

namespace Bixter\Core;

abstract class Migration
{
    abstract public function up(): void;
    abstract public function down(): void;
}
