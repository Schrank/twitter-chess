<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Exception\InvalidGameConfigurationException;
use Schrank\TwitterChess\Figure\Pawn;
use Schrank\TwitterChess\Position;

/**
 * @covers \Schrank\TwitterChess\Game
 * @uses   \Schrank\TwitterChess\Board
 */
class ChessTest extends TestCase
{
    private Game $game;

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

    public function testReturnsSamePlayersAsOnConstruct(): void
    {
        $current = Color::white();
        $second  = Color::black();

        $board = new Board();
        $board->addFigure(new Pawn(new Position('B2'), $current));
        $game = new Game('123', $board, $current, $second);

        $this->assertSame($current, $game->getCurrentPlayer());
        $game->move(new Position('B2'), new Position('B4'));
        $this->assertSame($second, $game->getCurrentPlayer());
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

    public function testUnserializeSerializeGivesSameResult(): void
    {
        $this->markTestIncomplete('Implement me!');
    }

    protected function setUp(): void
    {
        $this->game = new Game(uniqid('', true));
    }
}
