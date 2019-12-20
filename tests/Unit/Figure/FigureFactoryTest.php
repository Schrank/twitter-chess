<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;

class FigureFactoryTest extends TestCase
{
    private Color $blackPlayer;
    private Color $whitePlayer;
    private FigureFactory $factory;

    /**
     * @dataProvider iconToFigureAndColorMapping
     */
    public function testCreateFromIcon(string $icon, string $pos, string $class, Color $color): void
    {
        $figure = $this->factory->createFromIcon($icon, $pos);
        $this->assertSame($class, get_class($figure));
        $this->assertSame($color->isWhite(), $figure->getColor()->isWhite());
        $this->assertSame($pos, $figure->getPosition()->toString());
    }

    /**
     * @return mixed[]
     */
    public function iconToFigureAndColorMapping(): ?\Generator
    {
        yield ['🏃', 'A6', Bishop::class, Color::white()];
        yield ['🧝', 'A7', Bishop::class, Color::black()];

        yield ['🤵', 'H3', King::class, Color::white()];
        yield ['🤴', 'D5', King::class, Color::black()];

        yield ['🏰', 'E6', Rook::class, Color::white()];
        yield ['🗼', 'C6', Rook::class, Color::black()];

        yield ['👰', 'H1', Queen::class, Color::white()];
        yield ['👸', 'H5', Queen::class, Color::black()];

        yield ['👮', 'F2', Pawn::class, Color::white()];
        yield ['💂', 'E5', Pawn::class, Color::black()];

        yield ['🦥', 'G4', Knight::class, Color::white()];
        yield ['🐴', 'B6', Knight::class, Color::black()];
    }

    protected function setUp(): void
    {
        $this->blackPlayer = Color::black();
        $this->whitePlayer = Color::white();
        $this->factory     = new FigureFactory($this->whitePlayer, $this->blackPlayer);
    }
}
