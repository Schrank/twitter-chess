<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;

class KnightTest extends AbstractFigureTest
{
    protected static string $testedClass = Knight::class;
    protected static string $whiteIcon = '🦥';
    protected static string $blackIcon = '🐴';
    protected static string $validMove = 'C6';

    public function validMoves(): Generator
    {
        yield ['C4', ['A3', 'A5', 'B2', 'B6', 'D2', 'D6', 'E3', 'E5']];
        yield ['A1', ['B3', 'C2']];
    }
}


