<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Web;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Board;
use Schrank\TwitterChess\Game;
use Schrank\TwitterChess\Exception\GameNotFoundException;
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
        $gameMock  = $this->createMock(Game::class);
        $boardMock = $this->createMock(Board::class);
        $newBoard  = ['NEW BOARD'];
        $boardMock->method('toArray')->willReturn($newBoard);
        $gameMock->method('getBoard')->willReturn($boardMock);

        $this->persiter->expects($this->once())->method('load')->with($id);
        $this->serializer->expects($this->once())->method('unserialize')->willReturn($gameMock);
        $this->assertSame($newBoard, $this->api->move($from, $to, $id));
    }

    public function testLoad(): void
    {
        $id = uniqid('', true);

        $gameMock  = $this->createMock(Game::class);
        $boardMock = $this->createMock(Board::class);
        $newBoard  = ['BOARD'];
        $boardMock->expects($this->once())->method('toArray')->willReturn($newBoard);
        $gameMock->expects($this->once())->method('getBoard')->willReturn($boardMock);

        $this->persiter->method('load')->with($id);
        $this->serializer->method('unserialize')->willReturn($gameMock);
        $this->assertSame($newBoard, $this->api->load($id));
    }

    public function testReturnsNewGameIfNotFound(): void
    {
        $this->persiter->method('load')->willThrowException(new GameNotFoundException());
        $this->persiter->expects($this->once())->method('save');
        $this->assertSame(
            $this->getNewGameArray(),
            $this->api->load(uniqid('', true))
        );
    }

    private function getNewGameArray(): array
    {
        return [
            '🗼', '🐴','🧝','🤴','👸','🧝','🐴','🗼',
            '💂','💂','💂','💂','💂','💂','💂','💂',
            '⬜','⬛','⬜','⬛','⬜','⬛','⬜','⬛',
            '⬛','⬜','⬛','⬜','⬛','⬜','⬛','⬜',
            '⬜','⬛','⬜','⬛','⬜','⬛','⬜','⬛',
            '⬛','⬜','⬛','⬜','⬛','⬜','⬛','⬜',
            '👮','👮','👮','👮','👮','👮','👮','👮',
            '🏰','🦥','🏃','🤵','👰','🏃','🦥','🏰',
        ];
    }

    protected function setUp(): void
    {
        $this->persiter   = $this->createMock(Persister::class);
        $this->serializer = $this->createMock(Serializer::class);
        $this->api        = new Api($this->persiter, $this->serializer);
    }

}
