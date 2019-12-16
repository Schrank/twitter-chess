<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

abstract class AbstractFigure implements Figure
{
    protected Position $position;
    protected Color $color;

    public function __construct(Position $position, Color $color)
    {
        $this->position = $position;
        $this->color    = $color;
    }
}
