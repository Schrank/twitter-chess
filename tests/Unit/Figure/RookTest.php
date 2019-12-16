<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Position;

class RookTest extends TestCase
{
    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions($pos, $expected): void
    {
        $figure    = new Rook(new Position($pos));
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function validMoves(): Generator
    {
        yield ['B4', ['B1', 'B2', 'B3', 'B5', 'B6', 'B7', 'B8', 'A4', 'C4', 'D4', 'E4', 'F4', 'G4', 'H4']];
        yield ['A1', ['A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1']];
    }
}
