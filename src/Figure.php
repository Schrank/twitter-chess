<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

interface Figure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(Board $board): array;

    public function getPosition(): Position;

    public function getIcon(): string;

    public function getName(): string;

    public function move(Position $position, Board $board): void;

    public function getColor(): Color;
}
