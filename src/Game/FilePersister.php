<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Game;

class FilePersister implements Persister
{

    public function save(Game $game)
    {
        $return = file_put_contents(
            __DIR__ . '/../../games/' . $game->getId() . '.game',
            $game->jsonSerialize(),
            FILE_APPEND
        );
        if ($return === false) {
            throw new \RuntimeException(
                sprintf('Game "%s" could not be saved.', $game->getId())
            );
        }
    }

    public function load(): Game
    {
        // TODO: Implement load() method.
    }
}
