<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

/**
 * @covers \Schrank\TwitterChess\Figure\Bishop
 */
class BishopTest extends AbstractFigureTest
{
    protected static string $testedClass = Bishop::class;
    protected static string $whiteIcon = '🏃';
    protected static string $blackIcon = '🧝';
    protected static string $validMove = 'C5';

    public function validMoves(): Generator
    {
        yield ['B4', ['A5', 'A3', 'C5', 'D6', 'E7', 'F8', 'C3', 'D2', 'E1']];
        yield ['A1', ['B2', 'C3', 'D4', 'E5', 'F6', 'G7', 'H8']];
    }

    public function testGetValidPositionsWithBlockingOfSameColor(): void
    {
        $expected = ['C3', 'B2', 'A1', 'E3', 'F2', 'G1', 'E5', 'F6', 'G7', 'H8'];
        $board    = new Board();

        $wayBlockingFigureSameColor = $this->createMock(Figure::class);
        $wayBlockingFigureSameColor->method('getPosition')
            ->willReturn(new Position('C5'));
        $board->addFigure($wayBlockingFigureSameColor);
        /** @var Figure $figure */
        $bishop    = new Bishop(new Position('D4'), Color::black());
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $bishop->getValidPositions($board));

        $this->assertEqualsCanonicalizing($expected, $positions);
    }
}
