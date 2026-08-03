<?php

declare(strict_types=1);

namespace Bixter\Core;

class Kernel
{
    public static function handle(): void
    {
        $request = new Request();

        ob_start();
        $matched = Router::dispatch($request);
        $content = ob_get_clean() ?: '';

        $response = new Response($content, $matched ? 200 : 404);
        $response->send();
    }
}
