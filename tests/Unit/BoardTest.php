<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\EmptySquareException;
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

    public function testGetFigureFromPosition(): void
    {
        $position = new Position('A1');
        $figure   = new King($position, Color::black());
        $this->board->addFigure($figure);

        $this->assertSame(
            $figure,
            $this->board->getFigureFromPosition($position)
        );
    }

    public function testGetFigureFromPositionWithAnotherPosition(): void
    {
        $position1 = new Position('A1');
        $position2 = new Position('A1');
        $figure    = new King($position1, Color::black());
        $this->board->addFigure($figure);

        $this->assertSame(
            $figure,
            $this->board->getFigureFromPosition($position2)
        );
    }

    public function testGetFigureFromEmptySquare(): void
    {
        $this->expectException(EmptySquareException::class);

        /** @noinspection UnusedFunctionResultInspection */
        $this->board->getFigureFromPosition($this->createMock(Position::class));
    }

    public function testToArray(): void
    {
        $this->markTestIncomplete('Implement toArray method which has all figures in it and white/black squares or maybe null?');
    }

    protected function setUp(): void
    {
        $this->board = new Board();
    }
}
