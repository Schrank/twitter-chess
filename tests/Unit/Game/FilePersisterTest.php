<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Schrank\TwitterChess\Exception\GameNotFoundException;

/**
 * @covers \Schrank\TwitterChess\Game\FilePersister
 */
class FilePersisterTest extends TestCase
{
    public static string $filePutContentsfilename = '';
    public static string $filePutContentsdata;
    public static int $filePutContentsflags;
    public static /** @noinspection PhpMissingFieldTypeInspection */
        $filePutContentsReturn;
    public static array $fileReturn;
    public static string $fileFilename;
    public static bool $fileExistsReturn;
    public static string $fileExistsFilename;
    private FilePersister $persister;

    public function testImplementsPersister(): void
    {
        $this->assertInstanceOf(Persister::class, $this->persister);
    }

    public function testSave(): void
    {
        $id   = uniqid('', true);
        $game = 'game_data';

        $this->persister->save($id, $game);

        $this->assertSame($game, self::$filePutContentsdata);
        $this->assertStringEndsWith('.game', self::$filePutContentsfilename);
        $this->assertStringEndsNotWith('.game.game', self::$filePutContentsfilename);
        $this->assertSame(self::$filePutContentsflags, FILE_APPEND);
    }

    public function testThrowsErrorOnFalseSave(): void
    {
        $id   = 'abc';
        $game = 'game_data';

        $this->expectException(RuntimeException::class);
        self::$filePutContentsReturn = false;
        $this->expectExceptionMessage("Game \"$id\" could not be saved.");

        $this->persister->save($id, $game);
    }

    public function testLoadReturnsLastEntryFromFile(): void
    {
        self::$fileExistsReturn = true;
        $gameData               = 'c';
        self::$fileReturn       = [
            'a',
            'b',
            $gameData
        ];

        $this->assertSame($gameData, $this->persister->load('abc'));
        $this->assertStringEndsWith("games/abc.game", self::$fileExistsFilename);
        $this->assertStringEndsWith("games/abc.game", self::$fileFilename);
    }

    public function testThrowsExceptionIfGameIsNotFound(): void
    {
        $id = '1234';
        $this->expectExceptionMessage("Game \"$id\" could not be found.");
        $this->expectException(GameNotFoundException::class);

        $this->persister->load($id);
    }

    protected function setUp(): void
    {
        $this->persister = new FilePersister();

        self::$filePutContentsfilename = '';
        self::$filePutContentsdata     = '';
        self::$filePutContentsflags    = 0;
        self::$filePutContentsReturn   = 0;

        self::$fileFilename = '';
        self::$fileReturn   = [];

        self::$fileExistsFilename = '';
        self::$fileExistsReturn   = false;
    }
}

function file_put_contents(
    string $filename,
    $data,
    /** @noinspection PhpOptionalBeforeRequiredParametersInspection */ int $flags = 0
) {
    FilePersisterTest::$filePutContentsdata     = $data;
    FilePersisterTest::$filePutContentsfilename = $filename;
    FilePersisterTest::$filePutContentsflags    = $flags;

    return FilePersisterTest::$filePutContentsReturn;
}

function file(string $filename): array
{
    FilePersisterTest::$fileFilename = $filename;

    return FilePersisterTest::$fileReturn;
}

function file_exists($filename): bool
{
    FilePersisterTest::$fileExistsFilename = $filename;

    return FilePersisterTest::$fileExistsReturn;
}

function mkdir($pathname)
{
    // do nothing
}
