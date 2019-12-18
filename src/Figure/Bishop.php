<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Exception\InvalidMoveException;
use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class Bishop extends AbstractFigure
{

    /**
     * @return Position[]
     */
    public function getValidPositions(Board $board): array
    {
        return array_merge(
            $this->generateMovesInOneDirection($board, -1, -8, 1),
            $this->generateMovesInOneDirection($board, -1, -8, -1),
            $this->generateMovesInOneDirection($board, 1, 8, 1),
            $this->generateMovesInOneDirection($board, 1, 8, -1)
        );
    }

    /**
     * @return Position[]
     */
    private function generateMovesInOneDirection(
        Board $board,
        int $rowColoumnAdditionStart,
        int $rowColoumnAdditionEnd,
        int $sign
    ): array {
        $validPositions = [];
        foreach (range($rowColoumnAdditionStart, $rowColoumnAdditionEnd) as $i) {
            try {
                $position = $this->generateValidPosition($i, $sign);

                $this->throwInvalidMoveExceptionOnBlockedSquare($board, $position);

                $validPositions[] = $position;
            } catch (InvalidMoveException $e) {
                // other figure blocks the way
                break;
            } catch (InvalidPositionException $e) {
                // Board ended
                break;
            }
        }

        return $validPositions;
    }

    private function generateValidPosition(int $rowsAndColumns, int $sign): Position
    {
        $position = Position::createFromInts(
            $this->position->getColumn() + $rowsAndColumns * $sign,
            $this->position->getRow() + $rowsAndColumns
        );
        if (!$position->equals($this->position)) {
            return $position;
        }
    }

    /**
     * @param Board    $board
     * @param Position $position
     */
    private function throwInvalidMoveExceptionOnBlockedSquare(Board $board, Position $position): void
    {
        if ($figure = $board->getFigureFromPosition($position)) {
            throw new InvalidMoveException(
                sprintf(
                    'Position %s is already used by %s (%s)',
                    $position->toString(),
                    $figure->getName(),
                    $figure->getColor()->toString()
                )
            );
        }
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '🏃';
        }

        return '🧝';

    }
}
