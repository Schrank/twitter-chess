<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Exception\InvalidMoveException;

class ChessTest extends TestCase
{
    private Chess $game;
    private string $id;
    private Board $board;
    private $currentPlayer;

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

    protected function setUp(): void
    {
        $this->id            = uniqid('', true);
        $this->board         = $this->createMock(Board::class);
        $this->currentPlayer = Color::black();
        $this->game          = new Chess($this->id, $this->board, $this->currentPlayer);
    }
}
