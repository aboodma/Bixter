<?php

declare(strict_types=1);

namespace Bixter\App\Middleware;

use Bixter\Core\Application;
use Bixter\Core\Request;

class AuthMiddleware
{
    public function handle(Request $request): void
    {
        if (!Application::$session->has('user_id')) {
            redirect(root('admin/login'));
        }
    }
}
