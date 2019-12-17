<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use ReflectionClass;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\InvalidMoveException;
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

    public function move(Position $position): void
    {
        $valid = $this->isNewPositionValid($position);

        if (!$valid) {
            $this->throwInvalidMoveException($position);
        }
        $this->position = $position;
    }

    private function throwInvalidMoveException(Position $position): void
    {
        throw new InvalidMoveException(
            sprintf(
                '%s can not move from %s to %s',
                $this->getName(),
                $this->getPosition()->toString(),
                $position->toString()
            )
        );
    }

    private function isNewPositionValid(Position $position): bool
    {
        $valid = false;
        foreach ($this->getValidPositions() as $validPosition) {
            if ($validPosition->equals($position)) {
                $valid = true;
                break;
            }
        }

        return $valid;
    }

    public function getColor(): Color
    {
        return $this->color;
    }
}
