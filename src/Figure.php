<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

interface Figure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(): array;
}
