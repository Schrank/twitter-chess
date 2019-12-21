<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\InvalidGameConfigurationException;
use Schrank\TwitterChess\Exception\InvalidMoveException;

/**
 * @covers \Schrank\TwitterChess\Chess
 */
class ChessTest extends TestCase
{
    private Chess $game;
    private string $id;
    private ChessBoard $board;
    private Color $currentPlayer;
    private Color $secondPlayer;

    public function testInstanceOfJsonSerializable(): void
    {
        $this->assertInstanceOf(\JsonSerializable::class, $this->game);
    }

    public function testReturnId()
    {
        $this->assertSame($this->id, $this->game->getId());
    }

    public function testThrowsExceptionOnMoveIfSquareIsEmpty(): void
    {
        $this->expectException(InvalidMoveException::class);
        $this->expectExceptionMessage('On square B6 is no figure.');
        $this->game->move(new Position('B6'), new Position('B6'));
    }

    public function testJsonSerializeable(): void
    {
        $boardSerialized = 'board123';
        $expected        = [
            'board'         => $boardSerialized,
            'currentPlayer' => $this->currentPlayer->toString(),
            'id'            => $this->id
        ];

        $this->board->method('jsonSerialize')->willReturn($boardSerialized);

        $this->assertSame(
            $expected,
            json_decode($this->game->jsonSerialize(), true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function testThrowsExceptionIfBoardWithoutPlayerIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);
        $this->expectExceptionMessage('If you pass a board, you need to pass two players as well.');

        new Chess('', $this->createMock(ChessBoard::class));
    }

    public function testThrowsExceptionIfPlayersWithoutBoardIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);
        $this->expectExceptionMessage('If you pass a player, you need to pass a board.');

        new Chess('', null, $this->createMock(Color::class));
    }

    public function testThrowsExceptionIfOnlyOnePlayerIsPassed(): void
    {
        $this->expectException(InvalidGameConfigurationException::class);

        new Chess('', $this->createMock(ChessBoard::class), $this->createMock(Color::class));
    }

    protected function setUp(): void
    {
        $this->id            = uniqid('', true);
        $this->board         = $this->createMock(ChessBoard::class);
        $this->currentPlayer = Color::black();
        $this->secondPlayer  = Color::white();
        $this->game          = new Chess($this->id, $this->board, $this->currentPlayer, $this->secondPlayer);
    }
}
