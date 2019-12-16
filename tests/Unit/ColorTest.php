<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testIsWhite(): void
    {
        $color = Color::white();
        $this->assertTrue($color->isWhite());

        $color = Color::black();
        $this->assertFalse($color->isWhite());
    }
}
