<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Figure;

use Schrank\TwitterChess\Exception\InvalidPositionException;
use Schrank\TwitterChess\Position;

class King extends AbstractFigure
{
    /**
     * @return Position[]
     */
    public function getValidPositions(): array
    {
        $validPositions = [];
        for ($row = -1; $row <= 1; $row++) {
            for ($column = -1; $column <= 1; $column++) {
                try {
                    $position = Position::createFromInts(
                        $this->position->getColumn() + $column,
                        $this->position->getRow() + $row
                    );
                    if (!$position->equals($this->position)) {
                        $validPositions[] = $position;
                    }
                } catch (InvalidPositionException $e) {
                    // do nothing, invalid positions are discarded
                }
            }
        }

        return $validPositions;
    }

    public function getIcon(): string
    {
        if ($this->color->isWhite()) {
            return '🤵';
        }

        return '🤴';

    }
}
