<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

abstract class AbstractFigure implements Figure
{
    protected Position $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }
}
