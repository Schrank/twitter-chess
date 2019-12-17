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
    private Figure $figure;
    protected static string $startPositionString = 'D4';
    protected static string $validMove = 'D5';
    protected static string $invalidMove = 'H8';
    private Position $startPosition;

    protected function setUp(): void
    {
        if (static::$testedClass === null) {
            throw new RuntimeException('$testedClass must be implemented.');
        }
        if (static::$blackIcon === null) {
            throw new RuntimeException('$blackIcon must be implemented.');
        }
        if (static::$whiteIcon === null) {
            throw new RuntimeException('$whiteIcon must be implemented.');
        }
        $this->startPosition = new Position(static::$startPositionString);
        $this->figure        = new static::$testedClass(
            $this->startPosition,
            Color::black()
        );

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

    public function testGetName(): void
    {
        $expected = basename(str_replace('\\', '/', get_class($this->figure)));

        $this->assertSame($expected, $this->figure->getName());
    }

    public function testValidMove()
    {
        $newPosition = new Position(static::$validMove);
        $oldPosition = $this->figure->getPosition();
        $this->figure->move($newPosition);
        $this->assertNotEquals($oldPosition, $newPosition);
    }
}
