<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

class Bishop implements Figure
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

        for ($rowsAndColumns = -8; $rowsAndColumns <= 8; $rowsAndColumns++) {
            try {
                $position = Position::createFromInts(
                    $this->position->getColumn() + $rowsAndColumns,
                    $this->position->getRow() + $rowsAndColumns
                );
                if (!$position->equals($this->position)) {
                    $validPositions[] = $position;
                }
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
            try {
                $position = Position::createFromInts(
                    $this->position->getColumn() - $rowsAndColumns,
                    $this->position->getRow() + $rowsAndColumns
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
