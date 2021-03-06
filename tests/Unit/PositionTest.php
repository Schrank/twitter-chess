<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\InvalidPositionException;

/**
 * @covers \Schrank\TwitterChess\Position
 */
class PositionTest extends TestCase
{
    /**
     * @dataProvider validPositions
     */
    public function testValidPositions(string $pos): void
    {
        $p = new Position($pos);
        $this->assertInstanceOf(Position::class, $p);
    }

    /**
     * @dataProvider invalidPositions
     */
    public function testInvalidPositions(string $pos): void
    {
        $this->expectException(InvalidPositionException::class);
        new Position($pos);
    }

    /**
     * @dataProvider validPositions
     */
    public function testToString(string $pos): void
    {
        $p = new Position($pos);
        $this->assertSame($pos, $p->toString());
    }

    public function validPositions(): Generator
    {
        yield ['A1', 1, 1];
        yield ['B2', 2, 2];
        yield ['H1', 8, 1];
        yield ['H8', 8, 8];
        yield ['A8', 1, 8];
    }

    public function invalidPositions(): Generator
    {
        yield [''];
        yield ['7'];
        yield ['ö'];
        yield ['-1'];
        yield ['A-1'];
        yield ['A9'];
        yield ['I1'];
        yield ['H9'];
        yield ['Z9'];
    }

    public function invalidIntPositions(): Generator
    {
        yield [-9, 1];
        yield [-1, 1];
        yield [1, -1];
        yield [1, 9];
        yield [-1, 9];
        yield [9, 9];
        yield [-1, -1];
    }

    /**
     * @dataProvider invalidIntPositions
     */
    public function testCreateFromInts(int $column, int $row): void
    {
        $this->expectException(InvalidPositionException::class);
        Position::createFromInts($column, $row);
    }

    /**
     * @dataProvider validPositions
     */
    public function testToIntArray($pos, $column, $row)
    {
        $p = new Position($pos);
        $this->assertSame([$column, $row], $p->toIntArray());
    }

    public function testGetColumn(): void
    {
        $p = new Position('B3');
        $this->assertSame(2, $p->getColumn());
    }

    public function testGetRow(): void
    {
        $p = new Position('B3');
        $this->assertSame(3, $p->getRow());
    }

    public function testEquals(): void
    {
        $b3 = new Position('B3');
        $this->assertTrue($b3->equals(new Position('B3')));

        $this->assertFalse($b3->equals(new Position('B2')));
        $this->assertFalse($b3->equals(new Position('A2')));
        $this->assertFalse($b3->equals(new Position('H8')));
        $this->assertFalse($b3->equals(new Position('F4')));
        $this->assertFalse($b3->equals(new Position('D5')));
    }
}
