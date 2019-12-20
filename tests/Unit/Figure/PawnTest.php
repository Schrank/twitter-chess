<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

/**
 * @covers \Schrank\TwitterChess\Figure\Pawn
 */
class PawnTest extends TestCase
{
    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions(Color $color, $pos, $expected): void
    {
        /** @var Figure $figure */
        $figure    = new Pawn(new Position($pos), $color);
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions($this->createMock(Board::class)));

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function validMoves(): Generator
    {
        yield [Color::white(), 'B2', ['B3', 'B4']];
        yield [Color::white(), 'E4', ['E5']];
        yield [Color::white(), 'E8', []];

        yield [Color::black(), 'B2', ['B1']];
        yield [Color::black(), 'E4', ['E3']];
        yield [Color::black(), 'E7', ['E6', 'E5']];
    }
}
