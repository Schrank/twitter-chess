<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use ReflectionClass;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

abstract class AbstractFigure implements Figure
{
    protected Position $position;
    protected Color $color;
    private string $shortName = '';

    public function __construct(Position $position, Color $color)
    {
        $this->position = $position;
        $this->color    = $color;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getName(): string
    {
        if ($this->shortName === '') {
            $this->shortName = (new ReflectionClass($this))->getShortName();
        }

        return $this->shortName;
    }

    public function move(Position $position)
    {
        $this->position = $position;
    }
}
