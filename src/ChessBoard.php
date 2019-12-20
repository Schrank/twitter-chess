<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\TwoFiguresOnSameSquare;

class ChessBoard implements \JsonSerializable, Board
{
    /**
     * @var Figure[]
     */
    private array $figures = [];

    public function addFigure(Figure $newFigure): void
    {
        foreach ($this->figures as $figure) {
            if ($figure->getPosition()->equals($newFigure->getPosition())) {
                throw new TwoFiguresOnSameSquare(
                    sprintf(
                        'Tried to add two figures (%s and %s) on same square %s',
                        $figure->getName(),
                        $newFigure->getName(),
                        $newFigure->getPosition()->toString()
                    )
                );
            }
        }
        $this->figures[] = $newFigure;
    }

    public function toArray(): array
    {
        $position = [];
        foreach ($this->figures as $figure) {
            $position[$figure->getPosition()->getColumn()][$figure->getPosition()->getRow()] = $figure->getIcon();
        }
        $board = [];
        $white = true;
        for ($row = 8; $row >= 1; $row--) {
            for ($column = 1; $column <= 8; $column++) {
                if (isset($position[$column][$row])) {
                    $board[] = $position[$column][$row];
                } else {
                    $board[] = $white ? '⬜' : '⬛';
                }
                $white = !$white;
            }
            $white = !$white;
        }

        return $board;
    }

    public function getFigureFromPosition(Position $position): ?Figure
    {
        foreach ($this->figures as $figure) {
            if ($figure->getPosition()->equals($position)) {
                return $figure;
            }
        }

        return null;
    }

    public function jsonSerialize(): string
    {
        $figures = [];
        foreach ($this->figures as $figure) {
            $figures[$figure->getPosition()->toString()] = $figure->getIcon();
        }

        return json_encode($figures);
    }
}
