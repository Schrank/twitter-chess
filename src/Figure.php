<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

interface Figure
{
    public function move(Position $p);

    public function isValid(Position $p): bool;
}
