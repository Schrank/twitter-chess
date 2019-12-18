<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Color
{
    public const WHITE = 'white';
    public const BLACK = 'black';
    private string $color;

    private function __construct(string $color)
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

    public function toString(): string
    {
        return $this->isWhite() ? 'white' : 'black';
    }
}
