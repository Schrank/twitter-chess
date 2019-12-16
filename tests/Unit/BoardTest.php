<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\TwoFiguresOnSameSquare;
use Schrank\TwitterChess\Figure\King;

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

    public function testAddFigure()
    {
        $board  = [
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '🤴⬜⬛⬜⬛⬜⬛⬜',
        ];
        $figure = new King(new Position('A1'), Color::black());
        $this->board->addFigure($figure);
        $this->assertEquals(
            $board,
            $this->board->toString()
        );
    }

    public function testAddFigureOnSameSquare()
    {
        $this->expectException(TwoFiguresOnSameSquare::class);

        $figure = new King(new Position('A1'), Color::black());
        $this->board->addFigure($figure);
        $this->board->addFigure($figure);
    }

    protected function setUp(): void
    {
        $this->board = new Board();
    }
}
