<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

class Rook implements Figure
{
    private Position $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    /**
     * @return Position[]
     */
    public function getValidPositions(): array
    {
        $validPositions = [];

        for ($row = 1; $row <= 8; $row++) {
            try {
                $position = Position::createFromInts(
                    $this->position->getColumn(),
                    $row
                );
                if (!$position->equals($this->position)) {
                    $validPositions[] = $position;
                }
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
        }

        for ($column = 1; $column <= 8; $column++) {
            try {
                $position = Position::createFromInts(
                    $column,
                    $this->position->getRow()
                );
                if (!$position->equals($this->position)) {
                    $validPositions[] = $position;
                }
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
        }

        return $validPositions;
    }
}
