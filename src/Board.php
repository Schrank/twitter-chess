<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Board
{
    /*
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

    /**
     * @return string[]
     */
    public function toString(): array
    {
        $board = [];
        $white = true;
        for ($i = 1; $i <= 8; $i++) {
            $row = '';
            for ($j = 1; $j <= 8; $j++) {
                $row   .= $white ? '⬜' : '⬛';
                $white = !$white;
            }
            $white   = !$white;
            $board[] = $row;
        }

        return $board;
    }
}
