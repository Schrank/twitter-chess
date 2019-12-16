<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Position;

/**
 * @covers \Schrank\TwitterChess\Figure\King
 * @uses   \Schrank\TwitterChess\Position
 */
class KingTest extends TestCase
{
    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions($pos, $expected): void
    {
        $figure    = new King(new Position($pos));
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function validMoves(): Generator
    {
        yield ['B4', ['A5', 'B5', 'C5', 'A4', 'C4', 'A3', 'B3', 'C3']];
        yield ['A1', ['A2', 'B2', 'B1']];
    }
}
