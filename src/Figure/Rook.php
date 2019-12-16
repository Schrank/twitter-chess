<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Rook extends AbstractFigure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(): array
    {
        $validPositions = [];

        for ($rowOrColumn = 1; $rowOrColumn <= 8; $rowOrColumn++) {
            try {
                $position = Position::createFromInts(
                    $this->position->getColumn(),
                    $rowOrColumn
                );
                if (!$position->equals($this->position)) {
                    $validPositions[] = $position;
                }
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
            try {
                $position = Position::createFromInts(
                    $rowOrColumn,
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
