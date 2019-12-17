<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Figure\Bishop;
use Schrank\TwitterChess\Figure\King;
use Schrank\TwitterChess\Figure\Knight;
use Schrank\TwitterChess\Figure\Pawn;
use Schrank\TwitterChess\Figure\Queen;
use Schrank\TwitterChess\Figure\Rook;

class Game
{
    private Board $board;
    /**
     * @var string[]
     */
    private array $initBoard
        = [
            'white' =>
                [
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
            'black' => [
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
        $this->board = new Board();
    }

    public function init(): void
    {
        $board = $this->getBoard();
        foreach ($this->initBoard as $color => $figures) {
            foreach ($figures as $pos => $figureClass) {
                $board->addFigure(
                    new $figureClass(new Position($pos), Color::$color())
                );
            }
        }
    }

    public function move(Position $oldPos, Position $newPos): void
    {
        $this->board->getFigureFromPosition($oldPos)->move($newPos);
    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
