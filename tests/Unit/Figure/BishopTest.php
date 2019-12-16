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
class BishopTest extends TestCase
{
    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions($pos, $expected): void
    {
        $figure    = new Bishop(new Position($pos));
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function validMoves(): Generator
    {
        yield ['B4', ['A5', 'A3', 'C5', 'D6', 'E7', 'F8', 'C3', 'D2', 'E1']];
        yield ['A1', ['B2', 'C3', 'D4', 'E5', 'F6', 'G7', 'H8']];
    }
}
