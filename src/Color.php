<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Color
{
    public const WHITE = 0;
    public const BLACK = 1;
    private int $color;

    public function __construct(int $color)
    {
        $this->color = $color;
    }

    public function getColor(): int
    {
        return $this->color;
    }

    public function isWhite()
    {
        return $this->color === self::WHITE;
    }
}
