<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testNewGame()
    {
        $board = [
            '🗼🐴🧝🤴👸🧝🐴🗼',
            '💂🏼💂💂️💂🏼‍💂🏼💂🏼‍💂🏼‍💂‍',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '👮🏻‍👮🏻‍👮🏻👮🏻‍👮🏻‍👮🏻‍👮🏻‍👮🏻‍',
            '🏰🦥🏃🏼‍🤵🏼👰🏼🏃️🦥🏰',
        ];

        $game = new Game();
        #         $game->init();
        $this->assertSame(
            $board,
            $game->getBoard()->toString();
    );
    }
}
