<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testGetColor()
    {
        $color = new Color(Color::BLACK);
        $this->assertSame(Color::BLACK, $color->getColor());
    }

    public function testIsWhite()
    {
        $color = new Color(Color::WHITE);
        $this->assertTrue($color->isWhite());

        $color = new Color(Color::BLACK);
        $this->assertFalse($color->isWhite());
    }
}
