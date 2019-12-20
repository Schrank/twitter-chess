<?php /** @noinspection UnusedFunctionResultInspection */

declare(strict_types=1);

namespace Schrank\TwitterChess\Game;

use PHPUnit\Framework\TestCase;
use Schrank\TwitterChess\Color;
use Schrank\TwitterChess\Exception\InvalidJsonDataException;

/**
 * @covers \Schrank\TwitterChess\Game\Serializer
 */
class SerializerTest extends TestCase
{
    private Serializer $serializer;

    public function testCurrentPlayerAfterUnserialize(): void
    {
        $currentPlayer = Color::BLACK;
        $data          = json_encode([
            'board'         => [
                'A1' => '🏰',
                'H5' => '🦥',
                'B6' => '🏃',
                'A2' => '🏃',
                'F5' => '🦥',
                'C3' => '🏰',
            ],
            'currentPlayer' => $currentPlayer,
            'id'            => uniqid('', true)
        ], JSON_THROW_ON_ERROR, 512);

        $game = $this->serializer->unserialize($data);
        $this->assertSame($currentPlayer, $game->getCurrentPlayer()->toString());
    }

    public function testThrowsExceptionIfJsonDoesNotContainBoard(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain board data.');

        $data = '[]';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonDoesNotContainCurrentPlayer(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain current player.');

        $data = '{"board":"lala"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfCurrentPlayerIsNeitherWhiteNorBlack(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain current player.');

        $data = '{"board":"lala","currentPlayer":"grey"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonDoesNotContainId(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data does not contain game id.');

        $data = '{"board":"lala","currentPlayer":"white"}';

        $this->serializer->unserialize($data);
    }

    public function testThrowsExceptionIfJsonIsInvalid(): void
    {
        $this->expectException(InvalidJsonDataException::class);
        $this->expectExceptionMessage('Json serialized data are invalid.');

        $data = 'd';

        $this->serializer->unserialize($data);
    }

    protected function setUp(): void
    {
        $this->serializer = new Serializer();
    }

}
