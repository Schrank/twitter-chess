<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;

/**
 * @covers \Schrank\TwitterChess\Figure\King
 * @uses   \Schrank\TwitterChess\Position
 */
class KingTest extends AbstractFigureTest
{
    protected static string $testedClass = King::class;
    public function validMoves(): Generator
    {
        yield ['B4', ['A5', 'B5', 'C5', 'A4', 'C4', 'A3', 'B3', 'C3']];
        yield ['A1', ['A2', 'B2', 'B1']];
    }
}
