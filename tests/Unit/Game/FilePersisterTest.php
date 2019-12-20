<?php

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Schrank\TwitterChess\Chess;
use Schrank\TwitterChess\Exception\InvalidJsonDataException;

class FilePersisterTest extends TestCase
{
    private FilePersister $persister;

    public static string $filePutContentsfilename = '';
    public static string $filePutContentsdata;
    public static int $filePutContentsflags;
    public static /** @noinspection PhpMissingFieldTypeInspection */
        $filePutContentsReturn;
    public static array $fileReturn;
    public static string $fileFilename;
    public static bool $fileExistsReturn;
    public static string $fileExistsFilename;

    public function testImplementsPersister(): void
    {
        $this->assertInstanceOf(Persister::class, $this->persister);
    }

    public function testSave(): void
    {
        $content = 'A';
        $id      = uniqid('', true);
        $game    = $this->createMock(Chess::class);

        $game->method('jsonSerialize')->willReturn($content);
        $game->method('getId')->willReturn($id);

        $this->persister->save($game);

        $this->assertSame($content, self::$filePutContentsdata);
        $this->assertStringEndsWith('.game', self::$filePutContentsfilename);
        $this->assertStringEndsNotWith('.game.game', self::$filePutContentsfilename);
        $this->assertSame(self::$filePutContentsflags, FILE_APPEND);
    }

    public function testThrowsErrorOnFalseSave(): void
    {
        $id = 'abc';

        $this->expectException(RuntimeException::class);
        self::$filePutContentsReturn = false;
        $this->expectExceptionMessage("Chess \"$id\" could not be saved.");

        $game = $this->createMock(Chess::class);
        $game->method('getId')->willReturn($id);
        $this->persister->save($game);
    }

    public function testThrowsExceptionIfJsonDoesNotContainBoard(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain board data.');
        self::$fileExistsReturn = true;
        self::$fileReturn       = ['[]'];

        $this->persister->load('abc');
    }

    public function testThrowsExceptionIfJsonIsInvalid(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data are invalid.');
        self::$fileExistsReturn = true;
        self::$fileReturn       = ['d'];

        $this->persister->load('abc');
    }

    public function testLoadReturnsLastEntryFromFile(): void
    {
        $this->markTestIncomplete();

        return;

        self::$fileExistsReturn = true;
        self::$fileReturn       = [
            'a',
            'b',
            'c'
        ];

        $id   = 'abc';
        $game = $this->persister->load($id);

        $this->assertStringEndsWith("games/$id.game", self::$fileExistsFilename);
        $this->assertStringEndsWith("games/$id.game", self::$fileFilename);
    }

    public function testReturnsNewGameIfNotFound(): void
    {
        $gameId = uniqid('', true);

        $game = new Chess($gameId);

        $this->assertJsonStringEqualsJsonString(
            $game->jsonSerialize(),
            $this->persister->load($gameId)->jsonSerialize()
        );
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
