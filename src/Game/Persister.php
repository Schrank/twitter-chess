<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use Schrank\TwitterChess\Game;

interface Persister
{
    public function save(Game $game);

    public function load(string $id): Game;
}
