<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use ReflectionClass;
use Schrank\TwitterChess\Board;
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

    public function move(Position $position, Board $board): void
    {
        $valid = $this->isNewPositionValid($position, $board);

        if (!$valid) {
            $this->throwInvalidMoveException($position);
        }
        $this->position = $position;
    }

    private function isNewPositionValid(Position $position, Board $board): bool
    {
        $valid = false;
        foreach ($this->getValidPositions($board) as $validPosition) {
            if ($validPosition->equals($position)) {
                $valid = true;
                break;
            }
        }

        return $valid;
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

    public function getName(): string
    {
        if ($this->shortName === '') {
            $this->shortName = (new ReflectionClass($this))->getShortName();
        }

        return $this->shortName;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getColor(): Color
    {
        return $this->color;
    }
}
