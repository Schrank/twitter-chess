<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\Game;

class FilePersister implements Persister
{

    private const SAVE_GAME_PATH = __DIR__ . '/../../games/%s.game';

    public function save(Game $game): void
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



        }

        return new Chess($id);
    }
}
