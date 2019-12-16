<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Generator;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

abstract class AbstractFigureTest extends TestCase
{
    protected static string $testedClass;
    protected static string $whiteIcon;
    protected static string $blackIcon;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        if (static::$testedClass === null) {
            throw new RuntimeException('$testedClass must be implemented.');
        }
        if (static::$blackIcon === null) {
            throw new RuntimeException('$blackIcon must be implemented.');
        }
        if (static::$whiteIcon === null) {
            throw new RuntimeException('$whiteIcon must be implemented.');
        }
    }

    abstract public function validMoves(): Generator;

    /**
     * @dataProvider validMoves
     */
    public function testGetValidPositions($pos, $expected): void
    {
        /** @var Figure $figure */
        $figure    = new static::$testedClass(new Position($pos), Color::black());
        $positions = array_map(static function (Position $pos) {
            return $pos->toString();
        }, $figure->getValidPositions());

        $this->assertEqualsCanonicalizing($expected, $positions);
    }

    public function testGetIconForWhite(): void
    {
        /** @var Figure $figure */
        $figure = new static::$testedClass($this->createMock(Position::class), Color::white());
        $this->assertSame(static::$whiteIcon, $figure->getIcon());
    }

    public function testGetIconForBlack(): void
    {
        /** @var Figure $figure */
        $figure = new static::$testedClass($this->createMock(Position::class), Color::black());
        $this->assertSame(static::$blackIcon, $figure->getIcon());
    }
}
