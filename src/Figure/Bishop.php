<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Bishop extends AbstractFigure
{

    /**
     * @return Position[]
     */
    public function getValidPositions(): array
    {
        $validPositions = [];

        for ($rowsAndColumns = -8; $rowsAndColumns <= 8; $rowsAndColumns++) {
            $validPositions[] = $this->generateValidPositions($rowsAndColumns, 1);
            $validPositions[] = $this->generateValidPositions($rowsAndColumns, -1);
        }

        return array_merge(...array_filter($validPositions));
    }

    /**
     * @return Position[]
     */
    private function generateValidPositions(int $rowsAndColumns, int $sign): array
    {
        $validPositions = [];
        try {
            $position = Position::createFromInts(
                $this->position->getColumn() + $rowsAndColumns * $sign,
                $this->position->getRow() + $rowsAndColumns
            );
            if (!$position->equals($this->position)) {
                $validPositions[] = $position;
            }
        } catch (InvalidPositionException $e) {
            // do nothing, invalid positions are discarded
        }

        return $validPositions;
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '🏃🏼';
        }

        return '🧝';

    }
}
