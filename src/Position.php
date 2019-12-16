<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use Schrank\TwitterChess\Exception\InvalidPositionException;

class Position
{
    //    private string $pos;
    private static array $columnMapping
        = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
            7 => 'G',
            8 => 'H'
        ];
    private string $pos;

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
        return new self(self::$columnMapping[$column + 1] . $row);
    }

    public function toString(): string
    {
        return $this->pos;
    }

    /**
     * @return int[]
     */
    public function toIntArray(): array
    {
        [, $row] = str_split($this->pos);

        return [$this->getColumn(), (int)$row];
    }

    public function getColumn(): int
    {
        [$column] = str_split($this->pos);

        return (int)array_flip(self::$columnMapping)[$column];
    }

    public function getRow(): int
    {
        [, $row] = str_split($this->pos);

        return (int)$row;
    }

    public function equals(Position $compareWith): bool
    {
        return $this->getRow() === $compareWith->getRow() && $this->getColumn() === $compareWith->getColumn();
    }
}
