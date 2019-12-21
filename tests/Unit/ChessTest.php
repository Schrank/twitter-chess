<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\InvalidGameConfigurationException;
use Schrank\TwitterChess\Exception\InvalidMoveException;

/**
 * @covers \Schrank\TwitterChess\Game
 */
class ChessTest extends TestCase
{
    private Game $game;
    private string $id;

    public function testReturnId(): void
    {
        $this->assertSame($this->id, $this->game->getId());
    }

    public function testThrowsExceptionOnMoveIfSquareIsEmpty(): void
    {
        $this->expectException(InvalidMoveException::class);
        $this->expectExceptionMessage('On square B6 is no figure.');
        $this->game->move(new Position('B6'), new Position('B6'));
    }

    public function testThrowsExceptionIfBoardWithoutPlayerIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);
        $this->expectExceptionMessage('If you pass a board, you need to pass two players as well.');

        new Game('', $this->createMock(Board::class));
    }

    public function testThrowsExceptionIfPlayersWithoutBoardIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);
        $this->expectExceptionMessage('If you pass a player, you need to pass a board.');

        new Game('', null, $this->createMock(Color::class));
    }

    public function testThrowsExceptionIfOnlyOnePlayerIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);

        new Game('', $this->createMock(Board::class), $this->createMock(Color::class));
    }

    protected function setUp(): void
    {
        $this->id      = uniqid('', true);
        $board         = $this->createMock(Board::class);
        $currentPlayer = Color::black();
        $secondPlayer  = Color::white();
        $this->game    = new Game($this->id, $board, $currentPlayer, $secondPlayer);
    }
}
