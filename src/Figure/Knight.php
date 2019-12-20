<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\ChessBoard;
use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Knight extends AbstractFigure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(Board $board): array
    {
        $validMoves     = [
            [2, 1],
            [1, 2],
            [-2, 1],
            [-1, 2],
            [2, -1],
            [1, -2],
            [-2, -1],
            [-1, -2],
        ];
        $validPositions = [];
        foreach ($validMoves as $move) {
            [$column, $row] = $move;
            try {
                $validPositions[] = Position::createFromInts(
                    $this->position->getColumn() + $column,
                    $this->position->getRow() + $row
                );
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
        }

        return $validPositions;
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '🦥';
        }

        return '🐴';

    }
}
