<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

abstract class AbstractFigureTest extends TestCase
{
    protected static string $testedClass;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        if (static::$testedClass === null) {
            throw new \RuntimeException('$testedClass must be implemented.');
        }
    }

    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions($pos, $expected): void
    {
        /** @var Figure $figure */
        $figure    = new static::$testedClass(new Position($pos), new Color(Color::BLACK));
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    abstract public function validMoves(): Generator;
}
