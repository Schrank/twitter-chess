<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Generator;
use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\InvalidPositionException;

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
        yield ['A1'];
        yield ['B2'];
        yield ['H1'];
        yield ['H8'];
        yield ['A8'];
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

    public function testCreationByIntegers()
    {
        $pos = Position::createFromInts(1, 1,);
        $this->assertInstanceOf(Position::class, $pos);
    }
}
