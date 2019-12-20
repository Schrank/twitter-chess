<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\TwoFiguresOnSameSquare;

/**
 *    |  ROW
 *    ▽
 *  8   X   X   X   X
 *  7 X   X   X   X
 *  6   X   X   X   X
 *  5 X   X   X   X
 *  4   X   X   X   X
 *  3 X   X   X   X
 *  2   X   X   X   X
 *  1 X   X   X   X
 *    A B C D E F G H
 *    1 2 3 4 5 6 7 8
 *      COLUMN ->
 *
 * 🗼🐴🧝🤴👸🧛🐴🗼
 * 💂🏼💂🏼‍️💂🏼‍💂🏼💂🏼‍💂🏼‍💂🏼‍💂🏼‍
 * ⬛⬜⬛⬜⬛⬜⬛⬜
 * ⬜⬛⬜⬛⬜⬛⬜⬛
 * ⬛⬜⬛⬜⬛⬜⬛⬜
 * ⬜⬛⬜⬛⬜⬛⬜⬛
 * 👮🏻‍👮🏻‍👮🏻👮🏻‍👮🏻‍👮🏻‍👮🏻‍👮🏻‍
 * 🏰🦥🏃🏼‍🤵🏼👰🏼🏃️🦥🏰
 */
class Board implements \JsonSerializable
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

    /**
     * @return string[]
     */
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
