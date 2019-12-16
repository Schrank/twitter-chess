<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

interface Figure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(): array;

    public function getPosition(): Position;

    public function getIcon(): string;

    public function getName(): string;
}
