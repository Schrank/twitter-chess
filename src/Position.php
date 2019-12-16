<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\InvalidPositionException;

class Position
{
    //    private string $pos;
    private $pos;

    public function __construct(string $pos)
    {
        if (strlen($pos) !== 2) {
            throw new InvalidPositionException('Position must be a 2 character string like A1');
        }
        [$column, $row] = str_split($pos);
        $row = (int)$row;
        if (!in_array($column, range('A', 'H'), true)) {
            throw new InvalidPositionException('Column must be between A and H');
        }
        if (!in_array($row, range(1, 8), true)) {
            throw new InvalidPositionException('Row must be between 1 and 8');
        }

        $this->pos = $pos;
    }

    public static function createFromInts($column, $row): self
    {
        $columnMapping = range('A', 'H');

        return new self($columnMapping[$column + 1] . $row);
    }

    public function toString(): string
    {
        return $this->pos;
    }
}
