<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

class Queen implements Figure
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
