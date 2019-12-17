<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;

/**
 * @covers \Schrank\TwitterChess\Figure\Bishop
 * @uses   \Schrank\TwitterChess\Position
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
}
