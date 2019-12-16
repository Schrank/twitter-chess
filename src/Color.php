<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Color
{
    private const WHITE = 0;
    private const BLACK = 1;
    private int $color;

    private function __construct(int $color)
    {
        $this->color = $color;
    }

    public static function black(): Color
    {
        return new self(self::BLACK);
    }

    public static function white(): Color
    {
        return new self(self::WHITE);
    }

    public function isWhite(): bool
    {
        return $this->color === self::WHITE;
    }
}
