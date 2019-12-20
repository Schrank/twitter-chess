<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\ChessBoard;
use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Pawn extends AbstractFigure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(Board $board): array
    {
        $validMoves = [];
        if ($this->position->getRow() === $this->getPawnRow()) {
            try {
                $validMoves[] = $this->createNewPosition($this->isWhite() ? 2 : -2);
            } catch (InvalidPositionException $e) {
                // do nothing, invalid positions are discarded
            }
        }
        try {
            $validMoves[] = $this->createNewPosition($this->isWhite() ? 1 : -1);
        } catch (InvalidPositionException $e) {
            // do nothing, invalid positions are discarded
        }

        return $validMoves;
    }

    private function createNewPosition(int $columnIncrease): Position
    {
        return Position::createFromInts($this->position->getColumn(), $this->position->getRow() + $columnIncrease);
    }

    private function getPawnRow(): int
    {
        return $this->color->isWhite() ? 2 : 7;
    }

    private function isWhite(): bool
    {
        return $this->color->isWhite();
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '👮';
        }

        return '💂';

    }
}
