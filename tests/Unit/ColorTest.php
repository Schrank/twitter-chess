<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Schrank\TwitterChess\Color
 */
class ColorTest extends TestCase
{
    public function testIsWhite(): void
    {
        $color = Color::white();
        $this->assertTrue($color->isWhite());

        $color = Color::black();
        $this->assertFalse($color->isWhite());
    }

    public function testToString()
    {
        $this->assertSame('white', Color::white()->toString());
        $this->assertSame('black', Color::black()->toString());
    }
}
