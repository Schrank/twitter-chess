<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Position;

class GameTest extends TestCase
{
    private Game $game;

    public function testNewGame(): void
    {
        $board = [
            '🗼🐴🧝🤴👸🧝🐴🗼',
            '💂💂💂💂💂💂💂💂',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '👮👮👮👮👮👮👮👮',
            '🏰🦥🏃🤵👰🏃🦥🏰',
        ];

        $this->validateBoardState($board);
    }

    /**
     * @param array $board
     */
    private function validateBoardState(array $board): void
    {
        $this->assertSame(
            $board,
            $this->game->getBoard()->toString()
        );
    }

    public function testMove(): void
    {
        $board = [
            '🗼🐴🧝🤴👸🧝🐴🗼',
            '💂💂💂💂💂💂💂💂',
            '⬜⬛⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '⬜👮⬜⬛⬜⬛⬜⬛',
            '⬛⬜⬛⬜⬛⬜⬛⬜',
            '👮⬛👮👮👮👮👮👮',
            '🏰🦥🏃🤵👰🏃🦥🏰',
        ];

        $this->game->move(new Position('B2'), new Position('B4'));
        $this->validateBoardState($board);
    }

    public function testGetCurrentPlayer(): void
    {
        $this->assertEquals(Color::white(), $this->game->getCurrentPlayer());
    }

    public function testPlayerChangesAfterMove(): void
    {
        $this->assertEquals(Color::white(), $this->game->getCurrentPlayer());
        $this->game->move(new Position('B2'), new Position('B4'));
        $this->assertEquals(Color::black(), $this->game->getCurrentPlayer());
    }

    public function testThrowsExceptionIfFigureIsNotFromCurrentPlayer()
    {
        $this->expectException(FigureDoesNotMatchPlayerException::class);
        $this->game->move(new Position('B7'), new Position('B6'));
    }

    protected function setUp(): void
    {
        $this->game = new Game();
    }
}
