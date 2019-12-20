<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Figure;
use Schrank\TwitterChess\Position;

class FigureFactory
{
    private Color $whitePlayer;
    private Color $blackPlayer;

    public function __construct(Color $whitePlayer, Color $blackPlayer)
    {
        $this->whitePlayer = $whitePlayer;
        $this->blackPlayer = $blackPlayer;
    }

    public function createFromIcon(string $icon, string $pos): Figure
    {
        switch ($icon) {
            case '🏃':
                return new Bishop(new Position($pos), $this->whitePlayer);
            case '🧝':
                return new Bishop(new Position($pos), $this->blackPlayer);

            case '🤵':
                return new King(new Position($pos), $this->whitePlayer);
            case '🤴':
                return new King(new Position($pos), $this->blackPlayer);

            case '🏰':
                return new Rook(new Position($pos), $this->whitePlayer);
            case '🗼':
                return new Rook(new Position($pos), $this->blackPlayer);

            case '👰':
                return new Queen(new Position($pos), $this->whitePlayer);
            case '👸':
                return new Queen(new Position($pos), $this->blackPlayer);

            case '👮':
                return new Pawn(new Position($pos), $this->whitePlayer);
            case '💂':
                return new Pawn(new Position($pos), $this->blackPlayer);

            case '🦥':
                return new Knight(new Position($pos), $this->whitePlayer);
            case '🐴':
                return new Knight(new Position($pos), $this->blackPlayer);
        }
    }
}
