<?php

declare(strict_types=1);

namespace Schrank\TwitterChess;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private Game $game;
    private string $id;

    public function testInstanceOfJsonSerializable(): void
    {
        $this->assertInstanceOf(\JsonSerializable::class, $this->game);
    }

    public function testReturnId()
    {
        $this->assertSame($this->id, $this->game->getId());
    }

    protected function setUp(): void
    {
        $this->id   = uniqid('', true);
        $this->game = new Game($this->id);
    }
}
