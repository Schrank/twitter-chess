<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\FigureDoesNotMatchPlayerException;
use Schrank\TwitterChess\Exception\InvalidMoveException;
use Schrank\TwitterChess\Figure\Bishop;
use Schrank\TwitterChess\Figure\King;
use Schrank\TwitterChess\Figure\Knight;
use Schrank\TwitterChess\Figure\Pawn;
use Schrank\TwitterChess\Figure\Queen;
use Schrank\TwitterChess\Figure\Rook;

class Chess implements \JsonSerializable, Game
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

    public function __construct(string $id, Board $board = null, Color $currentPlayer = null)
    {
        $this->board   = $board ?? new Board();
        $this->players = [
            Color::WHITE => Color::white(),
            Color::BLACK => Color::black()
        ];

        $currentPlayer       = $currentPlayer ? $currentPlayer->toString() : Color::WHITE;
        $this->currentPlayer = $this->players[$currentPlayer];
        $this->init();
        $this->id = $id;
    }

    public static function fromJson($jsonString): string
    {

    }

    private function init(): void
    {
        $board = $this->getBoard();
        foreach ($this->startBoard as $color => $figures) {
            foreach ($figures as $pos => $figureClass) {
                $board->addFigure(
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
        }
    }

    public function getCurrentPlayer(): Color
    {
        return $this->currentPlayer;
    }

    public function jsonSerialize(): string
    {
        return json_encode([
            'board'         => $this->board->jsonSerialize(),
            'currentPlayer' => $this->currentPlayer->toString(),
            'id'            => $this->getId(),
        ], JSON_THROW_ON_ERROR, 512);
    }

    public function getId(): string
    {
        return $this->id;
    }
}
