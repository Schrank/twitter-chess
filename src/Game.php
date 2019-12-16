<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

class Game
{
    private Board $board;

    public function __construct()
    {
        $this->board = new Board();
    }

    public function init()
    {

    }

    public function getBoard(): Board
    {
        return $this->board;
    }
}
