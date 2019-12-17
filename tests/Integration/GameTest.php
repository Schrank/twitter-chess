<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Position;

class GameTest extends TestCase
{
    private Game $game;

    public function testNewGame(): void
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

        $this->validateBoardState($board);
    }

    /**
     * @param array $board
     */
    private function validateBoardState(array $board): void
    {
        $this->assertSame(
            $board,
            $this->game->getBoard()->toString()
        );
    }

    public function testMove(): void
    {
        $board = [
            '🗼🐴🧝🤴👸🧝🐴🗼',
            '💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼💂🏼',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜👮🏻⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '👮🏻⬛👮🏻👮🏻👮🏻👮🏻👮🏻👮🏻',
            '🏰🦥🏃🏼🤵🏼👰🏼🏃🏼🦥🏰',
        ];

        $this->game->move(new Position('B2'), new Position('B4'));
        $this->validateBoardState($board);
    }

    protected function setUp(): void
    {
        $this->game = new Game();
        $this->game->init();
    }
}
