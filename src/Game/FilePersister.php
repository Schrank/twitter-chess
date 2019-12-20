<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Game;

class FilePersister implements Persister
{

    public function save(Game $game)
    {
        file_put_contents(__DIR__ . '/../../games/' . $game->getId() . '.game', $game->jsonSerialize(), FILE_APPEND);
    }

    public function load(): Game
    {
        // TODO: Implement load() method.
    }
}
