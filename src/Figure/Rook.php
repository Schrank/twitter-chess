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
            $validPositions[] = $this->createNewRookPosition($this->position->getColumn(), $rowOrColumn);
            $validPositions[] = $this->createNewRookPosition($rowOrColumn, $this->position->getRow());
        }

        return array_filter($validPositions);
    }

    private function createNewRookPosition(int $column, int $row): ?Position
    {
        try {
            $position = Position::createFromInts($column, $row);
            if (!$position->equals($this->position)) {
                return $position;
            }
        } catch (InvalidPositionException $e) {
            // do nothing, invalid positions are discarded
        }

        return null;
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '🏰';
        }

        return '🗼';

    }
}
