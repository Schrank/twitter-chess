<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Exception\InvalidGameConfigurationException;
use Schrank\TwitterChess\Exception\InvalidMoveException;
use Schrank\TwitterChess\Figure\Bishop;
use Schrank\TwitterChess\Figure\King;
use Schrank\TwitterChess\Figure\Knight;
use Schrank\TwitterChess\Figure\Pawn;
use Schrank\TwitterChess\Figure\Queen;
use Schrank\TwitterChess\Figure\Rook;

class Game
{
    /**
     * @var Color[]
     */
    private array $players;
    private Color $currentPlayer;
    private Board $board;
    private string $id;

    /**
     * @var string[]
     */
    private array $startBoard
        = [
            Color::WHITE => [
                'A1' => Rook::class,
                'B1' => Knight::class,
                'C1' => Bishop::class,
                'D1' => King::class,
                'E1' => Queen::class,
                'F1' => Bishop::class,
                'G1' => Knight::class,
                'H1' => Rook::class,
                'A2' => Pawn::class,
                'B2' => Pawn::class,
                'C2' => Pawn::class,
                'D2' => Pawn::class,
                'E2' => Pawn::class,
                'F2' => Pawn::class,
                'G2' => Pawn::class,
                'H2' => Pawn::class,
            ],
            Color::BLACK => [
                'A8' => Rook::class,
                'B8' => Knight::class,
                'C8' => Bishop::class,
                'D8' => King::class,
                'E8' => Queen::class,
                'F8' => Bishop::class,
                'G8' => Knight::class,
                'H8' => Rook::class,
                'A7' => Pawn::class,
                'B7' => Pawn::class,
                'C7' => Pawn::class,
                'D7' => Pawn::class,
                'E7' => Pawn::class,
                'F7' => Pawn::class,
                'G7' => Pawn::class,
                'H7' => Pawn::class,
            ],
        ];

    public function __construct(
        string $id,
        Board $board = null,
        Color $currentPlayer = null,
        Color $secondPlayer = null
    ) {
        $this->validate($board, $currentPlayer, $secondPlayer);
        $this->initPlayers($currentPlayer, $secondPlayer);
        $this->initBoard($board);

        $this->id = $id;
    }

    private function validate(?Board $board, ?Color $first, ?Color $second): void
    {
        if ($board !== null && ($first === null || $second === null)) {
            throw new InvalidGameConfigurationException('If you pass a board, you need to pass two players as well.');
        }
        if (($first !== null || $second !== null) && $board === null) {
            throw new InvalidGameConfigurationException('If you pass a player, you need to pass a board.');
        }
        if (($first === null && $second !== null) || ($second === null && $first !== null)) {
            throw new InvalidGameConfigurationException(
                'If you pass a player, you need to pass a second player as well.'
            );
        }
    }

    private function initPlayers(?Color $currentPlayer, ?Color $secondPlayer): void
    {
        $this->currentPlayer = $currentPlayer ?? Color::white();
        $secondPlayer        = $secondPlayer ?? Color::black();

        $this->players = [
            Color::WHITE => $this->currentPlayer->isWhite() ? $this->currentPlayer : $secondPlayer,
            Color::BLACK => !$this->currentPlayer->isWhite() ? $this->currentPlayer : $secondPlayer,
        ];
    }

    private function initBoard(?Board $board): void
    {
        if ($board !== null) {
            /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
            $this->board = $board;

            return;
        }
        $this->board = new Board();
        foreach ($this->startBoard as $color => $figures) {
            foreach ($figures as $pos => $figureClass) {
                $this->board->addFigure(
                    new $figureClass(new Position($pos), $this->players[$color])
                );
            }
        }
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function move(Position $oldPos, Position $newPos): void
    {
        $figure = $this->board->getFigureFromPosition($oldPos);

        if ($figure === null) {
            throw new InvalidMoveException(sprintf('On square %s is no figure.', $oldPos->toString()));
        }

        if ($figure->getColor() !== $this->currentPlayer) {
            throw new FigureDoesNotMatchPlayerException(
                sprintf(
                    'The figure %s is %s but the current player is %s.',
                    $figure->getName(),
                    $figure->getColor()->isWhite() ? 'white' : 'black',
                    $this->currentPlayer->isWhite() ? 'white' : 'black'
                )
            );
        }
        $figure->move($newPos, $this->board);
        $this->nextPlayer();
    }

    private function nextPlayer(): void
    {
        foreach ($this->players as $player) {
            if ($player === $this->currentPlayer) {
                continue;
            }
            $this->currentPlayer = $player;

            return;
        }
    }

    public function getCurrentPlayer(): Color
    {
        return $this->currentPlayer;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
