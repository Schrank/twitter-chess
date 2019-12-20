<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Web;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\Game\Persister;
use Schrank\TwitterChess\Game\Serializer;

class ApiTest extends TestCase
{
    private Api $api;
    private Persister $persiter;
    private Serializer $serializer;

    public function testMove(): void
    {
        $from = 'A2';
        $to   = 'A4';
        $id   = uniqid('', true);

        // TODO change with mock of Game after Serialization is refactored
        $gameMock  = $this->createMock(Chess::class);
        $boardMock = $this->createMock(Board::class);
        $newBoard  = ['NEW BOARD'];
        $boardMock->method('toArray')->willReturn($newBoard);
        $gameMock->method('getBoard')->willReturn($boardMock);

        $this->persiter->method('load')->with($id);
        $this->serializer->method('unserialize')->willReturn($gameMock);
        $this->assertSame($newBoard, $this->api->move($from, $to, $id));
    }

    protected function setUp(): void
    {
        $this->persiter   = $this->createMock(Persister::class);
        $this->serializer = $this->createMock(Serializer::class);
        $this->api        = new Api($this->persiter, $this->serializer);
    }

}
