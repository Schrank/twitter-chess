<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\Position;

/**
 * @uses   Board
 * @covers Chess
 */
class ChessTest extends TestCase
{
    private Chess $game;

    public function testNewGame(): void
    {
        $board = require 'assertions/boardAtStart.php';

        $this->validateBoardState($board);
    }

    /**
     * @param array $board
     */
    private function validateBoardState(array $board): void
    {
        $this->assertSame($board, $this->game->getBoard()->toArray());
    }

    public function testMove(): void
    {
        $board = require 'assertions/boardAfterMove.php';

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

    public function testThrowsExceptionIfFigureIsNotFromCurrentPlayer(): void
    {
        $this->expectException(FigureDoesNotMatchPlayerException::class);
        $this->game->move(new Position('B7'), new Position('B6'));
    }

    protected function setUp(): void
    {
        $this->game = new Chess(uniqid('', true));
    }
}
