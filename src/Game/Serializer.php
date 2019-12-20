<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\ChessBoard;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\InvalidJsonDataException;
use Schrank\TwitterChess\Figure\FigureFactory;
use Schrank\TwitterChess\Game;

class Serializer
{
    public function unserialize(string $json): Game
    {
        $data = $this->decode($json);
        $this->validateData($data);
        $board = new ChessBoard();
        /** @var Color $current */
        $current = Color::{$data['currentPlayer']}();
        $second  = $current->isWhite() ? Color::black() : Color::white();

        $factory = new FigureFactory(
            $current->isWhite() ? $current : $second,
            $current->isWhite() ? $second : $current
        );

        foreach ($data['board'] as $pos => $figure) {
            $board->addFigure($factory->createFromIcon($figure, $pos));
        }

        return new Chess($data['id'], $board, $current, $second);
    }

    /**
     * @param string $data
     *
     * @return string[]
     */
    private function decode(string $data): array
    {
        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (\JsonException $e) {
            throw new InvalidJsonDataException('Json serialized data are invalid.', 0, $e);
        }
    }

    /**
     * @param string[] $data
     */
    private function validateData(array $data): void
    {
        if (!isset($data['board'])) {
            throw new InvalidJsonDataException('Json serialized data does not contain board data.');
        }
        if (!isset($data['currentPlayer'])
            || !in_array($data['currentPlayer'], [Color::WHITE, Color::BLACK], true)) {
            throw new InvalidJsonDataException('Json serialized data does not contain current player.');
        }
        if (!isset($data['id'])) {
            throw new InvalidJsonDataException('Json serialized data does not contain game id.');
        }
    }
}
