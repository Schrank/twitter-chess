<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\TwoFiguresOnSameSquare;
use Schrank\TwitterChess\Figure\King;

/**
 * @covers \Schrank\TwitterChess\Board
 */
class ChessBoardTest extends TestCase
{

    private Board $board;

    public function testToString(): void
    {
        $board = require 'assertions/boardEmpty.php';
        $this->assertSame($board, $this->board->toArray());
    }

    public function testAddFigure(): void
    {
        $board  = require 'assertions/boardWithKingOnA1.php';
        $figure = new King(new Position('A1'), Color::black());
        $this->board->addFigure($figure);
        $this->assertEquals(
            $board,
            $this->board->toArray()
        );
    }

    public function testAddFigureOnSameSquare(): void
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
        $this->assertNull(
            $this->board->getFigureFromPosition($this->createMock(Position::class))
        );

    }

    public function testJsonSerializable(): void
    {
        $figure = $this->createFigure('♟', 'A1');
        $this->board->addFigure($figure);

        $figure = $this->createFigure('🎲', 'F6');
        $this->board->addFigure($figure);

        $expected = [
            'A1' => '♟',
            'F6' => '🎲',
        ];

        $this->assertEqualsCanonicalizing($expected, $this->board->getFiguresAsArray());
    }

    /**
     * @param string $icon
     * @param string $position
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|Figure
     */
    private function createFigure(string $icon, string $position)
    {
        $figure = $this->createMock(Figure::class);
        $figure->method('getIcon')->willReturn($icon);
        $figure->method('getPosition')->willReturn(new Position($position));

        return $figure;
    }

    protected function setUp(): void
    {
        $this->board = new Board();
    }
}
