<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Queen extends AbstractFigure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(): array
    {
        return array_merge(
            $this->getRookPositions(),
            $this->getBishopPositions()
        );
    }

    /**
     * @return Position[]
     */
    private function getBishopPositions(): array
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

    /**
     * @return Position[]
     */
    private function getRookPositions(): array
    {
        $validPositions = [];

        for ($rowOrColumn = 1; $rowOrColumn <= 8; $rowOrColumn++) {
            $validPositions[] = $this->createNewRookPosition($this->position->getColumn(), $rowOrColumn);
            $validPositions[] = $this->createNewRookPosition($rowOrColumn, $this->position->getRow());
        }

        return array_filter($validPositions);
    }

    private function createNewRookPosition(int $newColumn, int $newRow): ?Position
    {
        try {
            $position = Position::createFromInts(
                $newColumn,
                $newRow
            );
            if (!$position->equals($this->position)) {
                return $position;
            }
        } catch (InvalidPositionException $e) {
            // do nothing, invalid positions are discarded
        }

        return null;
    }
}
