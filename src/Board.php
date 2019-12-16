<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Board
{
    /*
     *    |  ROW
     *    ▽
     *  8
     *  7
     *  6
     *  5
     *  4
     *  3
     *  2
     *  1
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
