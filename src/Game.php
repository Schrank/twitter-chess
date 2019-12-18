<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Figure\Bishop;
use Schrank\TwitterChess\Figure\King;
use Schrank\TwitterChess\Figure\Knight;
use Schrank\TwitterChess\Figure\Pawn;
use Schrank\TwitterChess\Figure\Queen;
use Schrank\TwitterChess\Figure\Rook;

class Game
{
    private array $players;
    private Color $currentPlayer;
    private Board $board;

    /**
     * @var string[]
     */
    private array $initBoard
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

    public function __construct()
    {
        $this->board   = new Board();
        $this->players = [Color::WHITE => Color::white(), Color::BLACK => Color::black()];
        $this->init();
    }

    private function init(): void
    {
        $this->currentPlayer = $this->players[Color::WHITE];
        $board               = $this->getBoard();
        foreach ($this->initBoard as $color => $figures) {
            foreach ($figures as $pos => $figureClass) {
                $board->addFigure(
                    new $figureClass(new Position($pos), $this->players[$color])
                );
            }
        }
    }

    public function move(Position $oldPos, Position $newPos): void
    {
        $figure = $this->board->getFigureFromPosition($oldPos);

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
        $figure->move($newPos);
        $this->nextPlayer();
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getCurrentPlayer(): Color
    {
        return $this->currentPlayer;
    }

    private function nextPlayer(): void
    {
        foreach ($this->players as $player) {
            if ($player === $this->currentPlayer) {
                continue;
            }
            $this->currentPlayer = $player;
        }
    }
}
