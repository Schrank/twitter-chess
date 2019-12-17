<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;

class QueenTest extends AbstractFigureTest
{
    protected static string $testedClass = Queen::class;
    protected static string $whiteIcon = '👰';
    protected static string $blackIcon = '👸';

    public function validMoves(): Generator
    {
        yield [
            'B4',
            [
                // Copied from Bishop
                'A5',
                'A3',
                'C5',
                'D6',
                'E7',
                'F8',
                'C3',
                'D2',
                'E1',
                // Copied from Rook
                'B1',
                'B2',
                'B3',
                'B5',
                'B6',
                'B7',
                'B8',
                'A4',
                'C4',
                'D4',
                'E4',
                'F4',
                'G4',
                'H4'
            ]
        ];
        yield [
            'A1',
            [
                // Copied from Bishop
                'B2',
                'C3',
                'D4',
                'E5',
                'F6',
                'G7',
                'H8',
                // Copied from Rook
                'A2',
                'A3',
                'A4',
                'A5',
                'A6',
                'A7',
                'A8',
                'B1',
                'C1',
                'D1',
                'E1',
                'F1',
                'G1',
                'H1'
            ]
        ];
    }
}
