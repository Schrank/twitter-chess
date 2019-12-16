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
     * @param array $validPositions
     *
     * @return array
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

    private function getRookPositions()
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
