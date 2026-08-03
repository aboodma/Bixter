<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class HelpersTest extends TestCase
{
    public function testHtmlEscape(): void
    {
        $this->assertSame('&lt;script&gt;', e('<script>'));
    }

    public function testRootHelper(): void
    {
        $this->assertStringContainsString('admin/login', root('admin/login'));
    }
}
