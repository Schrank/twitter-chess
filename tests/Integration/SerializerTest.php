<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Integration;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Game\Serializer;

class SerializerTest extends TestCase
{
    private $startBoard
        = [
            'A1' => '🏰',
            'B1' => '🦥',
            'C1' => '🏃',
            'D1' => '🤵',
            'E1' => '👰',
            'F1' => '🏃',
            'G1' => '🦥',
            'H1' => '🏰',
            'A2' => '👮',
            'B2' => '👮',
            'C2' => '👮',
            'D2' => '👮',
            'E2' => '👮',
            'F2' => '👮',
            'G2' => '👮',
            'H2' => '👮',
            'A8' => '🗼',
            'B8' => '🐴',
            'C8' => '🧝',
            'D8' => '🤴',
            'E8' => '👸',
            'F8' => '🧝',
            'G8' => '🐴',
            'H8' => '🗼',
            'A7' => '💂',
            'B7' => '💂',
            'C7' => '💂',
            'D7' => '💂',
            'E7' => '💂',
            'F7' => '💂',
            'G7' => '💂',
            'H7' => '💂',
        ];

    public function testSerialize(): void
    {
        $id         = uniqid('', true);
        $game       = new Game($id);
        $serializer = new Serializer();
        $result     = json_decode($serializer->serialize($game), true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame(Color::WHITE, $result['currentPlayer']);
        $this->assertSame($id, $result['id']);
        $this->assertSame($this->startBoard, $result['board']);
    }
}
