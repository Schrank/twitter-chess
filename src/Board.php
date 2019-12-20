<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

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
interface Board
{
    public function addFigure(Figure $newFigure): void;

    /**
     * @return string[]
     */
    public function toArray(): array;

    public function getFigureFromPosition(Position $position): ?Figure;

    public function jsonSerialize(): string;
}
