<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

interface Game
{
    public function getBoard(): Board;

    public function move(Position $oldPos, Position $newPos): void;

    public function getCurrentPlayer(): Color;

    public function getId(): string;
}
