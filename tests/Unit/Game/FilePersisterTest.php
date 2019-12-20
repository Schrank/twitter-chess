<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Game;

class FilePersisterTest extends TestCase
{
    public static string $filename = '';
    public static string $data;
    public static int $flags;
    public static int $filePutContentsReturn;
    private FilePersister $persister;

    public function testImplementsPersister(): void
    {
        $this->assertInstanceOf(Persister::class, $this->persister);
    }

    public function testSave(): void
    {
        $content = 'A';
        $id      = uniqid('', true);
        $game    = $this->createMock(Game::class);

        $game->method('jsonSerialize')->willReturn($content);
        $game->method('getId')->willReturn($id);

        $this->persister->save($game);

        $this->assertSame($content, self::$data);
        $this->assertStringEndsWith('.game', self::$filename);
        $this->assertStringEndsNotWith('.game.game', self::$filename);
        $this->assertSame(self::$flags, FILE_APPEND);
    }

    public function testThrowsErrorOnFalseSave()
    {

    }

    protected function setUp(): void
    {
        $this->persister = new FilePersister();
    }

    protected function tearDown(): void
    {
        self::$filename              = '';
        self::$data                  = '';
        self::$flags                 = 0;
        self::$filePutContentsReturn = 0;
    }
}

function file_put_contents(
    string $filename,
    $data,
    /** @noinspection PhpOptionalBeforeRequiredParametersInspection */ int $flags = 0
): int {
    FilePersisterTest::$data     = $data;
    FilePersisterTest::$filename = $filename;
    FilePersisterTest::$flags    = $flags;

    return FilePersisterTest::$filePutContentsReturn;
}

