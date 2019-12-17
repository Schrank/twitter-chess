<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Game;

class GameTest extends TestCase
{
    public function testNewGame()
    {
        $board = [
            '🗼🐴🧝🤴👸🧝🐴🗼',
            '💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '👮🏻👮🏻👮🏻👮🏻👮🏻👮🏻👮🏻👮🏻',
            '🏰🦥🏃🏼🤵🏼👰🏼🏃🏼🦥🏰',
        ];

        $game = new Game();
        $game->init();
        $this->assertSame(
            $board,
            $game->getBoard()->toString()
        );
    }
}
