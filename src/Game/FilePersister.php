<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\Exception\InvalidJsonDataException;
use Schrank\TwitterChess\Game;

class FilePersister implements Persister
{

    private const SAVE_GAME_PATH = __DIR__ . '/../../games/%s.game';

    public function save(Game $game)
    {
        $return = file_put_contents(
            sprintf(self::SAVE_GAME_PATH, $game->getId()),
            $game->jsonSerialize(),
            FILE_APPEND
        );
        if ($return === false) {
            throw new \RuntimeException(
                sprintf('Chess "%s" could not be saved.', $game->getId())
            );
        }
    }

    public function load(string $id): Game
    {
        $saveGamePath = sprintf(self::SAVE_GAME_PATH, $id);
        if (file_exists($saveGamePath)) {
            $lines    = file($saveGamePath);
            $lastLine = array_pop($lines);
            try {
                $gameData = json_decode($lastLine, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new InvalidJsonDataException('Json serialized data are invalid.', 0, $e);
            }

            $this->validateData($gameData);
        }

        return new Chess($id);
    }

    /**
     * @param string[] $gameData
     */
    private function validateData(array $gameData): void
    {
        if (!isset($gameData['board'])) {
            throw new InvalidJsonDataException('Json serialized data does not contain board data.');
        }
    }
}
