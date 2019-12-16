<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

class PawnTest extends TestCase
{
    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions(int $color, $pos, $expected): void
    {
        /** @var Figure $figure */
        $figure    = new Pawn(new Position($pos), new Color($color));
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function validMoves(): Generator
    {
        yield [Color::WHITE, 'B2', ['B3', 'B4']];
        yield [Color::WHITE, 'E4', ['E5']];
        yield [Color::WHITE, 'E8', []];

        yield [Color::BLACK, 'B2', ['B1']];
        yield [Color::BLACK, 'E4', ['E3']];
        yield [Color::BLACK, 'E7', ['E6', 'E5']];
    }
}
