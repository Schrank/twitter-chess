<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{

    private Board $board;

    public function testToString(): void
    {
        $board = [
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
        ];
        $this->assertSame($board, $this->board->toString());
    }

    protected function setUp(): void
    {
        $this->board = new Board();
    }
}
