<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Exception\GameNotFoundException;

class FilePersister implements Persister
{

    private const SAVE_GAME_PATH = __DIR__ . '/../../games/%s.game';

    public function save(string $id, string $game): void
    {
        $directory = dirname(self::SAVE_GAME_PATH);
        if (!is_dir($directory) && !mkdir($directory) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        $return = file_put_contents(
            sprintf(self::SAVE_GAME_PATH, $id),
            $game . "\n",
            FILE_APPEND
        );

        if ($return === false) {
            throw new \RuntimeException(
                sprintf('Game "%s" could not be saved.', $id)
            );
        }
    }

    public function load(string $id): string
    {
        $saveGamePath = sprintf(self::SAVE_GAME_PATH, $id);
        if (!file_exists($saveGamePath)) {
            throw new GameNotFoundException(sprintf('Game "%s" could not be found.', $id));

        }
        $lines = file($saveGamePath);

        return array_pop($lines);
    }
}
