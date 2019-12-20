<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

interface Persister
{
    public function save(string $id, string $game): void;

    public function load(string $id): string;
}
